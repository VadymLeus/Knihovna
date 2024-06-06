<?php
require_once "../core/Model.php";

class BookDetailsModel extends Model {
    public function getBookById($bookId) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
