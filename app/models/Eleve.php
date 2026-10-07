<?php

namespace App\Models;

use Core\Model;
use PDO;

class Eleve extends Model
{
    /**
     * Récupère tous les élèves
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM eleves ORDER BY date_creation DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère un élève par son ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM eleves WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Récupère les élèves d'un parent spécifique
     */
    public function getByParent($parentId)
    {
        $stmt = $this->db->prepare("SELECT * FROM eleves WHERE parent_id = :parent_id ORDER BY date_creation DESC");
        $stmt->execute(['parent_id' => $parentId]);
        return $stmt->fetchAll();
    }

    /**
     * Crée un nouvel élève
     */
    public function create($data)
    {
        $sql = "INSERT INTO eleves (
                    nom, prenom, date_naissance, parent_nom, parent_email, telephone, adresse, parent_id
                ) VALUES (
                    :nom, :prenom, :date_naissance, :parent_nom, :parent_email, :telephone, :adresse, :parent_id
                )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Met à jour les informations d'un élève
     */
    public function update($id, $data)
    {
        $sql = "UPDATE eleves SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    date_naissance = :date_naissance, 
                    parent_nom = :parent_nom, 
                    parent_email = :parent_email, 
                    telephone = :telephone, 
                    adresse = :adresse
                WHERE id = :id";

        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Supprime un élève
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM eleves WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compte le nombre total d'élèves
     */
    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM eleves");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}