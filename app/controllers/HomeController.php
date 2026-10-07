<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Un utilisateur connecté est redirigé vers son tableau de bord
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
            return;
        }

        $this->view('home/index');
    }
}
