<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Classe;

class ClasseController extends Controller
{
    public function index()
    {
        $this->gestion();
    }

    public function gestion()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/dashboard');
            return;
        }

        $classeModel = new Classe();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cycle = trim($_POST['cycle'] ?? '');
            $niveau = trim($_POST['niveau'] ?? '');
            $ordre = intval($_POST['ordre'] ?? 0);

            if (!empty($cycle) && !empty($niveau)) {
                $classeModel->create([
                    'cycle' => $cycle,
                    'niveau' => $niveau,
                    'ordre' => $ordre > 0 ? $ordre : 99
                ]);
                $this->redirect('/classe/gestion');
                return;
            } else {
                $error = "Veuillez remplir tous les champs de la classe.";
            }
        }

        $classes = $classeModel->getAll();

        $this->view('classe/gestion', [
            'classes' => $classes,
            'error' => $error ?? null
        ]);
    }

    public function supprimer()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/dashboard');
            return;
        }

        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $classeModel = new Classe();
            $classeModel->delete($id);
        }

        $this->redirect('/classe/gestion');
    }
}
