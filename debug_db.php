<?php
define('ERP_QUESOS', true);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_name('erp_quesos_session');
    session_start();
}

require_once 'config/config.php';
require_once 'config/database.php';
require_once 'app/core/Auth.php';

// Set demo session
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'demo';
$_SESSION['email'] = 'demo@erpquesos.com';
$_SESSION['nombre'] = 'Usuario';
$_SESSION['apellidos'] = 'Demo';
$_SESSION['rol'] = 'admin';

echo "<h2>Testing Database Connection</h2>";

try {
    $db = Database::getInstance();
    echo "<p>✓ Database instance created</p>";
    
    // Test the queryOne method
    $result = $db->queryOne("SELECT 1 as test");
    echo "<p>✓ queryOne method works: " . print_r($result, true) . "</p>";
    
    // Test the query method
    $result = $db->query("SELECT 1 as test, 2 as test2");
    echo "<p>✓ query method works</p>";
    
    // Test if it returns an object we can fetch from
    if ($result) {
        $row = $result->fetch();
        echo "<p>✓ Fetch works: " . print_r($row, true) . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Stack trace:</strong></p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Testing Dashboard Controller Logic</h2>";

try {
    // Manually test the problematic query
    $db = Database::getInstance();
    
    echo "<p>Testing production query...</p>";
    $produccionHoy = $db->queryOne("
        SELECT COUNT(*) as total, SUM(1) as kg_producidos 
        FROM dual
    ");
    echo "<p>✓ Production query result: " . print_r($produccionHoy, true) . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Dashboard query error: " . $e->getMessage() . "</p>";
}
?>