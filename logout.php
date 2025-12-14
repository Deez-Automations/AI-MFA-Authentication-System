<?php
/**
 * Logout Handler
 * ==============
 * Destroys user session and redirects to login page.
 * 
 * @package AI-MFA-Authentication-System
 * @author  Deez-Automations
 */

require_once __DIR__ . '/session.php';

// Destroy session
logout();

// Redirect to login page
header('Location: login.html');
exit;
?>
