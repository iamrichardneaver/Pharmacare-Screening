<?php
class PatientService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ... (keep existing methods)

    public function searchPatients($searchTerm, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM patients 
                  WHERE first_name LIKE :search 
                  OR last_name LIKE :search 
                  OR email LIKE :search 
                  OR phone_number LIKE :search 
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $searchTerm = "%{$searchTerm}%";
        $stmt->bindParam(':search', $searchTerm);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countQuery = "SELECT COUNT(*) FROM patients 
                       WHERE first_name LIKE :search 
                       OR last_name LIKE :search 
                       OR email LIKE :search 
                       OR phone_number LIKE :search";
        $countStmt = $this->db->prepare($countQuery);
        $countStmt->bindParam(':search', $searchTerm);
        $countStmt->execute();
        $totalCount = $countStmt->fetchColumn();

        return [
            'results' => $results,
            'total' => $totalCount,
            'page' => $page,
            'limit' => $limit
        ];
    }
}
