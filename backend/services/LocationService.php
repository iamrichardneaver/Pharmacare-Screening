<?php
class LocationService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllLocations() {
        $query = "SELECT * FROM locations ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addLocation($name) {
        $query = "INSERT INTO locations (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function deleteLocation($id) {
        $query = "DELETE FROM locations WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
