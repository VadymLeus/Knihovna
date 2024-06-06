<?php
require_once "../core/Model.php";

class AddBookModel extends Model {
    public function insertBook($title, $author, $price, $discount, $quantity, $genre, $imagePath) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, price, discount, quantity, genre, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddiss", $title, $author, $price, $discount, $quantity, $genre, $imagePath);
        return $stmt->execute();
    }
}
?>
