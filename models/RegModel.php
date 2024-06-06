<?php
require_once "../core/Model.php";

class RegModel extends Model {
    public function registerUser($nickname, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (nickname, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nickname, $email, $password);
        return $stmt->execute();
    }

    public function isEmailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
?>
