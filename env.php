<?php
header('Content-Type: text/plain; charset=utf-8');

function read_env($key) {
    $v = getenv($key);
    if ($v !== false && $v !== '') return $v;
    if (!empty($_ENV[$key])) return $_ENV[$key];
    if (!empty($_SERVER[$key])) return $_SERVER[$key];
    return '';
}

$keys = ['DB_HOST','DB_PORT','DB_NAME','DB_USER','DB_SSL'];
foreach ($keys as $k) {
    $v = read_env($k);
    echo $k . '=' . ($v === '' ? '(empty)' : $v) . "\n";
}
$pass = read_env('DB_PASS');
$masked = $pass === '' ? '(empty)' : str_repeat('*', strlen((string)$pass));
echo 'DB_PASS=' . $masked . "\n";
