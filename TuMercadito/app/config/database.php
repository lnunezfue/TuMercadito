<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tumercadito_db');

define('APPROOT', dirname(dirname(__FILE__)));

// --- CORRECCIÓN PARA NGROK (MIXED CONTENT) ---
// Verificamos si es HTTPS nativo O si viene de un proxy seguro (como Ngrok)
if (
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
    (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
) {
    $protocol = "https://";
} else {
    $protocol = "http://";
}

$host = $_SERVER['HTTP_HOST'];
define('URLROOT', $protocol . $host . '/TuMercadito');

define('SITENAME', 'TuMercadito');