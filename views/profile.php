<?php
session_start();
require_once "../core/database.php";
require_once "../controllers/ProfileController.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/authentication.php");
    exit;
}

$profileController = new ProfileController($db);
$userProfile = $profileController->getUserProfile($_SESSION['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        $updateResult = $profileController->updatePassword($_SESSION['user_id'], $oldPassword, $newPassword, $confirmPassword);
        $message = $updateResult['message'];
    } elseif (isset($_POST['nickname'])) {
        $newNickname = $_POST['nickname'];
        $updateResult = $profileController->updateNickname($_SESSION['user_id'], $newNickname);
        $message = $updateResult['message'];
        if ($updateResult['success']) {
            $_SESSION['nickname'] = $newNickname;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/public/css/profstyle.css">
</head>
<body>
<div class="container">
    <h2>User Profile</h2>
    <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
    
    <p><strong>Nickname:</strong> <?php echo htmlspecialchars($userProfile['nickname']); ?></p>
    <form action="" method="POST">
        <label for="nickname">New Nickname:</label>
        <input type="text" id="nickname" name="nickname" value="<?php echo htmlspecialchars($userProfile['nickname']); ?>" required>
        <button type="submit">Update Nickname</button>
    </form>

    <p><strong>Email:</strong> <?php echo htmlspecialchars($userProfile['email']); ?></p>
    
    <h3>Change Password</h3>
    <form action="" method="POST">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" required>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <button type="submit">Update Password</button>
    </form>
    <a href="/public" class="back-button">Back to Main Page</a>
</div>
</body>
</html>
