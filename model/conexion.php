<?php
// Credenciales desde variables de entorno (útil para Render). Valores por defecto para desarrollo local.
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'web2';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_port = (int)(getenv('DB_PORT') ?: 3306);
$db_ssl  = strtolower((string)(getenv('DB_SSL') ?: 'false')) === 'true';

// Conexión MySQLi: usamos mysqli_init para poder habilitar SSL si se requiere (p. ej. PlanetScale)
$conexion = mysqli_init();
if ($db_ssl) {
    // Para proveedores como PlanetScale, no se requieren archivos de certificado al usar mysqlnd.
    // Activamos SSL y forzamos el flag MYSQLI_CLIENT_SSL
    mysqli_ssl_set($conexion, null, null, null, null, null);
    $flags = MYSQLI_CLIENT_SSL;
} else {
    $flags = 0;
}

// Conectar (host, usuario, contraseña, base, puerto)
if (!@mysqli_real_connect($conexion, $db_host, $db_user, $db_pass, $db_name, $db_port, null, $flags)) {
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