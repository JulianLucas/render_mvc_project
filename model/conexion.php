<?php
$conexion = mysqli_connect("localhost", "root", "", "web2");
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