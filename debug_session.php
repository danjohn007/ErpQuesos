<?php
define('ERP_QUESOS', true);

// Start session with same configuration as main app
if (session_status() === PHP_SESSION_NONE) {
    session_name('erp_quesos_session');
    session_start();
}

require_once 'config/config.php';
require_once 'config/database.php';
require_once 'app/core/Auth.php';

echo "<h2>Session Debug</h2>";
echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
echo "<p><strong>Session Name:</strong> " . session_name() . "</p>";
echo "<p><strong>Session Status:</strong> " . session_status() . "</p>";
echo "<p><strong>Current Session Data:</strong></p>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

echo "<h3>Auth Status</h3>";
echo "<p><strong>Is Logged In:</strong> " . (Auth::isLoggedIn() ? 'YES' : 'NO') . "</p>";
echo "<p><strong>User ID:</strong> " . Auth::getUserId() . "</p>";
echo "<p><strong>User Role:</strong> " . Auth::getUserRole() . "</p>";

if (Auth::isLoggedIn()) {
    echo "<p><strong>User Data:</strong></p>";
    echo "<pre>" . print_r(Auth::getUser(), true) . "</pre>";
}
?>