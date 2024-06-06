<?php
require_once "../core/Controller.php";

class AuthController extends Controller {
    private $AuthModel;

    public function __construct() {
        $this->AuthModel = $this->model('AuthModel');
    }

    public function authenticate() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            if ($this->AuthModel->authenticateUser($email, $password)) {
                header("Location: /public/index.php");
                exit;
            } else {
                $errorMessage = "Invalid email or password. Please try again.";
                $this->view('authentication', ['errorMessage' => $errorMessage]);
            }
        } else {
            $this->view('authentication');
        }
    }
}
?>
