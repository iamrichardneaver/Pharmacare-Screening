<?php
class UserService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserById($userId) {
        $query = "SELECT u.*, r.role_name FROM users u JOIN user_roles r ON u.role_id = r.role_id WHERE u.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username) {
        $query = "SELECT u.*, r.role_name FROM users u JOIN user_roles r ON u.role_id = r.role_id WHERE u.username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($userData) {
        $query = "INSERT INTO users (username, password, role_id) VALUES (:username, :password, :role_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $userData['username']);
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role_id', $userData['role_id']);
        return $stmt->execute();
    }

    public function updateUser($userId, $userData) {
        $query = "UPDATE users SET username = :username, role_id = :role_id WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $userData['username']);
        $stmt->bindParam(':role_id', $userData['role_id']);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    public function deleteUser($userId) {
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
}
