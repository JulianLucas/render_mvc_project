<?php
// Modelo de usuarios: funciones CRUD con consultas preparadas

function usuario_todos(mysqli $conexion): array {
    $usuarios = [];
    $sql = "SELECT id, nombre FROM usuarios ORDER BY id DESC";
    $res = mysqli_query($conexion, $sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $usuarios[] = $row;
        }
    }
    return $usuarios;
}

function usuario_por_id(mysqli $conexion, int $id): ?array {
    $stmt = mysqli_prepare($conexion, "SELECT id, nombre FROM usuarios WHERE id = ?");
    if (!$stmt) return null;
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);
    return $row ?: null;
}

function usuario_crear(mysqli $conexion, string $nombre): bool {
    $stmt = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre) VALUES (?)");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "s", $nombre);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function usuario_actualizar(mysqli $conexion, int $id, string $nombre): bool {
    $stmt = mysqli_prepare($conexion, "UPDATE usuarios SET nombre = ? WHERE id = ?");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "si", $nombre, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function usuario_borrar(mysqli $conexion, int $id): bool {
    $stmt = mysqli_prepare($conexion, "DELETE FROM usuarios WHERE id = ?");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}
