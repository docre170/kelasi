<?php

namespace Core;

class Router {
    public function run() {
        $url = $_GET['url'] ?? '/';
        $url = trim($url, '/');
        
        $params = explode('/', $url);
        
        $controllerName = !empty($params[0]) ? ucfirst($params[0]) . 'Controller' : 'HomeController';
        $actionName = !empty($params[1]) ? $params[1] : 'index';
        
        $controllerClass = "App\\Controllers\\" . $controllerName;
        
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                die("Action $actionName non trouvée dans le contrôleur $controllerName.");
            }
        } else {
            die("Contrôleur $controllerName non trouvé ($controllerClass).");
        }
    }
}
