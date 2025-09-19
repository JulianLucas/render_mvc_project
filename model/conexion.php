<?php
// Credenciales desde variables de entorno (útil para Render). Valores por defecto para desarrollo local.
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'web2';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_port = (int)(getenv('DB_PORT') ?: 3306);

// Conexión MySQLi usando host, usuario, contraseña, base y puerto
$conexion = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);
if (!$conexion) {
    http_response_code(500);
    echo "Error de conexión a MySQL: " . mysqli_connect_error();
    exit;
}

// Establecer charset moderno para evitar problemas de acentos/emoji y prevenir corrupción
if (!mysqli_set_charset($conexion, 'utf8mb4')) {
    // No es crítico para cortar la ejecución, pero informamos
    error_log('No se pudo establecer charset utf8mb4: ' . mysqli_error($conexion));
}
?>