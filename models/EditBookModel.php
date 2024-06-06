<?php
require_once "../core/Model.php";

class EditBookModel extends Model {
    public function getBookById($id) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateBook($id, $title, $author, $price, $discount, $quantity, $genre, $imagePath) {
        $stmt = $this->db->prepare("UPDATE books SET title = ?, author = ?, price = ?, discount = ?, quantity = ?, genre = ?, image = ? WHERE id = ?");
        $stmt->bind_param("ssddissi", $title, $author, $price, $discount, $quantity, $genre, $imagePath, $id);
        return $stmt->execute();
    }

    public function deleteBook($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
