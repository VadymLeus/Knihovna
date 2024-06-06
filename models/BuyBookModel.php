<?php
class BuyBookModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getCartItems($userId) {
        $query = "SELECT b.id, b.title, b.author, b.price, b.discount, b.image, c.quantity, b.quantity as stock_quantity 
                  FROM cart c 
                  JOIN books b ON c.book_id = b.id 
                  WHERE c.user_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
        $statement->close();
        return $cartItems;
    }

    public function confirmOrder($userId) {
        $this->db->begin_transaction();

        $query = "SELECT b.id FROM cart c 
                  INNER JOIN books b ON c.book_id = b.id 
                  WHERE c.user_id = ? AND b.quantity < c.quantity";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            $statement->close();
            return false;
        } else {
            $statement->close();
            $query = "INSERT INTO orders (user_id, book_id, quantity, price) 
                      SELECT c.user_id, c.book_id, c.quantity, b.price * (1 - b.discount / 100) * c.quantity 
                      FROM cart c 
                      JOIN books b ON c.book_id = b.id 
                      WHERE c.user_id = ?";
            $statement = $this->db->prepare($query);
            $statement->bind_param("i", $userId);
            $result1 = $statement->execute();
            $statement->close();

            $query = "UPDATE books b 
                      INNER JOIN cart c ON b.id = c.book_id 
                      SET b.quantity = b.quantity - c.quantity 
                      WHERE c.user_id = ?";
            $statement = $this->db->prepare($query);
            $statement->bind_param("i", $userId);
            $result2 = $statement->execute();
            $statement->close();

            $query = "DELETE FROM cart WHERE user_id = ?";
            $statement = $this->db->prepare($query);
            $statement->bind_param("i", $userId);
            $result3 = $statement->execute();
            $statement->close();

            if ($result1 && $result2 && $result3) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollback();
                return false;
            }
        }
    }

    public function removeCartItem($userId, $bookId) {
        $query = "DELETE FROM cart WHERE user_id = ? AND book_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $userId, $bookId);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }

    public function updateCartItemQuantity($userId, $bookId, $quantity) {
        $query = "SELECT quantity FROM books WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $bookId);
        $statement->execute();
        $statement->bind_result($stockQuantity);
        $statement->fetch();
        $statement->close();

        if ($quantity > $stockQuantity) {
            return false;
        }

        $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND book_id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("iii", $quantity, $userId, $bookId);
        $result = $statement->execute();
        $statement->close();
        return $result;
    }
}
?>
