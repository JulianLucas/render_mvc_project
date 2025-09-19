<?php
require_once __DIR__ . '/../model/conexion.php';
require_once __DIR__ . '/../model/usuarioModel.php';

function ctrl_listar(mysqli $conexion): array {
    return usuario_todos($conexion);
}

function ctrl_crear(mysqli $conexion, string $nombre): bool {
    $nombre = trim($nombre);
    if ($nombre === '') return false;
    return usuario_crear($conexion, $nombre);
}

function ctrl_borrar(mysqli $conexion, int $id): bool {
    if ($id <= 0) return false;
    return usuario_borrar($conexion, $id);
}

function ctrl_por_id(mysqli $conexion, int $id): ?array {
    if ($id <= 0) return null;
    return usuario_por_id($conexion, $id);
}

function ctrl_actualizar(mysqli $conexion, int $id, string $nombre): bool {
    $nombre = trim($nombre);
    if ($id <= 0 || $nombre === '') return false;
    return usuario_actualizar($conexion, $id, $nombre);
}
