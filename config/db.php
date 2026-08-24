<?php
/**
 * Database connection.
 * Update these four values to match your hosting environment
 * (cPanel/phpMyAdmin will show you the DB name, user, and password
 * once you create the database there).
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'rs8_racing');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // real prepared statements
        ]
    );
} catch (PDOException $e) {
    // In production, log this instead of printing it to visitors.
    die('Database connection failed. Please try again later.');
}
