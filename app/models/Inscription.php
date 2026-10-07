<?php

namespace App\Models;

use Core\Model;
use PDO;

class Inscription extends Model
{
    /**
     * Récupère toutes les inscriptions avec les détails élève, classe et année
     */
    public function getAll()
    {
        $sql = "SELECT i.*, 
                       e.nom as eleve_nom, e.prenom as eleve_prenom, e.sexe as eleve_sexe, e.date_naissance as eleve_date_naissance,
                       c.niveau as classe_niveau, c.cycle as classe_cycle,
                       a.libelle as annee_libelle
                FROM inscriptions i
                JOIN eleves e ON i.eleve_id = e.id
                JOIN classes c ON i.classe_id = c.id
                JOIN annees_scolaires a ON i.annee_scolaire_id = a.id
                ORDER BY i.date_soumission DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère une inscription par son ID
     */
    public function findById($id)
    {
        $sql = "SELECT i.*, 
                       e.nom as eleve_nom, e.prenom as eleve_prenom, e.postnom as eleve_postnom, e.sexe as eleve_sexe, 
                       e.date_naissance as eleve_date_naissance, e.lieu_naissance as eleve_lieu_naissance,
                       e.parent_nom, e.parent_email, e.telephone, e.adresse,
                       c.niveau as classe_niveau, c.cycle as classe_cycle,
                       a.libelle as annee_libelle
                FROM inscriptions i
                JOIN eleves e ON i.eleve_id = e.id
                JOIN classes c ON i.classe_id = c.id
                JOIN annees_scolaires a ON i.annee_scolaire_id = a.id
                WHERE i.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Récupère les inscriptions d'un parent spécifique
     */
    public function getByParent($parentId)
    {
        $sql = "SELECT i.*, 
                       e.nom as eleve_nom, e.prenom as eleve_prenom,
                       c.niveau as classe_niveau, c.cycle as classe_cycle,
                       a.libelle as annee_libelle
                FROM inscriptions i
                JOIN eleves e ON i.eleve_id = e.id
                JOIN classes c ON i.classe_id = c.id
                JOIN annees_scolaires a ON i.annee_scolaire_id = a.id
                WHERE e.parent_id = :parent_id
                ORDER BY i.date_soumission DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['parent_id' => $parentId]);
        return $stmt->fetchAll();
    }

    /**
     * Crée une nouvelle inscription
     */
    public function create($data)
    {
        // Générer un numéro de dossier unique si non fourni
        if (empty($data['numero_dossier'])) {
            $data['numero_dossier'] = 'KEL-' . date('Y') . '-' . strtoupper(substr(uniqid(), -5));
        }

        $sql = "INSERT INTO inscriptions (
                    numero_dossier, eleve_id, classe_id, annee_scolaire_id, statut, observations
                ) VALUES (
                    :numero_dossier, :eleve_id, :classe_id, :annee_scolaire_id, :statut, :observations
                )";
        
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            'numero_dossier' => $data['numero_dossier'],
            'eleve_id' => $data['eleve_id'],
            'classe_id' => $data['classe_id'],
            'annee_scolaire_id' => $data['annee_scolaire_id'],
            'statut' => $data['statut'] ?? 'en_attente',
            'observations' => $data['observations'] ?? null
        ]);

        return $success ? $this->db->lastInsertId() : false;
    }

    /**
     * Met à jour le statut d'une inscription
     */
    public function updateStatus($id, $statut, $motifRejet = null, $adminId = null)
    {
        $sql = "UPDATE inscriptions SET 
                    statut = :statut, 
                    motif_rejet = :motif_rejet, 
                    traite_par = :traite_par,
                    date_traitement = NOW()
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'statut' => $statut,
            'motif_rejet' => $motifRejet,
            'traite_par' => $adminId
        ]);
    }

    /**
     * Supprime une inscription
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM inscriptions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compte le nombre total d'inscriptions
     */
    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM inscriptions");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Compte par statut
     */
    public function countByStatus($statut)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM inscriptions WHERE statut = :statut");
        $stmt->execute(['statut' => $statut]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Récupère les inscriptions récentes
     */
    public function getRecent($limit = 5)
    {
        $sql = "SELECT i.*, 
                       e.nom as eleve_nom, e.prenom as eleve_prenom,
                       c.niveau as classe_niveau,
                       a.libelle as annee_libelle
                FROM inscriptions i
                JOIN eleves e ON i.eleve_id = e.id
                JOIN classes c ON i.classe_id = c.id
                JOIN annees_scolaires a ON i.annee_scolaire_id = a.id
                ORDER BY i.date_soumission DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
