<?php
require_once "../core/Model.php";

class MainModel extends Model {
    public function getAllBooks() {
        $query = "SELECT * FROM books";
        $result = $this->db->query($query);
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }

    public function searchBooks($searchTerm, $filter) {
        $searchTerms = explode(' ', $searchTerm);
        $searchConditions = array_map(function($term) {
            return "(title LIKE ? OR author LIKE ?)";
        }, $searchTerms);
    
        $searchSQL = implode(' AND ', $searchConditions);
    
        $params = [];
        foreach ($searchTerms as $term) {
            $param = "%$term%";
            array_push($params, $param, $param);
        }
    
        if ($filter !== '') {
            $searchSQL .= " AND genre = ?";
            $params[] = $filter;
        }
    
        $sql = "SELECT * FROM books WHERE $searchSQL";
    
        return $this->executeQuery($sql, $params);
    }
    
    private function executeQuery($sql, $params) {
        $stmt = $this->db->prepare($sql);
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }

    public function getCartBookCount($userId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function addToCart($userId, $bookId, $quantity) {
        $stmt = $this->db->prepare("INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $bookId, $quantity);
        return $stmt->execute();
    }

    public function isBookInCart($userId, $bookId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $userId, $bookId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0;
    }

    public function removeFromCart($userId, $bookId) {
        $query = "DELETE FROM cart WHERE user_id = ? AND book_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $userId, $bookId);
        return $statement->execute();
    }
}
?>
