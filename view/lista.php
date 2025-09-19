<?php /** @var array $usuarios */ ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Usuarios (MVC)</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <header class="site-header" role="banner">
    <div class="container">
      <h1>Usuarios</h1>
    </div>
  </header>

  <nav class="site-nav" role="navigation" aria-label="Principal">
    <div class="container">
      <ul>
        <li><a href="index.html">Inicio</a></li>
        <li><a href="index.php?action=list" aria-current="page">Listar (MVC)</a></li>
        <li><a href="logout.php">Cerrar sesión (<?php echo htmlspecialchars($_SESSION['usuario']); ?>)</a></li>
      </ul>
    </div>
  </nav>

  <main class="container" role="main">
    <?php if (isset($_GET['status'])): ?>
      <p role="status" aria-live="polite">
        <?php
          $status = $_GET['status'];
          if ($status === 'created') echo 'Usuario creado correctamente.';
          elseif ($status === 'updated') echo 'Usuario actualizado correctamente.';
          elseif ($status === 'deleted') echo 'Usuario eliminado correctamente.';
        ?>
      </p>
    <?php endif; ?>

    <section aria-labelledby="titulo-lista">
      <h2 id="titulo-lista">Lista de usuarios</h2>
      <?php if (empty($usuarios)): ?>
        <p>No hay usuarios registrados todavía.</p>
      <?php else: ?>
        <table role="table" style="width:100%; border-collapse: collapse">
          <thead>
            <tr>
              <th style="text-align:left; border-bottom:1px solid #e2e8f0; padding:.5rem">ID</th>
              <th style="text-align:left; border-bottom:1px solid #e2e8f0; padding:.5rem">Nombre</th>
              <th style="text-align:left; border-bottom:1px solid #e2e8f0; padding:.5rem">Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($usuarios as $row): ?>
            <tr>
              <td style="padding:.5rem; border-bottom:1px solid #f1f5f9"><?php echo (int)$row['id']; ?></td>
              <td style="padding:.5rem; border-bottom:1px solid #f1f5f9"><?php echo htmlspecialchars($row['nombre']); ?></td>
              <td style="padding:.5rem; border-bottom:1px solid #f1f5f9; display:flex; gap:.5rem; align-items:center">
                <a class="btn secondary" href="editar.php?id=<?php echo (int)$row['id']; ?>">Editar</a>
                <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Eliminar el usuario &quot;<?php echo htmlspecialchars($row['nombre']); ?>&quot;?');" style="display:inline">
                  <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                  <button type="submit" class="btn">Eliminar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>

    <section aria-labelledby="titulo-registrar">
      <h2 id="titulo-registrar">Registrar nuevo usuario</h2>
      <form action="index.php?action=create" method="POST">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input id="nombre" name="nombre" type="text" required>
        </div>
        <button type="submit" class="btn">Registrar</button>
      </form>
    </section>
  </main>
</body>
</html>
