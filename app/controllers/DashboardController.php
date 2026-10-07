<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\AnneeScolaire;

class DashboardController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth/connexion');
            return;
        }

        $eleveModel = new Eleve();
        $classeModel = new Classe();
        $inscriptionModel = new Inscription();
        $anneeModel = new AnneeScolaire();

        $stats = [
            'total_eleves' => $eleveModel->count(),
            'total_classes' => $classeModel->count(),
            'total_inscriptions' => $inscriptionModel->count(),
            'inscriptions_attente' => $inscriptionModel->countByStatus('en_attente'),
            'inscriptions_validees' => $inscriptionModel->countByStatus('validee'),
        ];

        $anneeActive = $anneeModel->getActive();
        $inscriptionsRecentes = $inscriptionModel->getRecent(5);

        $this->view('dashboard/index', [
            'stats' => $stats,
            'anneeActive' => $anneeActive,
            'inscriptionsRecentes' => $inscriptionsRecentes
        ]);
    }
}
