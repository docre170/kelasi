<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\AnneeScolaire;

class EleveController extends Controller
{
    public function index()
    {
        $this->liste();
    }

    public function liste()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth/connexion');
            return;
        }

        $inscriptionModel = new Inscription();
        $eleveModel = new Eleve();

        // Si l'utilisateur est parent, il ne voit que ses enfants
        if ($_SESSION['role'] === 'parent') {
            $inscriptions = $inscriptionModel->getByParent($_SESSION['user_id']);
        } else {
            $inscriptions = $inscriptionModel->getAll();
        }

        $this->view('eleve/liste', [
            'inscriptions' => $inscriptions
        ]);
    }

    public function inscrire()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth/connexion');
            return;
        }

        $classeModel = new Classe();
        $anneeModel = new AnneeScolaire();

        $classes = $classeModel->getAll();
        $anneeActive = $anneeModel->getActive();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $postnom = trim($_POST['postnom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $sexe = trim($_POST['sexe'] ?? 'M');
            $date_naissance = trim($_POST['date_naissance'] ?? '');
            $lieu_naissance = trim($_POST['lieu_naissance'] ?? '');
            $adresse = trim($_POST['adresse'] ?? '');
            
            $parent_nom = trim($_POST['parent_nom'] ?? ($_SESSION['username'] ?? ''));
            $parent_email = trim($_POST['parent_email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $classe_id = intval($_POST['classe_id'] ?? 0);
            $observations = trim($_POST['observations'] ?? '');

            if (empty($nom) || empty($prenom) || empty($date_naissance) || empty($classe_id) || empty($telephone)) {
                $error = "Veuillez remplir tous les champs obligatoires.";
                $this->view('eleve/inscrire', [
                    'classes' => $classes,
                    'anneeActive' => $anneeActive,
                    'error' => $error
                ]);
                return;
            }

            $eleveModel = new Eleve();
            $eleveData = [
                'nom' => $nom,
                'postnom' => $postnom,
                'prenom' => $prenom,
                'sexe' => $sexe,
                'date_naissance' => $date_naissance,
                'lieu_naissance' => $lieu_naissance,
                'adresse' => $adresse,
                'parent_id' => $_SESSION['role'] === 'parent' ? $_SESSION['user_id'] : null,
                'parent_nom' => $parent_nom,
                'parent_email' => $parent_email,
                'telephone' => $telephone
            ];

            // In Eloquent/Custom PDO, insert into eleves and get last ID
            $sqlEleve = "INSERT INTO eleves (nom, postnom, prenom, sexe, date_naissance, lieu_naissance, adresse, parent_id, parent_nom, parent_email, telephone) 
                         VALUES (:nom, :postnom, :prenom, :sexe, :date_naissance, :lieu_naissance, :adresse, :parent_id, :parent_nom, :parent_email, :telephone)";
            
            $db = \Core\Database::getInstance();
            $stmt = $db->prepare($sqlEleve);
            $success = $stmt->execute($eleveData);

            if ($success) {
                $eleveId = $db->lastInsertId();

                $inscriptionModel = new Inscription();
                $inscriptionModel->create([
                    'eleve_id' => $eleveId,
                    'classe_id' => $classe_id,
                    'annee_scolaire_id' => $anneeActive['id'] ?? 1,
                    'statut' => 'en_attente',
                    'observations' => $observations
                ]);

                $this->redirect('/eleve/liste');
                return;
            } else {
                $error = "Erreur lors de l'enregistrement de l'élève.";
                $this->view('eleve/inscrire', [
                    'classes' => $classes,
                    'anneeActive' => $anneeActive,
                    'error' => $error
                ]);
                return;
            }
        }

        $this->view('eleve/inscrire', [
            'classes' => $classes,
            'anneeActive' => $anneeActive
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
            $inscriptionModel = new Inscription();
            $inscriptionModel->delete($id);
        }

        $this->redirect('/eleve/liste');
    }

    public function traiter()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('/dashboard');
            return;
        }

        $id = intval($_POST['inscription_id'] ?? $_GET['id'] ?? 0);
        $statut = trim($_POST['statut'] ?? 'validee');
        $motif = trim($_POST['motif_rejet'] ?? '');

        if ($id > 0) {
            $inscriptionModel = new Inscription();
            $inscriptionModel->updateStatus($id, $statut, $motif, $_SESSION['user_id']);
        }

        $this->redirect('/eleve/liste');
    }
}
