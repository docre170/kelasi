<?php

// Autoloader simple pour le projet Kelasi
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $baseDir = __DIR__ . '/../';
    
    // Mapper les namespaces vers les dossiers
    if (strpos($class, 'Core/') === 0) {
        $file = $baseDir . $class . '.php';
    } elseif (strpos($class, 'App/') === 0) {
        $file = $baseDir . 'app/' . substr($class, 4) . '.php';
    } else {
        $file = $baseDir . $class . '.php';
    }

    if (file_exists($file)) {
        require_once $file;
    }
});

session_start();

require_once __DIR__ . '/../core/helpers.php';

use Core\Router;

$router = new Router();
$router->run();
