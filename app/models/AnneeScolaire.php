<?php

namespace App\Models;

use Core\Model;
use PDO;

class AnneeScolaire extends Model
{
    /**
     * Récupère toutes les années scolaires
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM annees_scolaires ORDER BY date_debut DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère l'année scolaire active
     */
    public function getActive()
    {
        $stmt = $this->db->query("SELECT * FROM annees_scolaires WHERE est_active = 1 LIMIT 1");
        $result = $stmt->fetch();
        if (!$result) {
            // Fallback to first
            $stmt = $this->db->query("SELECT * FROM annees_scolaires ORDER BY date_debut DESC LIMIT 1");
            $result = $stmt->fetch();
        }
        return $result;
    }

    /**
     * Récupère une année scolaire par son ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM annees_scolaires WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle année scolaire
     */
    public function create($data)
    {
        $sql = "INSERT INTO annees_scolaires (libelle, date_debut, date_fin, est_active) VALUES (:libelle, :date_debut, :date_fin, :est_active)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'libelle' => $data['libelle'],
            'date_debut' => $data['date_debut'],
            'date_fin' => $data['date_fin'],
            'est_active' => isset($data['est_active']) ? $data['est_active'] : 0
        ]);
    }

    /**
     * Définit une année scolaire comme active (et désactive les autres)
     */
    public function setActive($id)
    {
        $this->db->exec("UPDATE annees_scolaires SET est_active = 0");
        $stmt = $this->db->prepare("UPDATE annees_scolaires SET est_active = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Supprime une année scolaire
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM annees_scolaires WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
