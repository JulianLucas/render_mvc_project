<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . "/model/conexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Método no permitido";
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo "ID inválido.";
    exit;
}

$stmt = mysqli_prepare($conexion, "DELETE FROM usuarios WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    echo "Error al preparar la consulta.";
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);
if (!mysqli_stmt_execute($stmt)) {
    http_response_code(500);
    echo "Error al eliminar el usuario.";
    mysqli_stmt_close($stmt);
    exit;
}

mysqli_stmt_close($stmt);
header("Location: listar.php?status=deleted");
exit;
