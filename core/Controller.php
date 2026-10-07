<?php

namespace Core;

class Controller {
    protected function view($path, $data = []) {
        extract($data);
        
        ob_start();
        $viewFile = __DIR__ . '/../app/views/' . $path . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("La vue $viewFile n'existe pas.");
        }
        $content = ob_get_clean();
        
        require_once __DIR__ . '/../app/views/layouts/main.php';
    }

    protected function redirect($url) {
        header("Location: " . url($url));
        exit();
    }
}
