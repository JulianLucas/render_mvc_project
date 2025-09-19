<?php
session_start();

$action = $_GET['action'] ?? ($_POST['action'] ?? 'home');

require_once __DIR__ . '/controller/usuarioController.php';

function require_login(): void {
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
        exit;
    }
}

switch ($action) {
    case 'list':
        require_login();
        $usuarios = ctrl_listar($conexion);
        include __DIR__ . '/view/lista.php';
        break;

    case 'create':
        require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }
        $nombre = $_POST['nombre'] ?? '';
        if (ctrl_crear($conexion, $nombre)) {
            header('Location: index.php?action=list&status=created');
        } else {
            header('Location: index.php?error=invalid');
        }
        exit;

    default:
        include __DIR__ . '/view/formulario.php';
        break;
}