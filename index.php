<?php
// Simple router: if logged-in dashboard exists, go there; else home.
if (file_exists(__DIR__ . '/home.php')) {
    require __DIR__ . '/home.php';
    exit;
}
if (file_exists(__DIR__ . '/dashboard.php')) {
    require __DIR__ . '/dashboard.php';
    exit;
}
echo 'Application entry not found.';
