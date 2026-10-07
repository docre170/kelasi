<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        $this->connexion();
    }

    public function connexion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                $this->redirect('/dashboard');
                return;
            } else {
                $error = "Email ou mot de passe incorrect.";
                $this->view('auth/connexion', ['error' => $error]);
                return;
            }
        }

        $this->view('auth/connexion');
    }

    public function inscription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $userModel = new User();
            $result = $userModel->create($username, $email, $password);

            if ($result) {
                $this->redirect('/auth/connexion');
                return;
            } else {
                $error = "Erreur lors de l'inscription. Vérifiez les informations saisies.";
                $this->view('auth/inscription', ['error' => $error]);
                return;
            }
        }

        $this->view('auth/inscription');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/auth/connexion');
    }
}