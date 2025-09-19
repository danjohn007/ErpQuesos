<?php
define('ERP_QUESOS', true);

// Start session exactly like index.php
if (session_status() === PHP_SESSION_NONE) {
    session_name('erp_quesos_session');
    session_start();
}

require_once 'config/config.php';
require_once 'config/database.php';

// Autoloader simple para clases
spl_autoload_register(function ($class) {
    $paths = [
        CONTROLLERS_PATH . $class . '.php',
        MODELS_PATH . $class . '.php',
        __DIR__ . '/app/core/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Load core classes
require_once 'app/core/Controller.php';
require_once 'app/core/Model.php';
require_once 'app/core/View.php';
require_once 'app/core/Router.php';
require_once 'app/core/Auth.php';

echo "<h2>Direct Dashboard Test</h2>";

echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Session data: " . print_r($_SESSION, true) . "</p>";
echo "<p>Is logged in: " . (Auth::isLoggedIn() ? 'YES' : 'NO') . "</p>";

if (Auth::isLoggedIn()) {
    echo "<p>Trying to load DashboardController...</p>";
    
    try {
        require_once CONTROLLERS_PATH . 'DashboardController.php';
        $controller = new DashboardController();
        echo "<p>✓ DashboardController loaded successfully</p>";
        
        echo "<p>Trying to call index method...</p>";
        ob_start();
        $controller->index();
        $output = ob_get_clean();
        
        echo "<p>✓ Dashboard index method executed successfully</p>";
        echo "<h3>Dashboard Output:</h3>";
        echo "<div style='border: 1px solid #ccc; padding: 10px; max-height: 400px; overflow: auto;'>";
        echo htmlspecialchars(substr($output, 0, 1000)) . "...";
        echo "</div>";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
} else {
    echo "<p style='color: red;'>Not logged in - this would trigger redirect</p>";
}
?>