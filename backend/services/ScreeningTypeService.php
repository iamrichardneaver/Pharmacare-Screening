<?php
class ScreeningTypeService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllScreeningTypes() {
        $query = "SELECT * FROM screening_types ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addScreeningType($name) {
        $query = "INSERT INTO screening_types (name) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function deleteScreeningType($id) {
        $query = "DELETE FROM screening_types WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
