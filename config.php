<?php
// Database configuration (supports Coolify environment variables)
$db_host = getenv('DB_HOST') ?: "localhost";
$db_user = getenv('DB_USERNAME') ?: "root";
$db_pass = getenv('DB_PASSWORD') ?: "";
$db_name = getenv('DB_DATABASE') ?: "noteit_db";
$db_port = getenv('DB_PORT') ? intval(getenv('DB_PORT')) : 3306;
 $app_debug = getenv('APP_DEBUG') === 'true' || getenv('APP_DEBUG') === '1';
 $use_ssl = getenv('DB_SSL') === 'true' || getenv('DB_SSL') === '1';

// Force TCP when using 'localhost' to avoid missing Unix socket inside containers
if ($db_host === 'localhost') {
    $db_host = '127.0.0.1';
}

// Create database connection
$conn = mysqli_init();
if ($conn === false) {
    die("Connection failed: unable to initialize MySQL client");
}

// Configure SSL if requested
if ($use_ssl) {
    // These envs are optional; when not set, client will use default CA bundle in image
    $ssl_ca = getenv('DB_SSL_CA') ?: null;
    $ssl_cert = getenv('DB_SSL_CERT') ?: null;
    $ssl_key = getenv('DB_SSL_KEY') ?: null;
    mysqli_ssl_set($conn, $ssl_key ?: null, $ssl_cert ?: null, $ssl_ca ?: null, null, null);
}

$connected = @mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, $db_port);
if (!$connected) {
    $error = mysqli_connect_error();
    if ($app_debug) {
        die("Connection failed: " . $error . " (host={$db_host}, port={$db_port}, user={$db_user})");
    }
    die("Connection failed: Please check database configuration.");
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");