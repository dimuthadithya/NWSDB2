<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'deviceRecordSystem');

// Create database connection
try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
