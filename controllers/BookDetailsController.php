<?php
require_once "../core/Controller.php";

class BookDetailsController extends Controller {
    private $bookDetailsModel;

    public function __construct() {
        $this->bookDetailsModel = $this->model('BookDetailsModel');
    }

    public function details($bookId) {
        session_start();
        if (isset($_SESSION['role']) && ($_SESSION['role'] === 'user' || $_SESSION['role'] === 'admin')) {
            $book = $this->bookDetailsModel->getBookById($bookId);
            $this->view('book_details', ['book' => $book]);
        } else {
            echo "Access denied.";
        }
    }
}
?>

