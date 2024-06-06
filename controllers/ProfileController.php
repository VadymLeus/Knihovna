<?php
require_once "../models/ProfileModel.php";

class ProfileController {
    private $profileModel;

    public function __construct($db) {
        $this->profileModel = new ProfileModel($db);
    }

    public function getUserProfile($userId) {
        return $this->profileModel->getUserProfile($userId);
    }

    public function updatePassword($userId, $oldPassword, $newPassword, $confirmPassword) {
        if ($newPassword !== $confirmPassword) {
            return ["success" => false, "message" => "New passwords do not match."];
        }

        if (strlen($newPassword) < 6) {
            return ["success" => false, "message" => "New password must be at least 6 characters long."];
        }

        return $this->profileModel->updatePassword($userId, $oldPassword, $newPassword);
    }

    public function updateNickname($userId, $newNickname) {
        if (empty($newNickname)) {
            return ["success" => false, "message" => "Nickname cannot be empty."];
        }

        return $this->profileModel->updateNickname($userId, $newNickname);
    }
}
?>
