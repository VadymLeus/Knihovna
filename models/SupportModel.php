<?php
require_once "../core/Model.php";

class SupportModel extends Model {
    public function createSupportRequest($userId, $title, $content) {
        $stmt = $this->db->prepare("INSERT INTO lists (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $title, $content);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllRequests() {
        $query = "SELECT lists.list_id, lists.user_id, lists.title, lists.content, lists.date, users.email FROM lists JOIN users ON lists.user_id = users.id";
        $result = $this->db->query($query);
        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        return $requests;
    }

    public function deleteRequestById($id) {
        $stmt = $this->db->prepare("DELETE FROM lists WHERE list_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    
}
?>
