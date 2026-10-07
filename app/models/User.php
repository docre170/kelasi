<?php

namespace App\Models;

use Core\Model;
use PDO;

class User extends Model
{
    /**
     * Récupère un utilisateur par son email
     */
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Récupère un utilisateur par son ID
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Récupère un utilisateur par son nom d'utilisateur
     */
    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function create($username, $email, $password, $role = 'parent')
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hash, $role]);
    }

    /**
     * Met à jour le mot de passe d'un utilisateur
     */
    public function updatePassword($id, $newPassword)
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }

    /**
     * Met à jour le rôle d'un utilisateur
     */
    public function updateRole($id, $role)
    {
        $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $id]);
    }

    /**
     * Désactive un utilisateur
     */
    public function deactivate($id)
    {
        $stmt = $this->db->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Active un utilisateur
     */
    public function activate($id)
    {
        $stmt = $this->db->prepare("UPDATE users SET is_active = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Vérifie si un email existe déjà
     */
    public function emailExists($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Vérifie si un nom d'utilisateur existe déjà
     */
    public function usernameExists($username)
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() !== false;
    }

    /**
     * Récupère tous les utilisateurs
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère les utilisateurs par rôle
     */
    public function getByRole($role)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = ? ORDER BY created_at DESC");
        $stmt->execute([$role]);
        return $stmt->fetchAll();
    }

    /**
     * Compte le nombre total d'utilisateurs
     */
    public function count()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}