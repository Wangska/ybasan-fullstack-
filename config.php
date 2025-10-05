<?php
// Database configuration (supports Coolify environment variables)
$db_host = getenv('DB_HOST') ?: "localhost";
$db_user = getenv('DB_USERNAME') ?: "root";
$db_pass = getenv('DB_PASSWORD') ?: "";
$db_name = getenv('DB_DATABASE') ?: "noteit_db";
$db_port = getenv('DB_PORT') ? intval(getenv('DB_PORT')) : 3306;

// Force TCP when using 'localhost' to avoid missing Unix socket inside containers
if ($db_host === 'localhost') {
    $db_host = '127.0.0.1';
}

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");