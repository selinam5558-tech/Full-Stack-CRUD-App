<?php
// config.php
// Update these values for local development.
// For production, prefer environment variables.

$DB_HOST = getenv('DB_HOST') ?: 'crud-app-selinamcintyre07-2322.j.aivencloud.com';
$DB_NAME = getenv('DB_NAME') ?: 'crud_app';
$DB_USER = getenv('DB_USER') ?: 'avnadmin';
$DB_PASS = getenv('DB_PASS') ?: 'AVNS_6byV08x4wxGeggB_4Uq';

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    // In production, don't echo errors. Log them instead.
    echo "Database connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}
