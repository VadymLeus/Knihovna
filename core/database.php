<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'Book_Magazin';
    private $username = 'root';
    private $password = '';
    public $conn;
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        } catch (mysqli_sql_exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}

$database = new Database();
$db = $database->getConnection();
?>
