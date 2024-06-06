<?php
class HistoryModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getUserOrders($userId) {
        $query = "SELECT o.id, b.title as book_title, b.price, o.quantity, o.order_date 
                  FROM orders o 
                  JOIN books b ON o.book_id = b.id 
                  WHERE o.user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllOrdersWithUserEmails() {
        $query = "SELECT o.id as id, u.email as user_email, b.title as book_title, b.price, o.quantity, o.order_date 
                  FROM orders o 
                  JOIN users u ON o.user_id = u.id
                  JOIN books b ON o.book_id = b.id";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchBooksByName($bookName) {
        $query = "SELECT o.id, b.title as book_title, o.price, o.quantity, o.order_date 
                  FROM orders o 
                  JOIN books b ON o.book_id = b.id 
                  WHERE b.title LIKE ?";
        $statement = $this->db->prepare($query);
        $searchBook = "%{$bookName}%";
        $statement->bind_param("s", $searchBook);
        $statement->execute();
        $result = $statement->get_result();
        $books = $result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $books;
    }

    public function getUserOrdersWithSearch($userId, $searchBook) {
        $query = "SELECT o.id, b.title as book_title, b.price, o.quantity, o.order_date 
                  FROM orders o 
                  JOIN books b ON o.book_id = b.id 
                  WHERE o.user_id = ? AND b.title LIKE ?";
        $statement = $this->db->prepare($query);
        $userId = intval($userId);
        $searchBook = "%{$searchBook}%";
        $statement->bind_param("is", $userId, $searchBook);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserOrdersByEmail($email) {
        $query = "SELECT o.id, u.email as user_email, b.title as book_title, b.price, o.quantity, o.order_date 
                  FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  JOIN books b ON o.book_id = b.id 
                  WHERE u.email LIKE ?";
        $statement = $this->db->prepare($query);
        $searchUser = "%{$email}%";
        $statement->bind_param("s", $searchUser);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
