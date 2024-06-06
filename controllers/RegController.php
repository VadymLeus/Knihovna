<?php
require_once "../core/Controller.php";

class RegController extends Controller {
    private $RegModel;

    public function __construct() {
        $this->RegModel = $this->model('RegModel');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password === $confirm_password) {
                if (!$this->RegModel->isEmailExists($email)) {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $this->RegModel->registerUser($nickname, $email, $hashed_password);
                    header('Location: /views/success/reg_success.php');
                    exit();
                } else {
                    echo "Email already exists.";
                }
            } else {
                echo "Passwords do not match.";
            }
        } else {
            $this->view('register');
        }
    }
}
?>
