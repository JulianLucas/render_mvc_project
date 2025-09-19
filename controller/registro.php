<?php
include("../model/conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método no permitido";
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
if ($nombre === '') {
    http_response_code(400);
    echo "El nombre es requerido.";
    exit;
}

$stmt = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre) VALUES (?)");
if (!$stmt) {
    http_response_code(500);
    echo "Error al preparar la consulta.";
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $nombre);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo "Error al insertar el usuario.";
    mysqli_stmt_close($stmt);
    exit;
}

mysqli_stmt_close($stmt);

// Redirigir a la lista con mensaje de éxito (requerirá login si la página está protegida)
header("Location: ../listar.php?status=created");
exit;
?>