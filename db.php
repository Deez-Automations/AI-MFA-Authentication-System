<?php
/**
 * Database Connection
 * ===================
 * Establishes secure PDO connection to PostgreSQL database
 * using credentials from config.php
 * 
 * @package AI-MFA-Authentication-System
 * @author  Deez-Automations
 */

// Load configuration
require_once __DIR__ . '/config.php';

try {
    // Build connection string
    $dsn = sprintf(
        "pgsql:host=%s;dbname=%s",
        DB_HOST,
        DB_NAME
    );
    
    // PDO connection options
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    // Establish connection
    $conn = new PDO($dsn, DB_USER, DB_PASS, $options);
    
} catch (PDOException $e) {
    // Log error but don't expose details to user
    error_log("Database connection failed: " . $e->getMessage());
    
    if (APP_DEBUG) {
        die("Database connection failed: " . $e->getMessage());
    } else {
        die("Database connection failed. Please try again later.");
    }
}
?>
