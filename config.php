<?php
/**
 * Configuration Loader
 * ====================
 * Loads environment variables from .env file and provides
 * secure access to configuration values.
 * 
 * @package AI-MFA-Authentication-System
 * @author  Deez-Automations
 */

// Prevent direct access
if (basename($_SERVER['PHP_SELF']) === 'config.php') {
    http_response_code(403);
    exit('Direct access not permitted');
}

/**
 * Load environment variables from .env file
 */
function loadEnv($path = null) {
    $envPath = $path ?? __DIR__ . '/.env';
    
    if (!file_exists($envPath)) {
        error_log("Config: .env file not found at $envPath");
        return false;
    }
    
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse key=value pairs
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            if (preg_match('/^["\'](.*)["\']\s*$/', $value, $matches)) {
                $value = $matches[1];
            }
            
            // Set as environment variable
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
    
    return true;
}

/**
 * Get configuration value
 * 
 * @param string $key     Configuration key
 * @param mixed  $default Default value if not found
 * @return mixed          Configuration value
 */
function config($key, $default = null) {
    $value = getenv($key);
    return $value !== false ? $value : $default;
}

// Load environment variables
loadEnv();

// ==================================================
// Database Configuration
// ==================================================
define('DB_HOST', config('DB_HOST', 'localhost'));
define('DB_NAME', config('DB_NAME', 'authentication_system'));
define('DB_USER', config('DB_USER', 'postgres'));
define('DB_PASS', config('DB_PASS', ''));

// ==================================================
// Security Configuration
// ==================================================
// Pepper for password hashing - MUST be set in .env
define('SECURITY_PEPPER', config('SECURITY_PEPPER', ''));

// Validate critical security settings
if (empty(SECURITY_PEPPER)) {
    error_log("SECURITY WARNING: SECURITY_PEPPER not set in .env file!");
}

// ==================================================
// Session Configuration
// ==================================================
define('SESSION_LIFETIME', (int)config('SESSION_LIFETIME', 86400));
define('SESSION_SECURE', config('SESSION_SECURE', 'true') === 'true');

// ==================================================
// Application Configuration
// ==================================================
define('APP_ENV', config('APP_ENV', 'production'));
define('APP_DEBUG', config('APP_DEBUG', 'false') === 'true');

// Configure error reporting based on environment
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Always log errors
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/logs/php_errors.log');
?>
