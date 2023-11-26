<?php
// Start the session (required to handle sessions in PHP)
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Set cookie parameters. Get these from your php.ini file or use default parameters
$cookieParams = session_get_cookie_params();

// Delete the actual cookie.
setcookie(session_name(), '', time() - 42000,
    $cookieParams['path'], 
    $cookieParams['domain'],
    $cookieParams['secure'], 
    $cookieParams['httponly']
);

// Redirect to a page afterwards if necessary

?>
