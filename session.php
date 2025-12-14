<?php
/**
 * Session Protection Middleware
 * =============================
 * Include at the top of protected pages to ensure user is logged in.
 * Redirects to login page if no valid session exists.
 * 
 * @package AI-MFA-Authentication-System
 * @author  Deez-Automations
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is authenticated
 * 
 * @return bool True if user has valid session
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require authentication to access page
 * Redirects to login if not authenticated
 * 
 * @param string $redirectUrl URL to redirect after login
 */
function requireAuth($redirectUrl = 'login.html') {
    if (!isAuthenticated()) {
        header("Location: $redirectUrl");
        exit;
    }
}

/**
 * Get current user ID
 * 
 * @return int|null User ID or null if not logged in
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user email
 * 
 * @return string|null User email or null if not logged in
 */
function getCurrentUserEmail() {
    return $_SESSION['email'] ?? null;
}

/**
 * Destroy session and log out user
 */
function logout() {
    session_unset();
    session_destroy();
}

/**
 * Generate CSRF token
 * 
 * @return string CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 * 
 * @param string $token Token to validate
 * @return bool True if valid
 */
function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
