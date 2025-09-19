<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: listar.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    if ($usuario === '') {
        $error = 'El usuario es requerido';
    } else {
        session_regenerate_id(true); // Mitigar fijación de sesión
        $_SESSION['usuario'] = $usuario;
        header('Location: listar.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <header class="site-header" role="banner">
    <div class="container">
      <h1>Iniciar sesión</h1>
    </div>
  </header>

  <nav class="site-nav" role="navigation" aria-label="Principal">
    <div class="container">
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="login.php" aria-current="page">Login</a></li>
      </ul>
    </div>
  </nav>

  <main class="container" role="main">
    <?php if ($error): ?>
      <p role="alert" style="color:#b91c1c; font-weight:600;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST" aria-describedby="ayuda-login">
      <div class="form-group">
        <label for="usuario">Usuario</label>
        <input id="usuario" name="usuario" type="text" required placeholder="Ej. admin" autocomplete="username">
      </div>
      <button type="submit" class="btn">Entrar</button>
      <p id="ayuda-login" class="form-help">Ingresa un nombre de usuario para iniciar sesión.</p>
    </form>
  </main>
</body>
</html>
