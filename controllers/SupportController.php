<?php
require_once "../core/Controller.php";

class SupportController extends Controller {
    private $SupportModel;

    public function __construct() {
        $this->SupportModel = $this->model('SupportModel');
    }

    public function showForm() {
        if ($_SESSION['role'] === 'user') {
            $this->view('support_form');
        } else {
            header('Location: /public/');
        }
    }

    public function submitForm() {
        if ($_SESSION['role'] === 'user') {
            $userId = $_SESSION['user_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            $this->SupportModel->createSupportRequest($userId, $title, $content);
            $this->view('success/support_success');
        } else {
            header('Location: /public/');
        }
    }
    public function viewRequests() {
        if ($_SESSION['role'] === 'admin') {
            $requests = $this->SupportModel->getAllRequests();
            $this->view('support_requests', ['requests' => $requests]);
        } else {
            header('Location: /public/');
        }
    }

    public function deleteRequest($id) {
        if ($_SESSION['role'] === 'admin') {
            $this->SupportModel->deleteRequestById($id);
            header('Location: /public/index.php?url=support/requests');
        } else {
            header('Location: /public/');
        }
    }
}
?>
