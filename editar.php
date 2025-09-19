<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . "/model/conexion.php";

// Si es POST, procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nombre = trim($_POST['nombre'] ?? '');

    if ($id <= 0 || $nombre === '') {
        http_response_code(400);
        echo "Datos inválidos.";
        exit;
    }

    $stmt = mysqli_prepare($conexion, "UPDATE usuarios SET nombre = ? WHERE id = ?");
    if (!$stmt) {
        http_response_code(500);
        echo "Error al preparar la consulta.";
        exit;
    }
    mysqli_stmt_bind_param($stmt, "si", $nombre, $id);
    if (!mysqli_stmt_execute($stmt)) {
        http_response_code(500);
        echo "Error al actualizar el usuario.";
        mysqli_stmt_close($stmt);
        exit;
    }
    mysqli_stmt_close($stmt);
    header("Location: listar.php?status=updated");
    exit;
}

// Si es GET, obtener el usuario por id
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo "ID inválido.";
    exit;
}

$stmt = mysqli_prepare($conexion, "SELECT id, nombre FROM usuarios WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$usuario) {
    http_response_code(404);
    echo "Usuario no encontrado.";
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar usuario</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <header class="site-header" role="banner">
    <div class="container">
      <h1>Editar usuario</h1>
    </div>
  </header>

  <nav class="site-nav" role="navigation" aria-label="Principal">
    <div class="container">
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="listar.php">Listar</a></li>
        <li><a href="logout.php">Cerrar sesión (<?php echo htmlspecialchars($_SESSION['usuario']); ?>)</a></li>
      </ul>
    </div>
  </nav>

  <main class="container" role="main">
    <section aria-labelledby="titulo-editar">
      <h2 id="titulo-editar">Editar usuario #<?php echo (int)$usuario['id']; ?></h2>
      <form action="editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo (int)$usuario['id']; ?>">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input id="nombre" name="nombre" type="text" required value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
        </div>
        <button type="submit" class="btn">Actualizar</button>
        <a class="btn secondary" href="listar.php">Cancelar</a>
      </form>
    </section>
  </main>
</body>
</html>
