<?php

// Create database if not exists
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `ajira` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    
    echo "Database 'ajira' created or already exists." . PHP_EOL;
    
} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}

echo "Now you can run: php artisan migrate" . PHP_EOL;
?> 