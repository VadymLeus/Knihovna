<?php
class ProfileModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserProfile($userId) {
        $query = "SELECT nickname, email FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updatePassword($userId, $oldPassword, $newPassword) {
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($oldPassword, $user['password'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bind_param("si", $newPasswordHash, $userId);
            $updateStmt->execute();
            return ["success" => true, "message" => "Password updated successfully."];
        } else {
            return ["success" => false, "message" => "Old password is incorrect."];
        }
    }

    public function updateNickname($userId, $newNickname) {
        $updateQuery = "UPDATE users SET nickname = ? WHERE id = ?";
        $stmt = $this->db->prepare($updateQuery);
        $stmt->bind_param("si", $newNickname, $userId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ["success" => true, "message" => "Nickname updated successfully."];
        } else {
            return ["success" => false, "message" => "Failed to update nickname."];
        }
    }
}
?>