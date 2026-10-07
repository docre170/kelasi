<?php

namespace App\Models;

use Core\Model;
use PDO;

class Classe extends Model
{
    /**
     * Récupère toutes les classes triées par ordre
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM classes ORDER BY ordre ASC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère une classe par son ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM classes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Crée une nouvelle classe
     */
    public function create($data)
    {
        $sql = "INSERT INTO classes (cycle, niveau, ordre) VALUES (:cycle, :niveau, :ordre)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'cycle' => $data['cycle'],
            'niveau' => $data['niveau'],
            'ordre' => $data['ordre']
        ]);
    }

    /**
     * Met à jour une classe
     */
    public function update($id, $data)
    {
        $sql = "UPDATE classes SET cycle = :cycle, niveau = :niveau, ordre = :ordre WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'cycle' => $data['cycle'],
            'niveau' => $data['niveau'],
            'ordre' => $data['ordre']
        ]);
    }

    /**
     * Supprime une classe
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM classes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compte le nombre total de classes
     */
    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM classes");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
