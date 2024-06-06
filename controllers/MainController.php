<?php
require_once "../core/Controller.php";

class MainController extends Controller {
    private $MainModel;

    public function __construct() {
        $this->MainModel = $this->model('MainModel');
    }

    public function index() {
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

        if ($searchTerm !== '' || $filter !== '') {
            $books = $this->MainModel->searchBooks($searchTerm, $filter);
            $noResultsMessage = empty($books) ? "<img src='/public/images/NoHaveTextBook.png' alt='No Book Found'>" : '';
        } else {
            $books = $this->MainModel->getAllBooks();
        }

        if (isset($_POST['buy'])) {
            $this->MainModel->addToCart($_SESSION['user_id'], $_POST['book_id'], 1);
        }

        if (isset($_POST['remove_from_cart'])) {
            $this->MainModel->removeFromCart($_SESSION['user_id'], $_POST['book_id']);
        }

        $cartBookCount = 0;
        if (isset($_SESSION['user_id'])) {
            $cartBookCount = $this->MainModel->getCartBookCount($_SESSION['user_id']);
        }

        $data = [
            'books' => $books,
            'searchTerm' => $searchTerm,
            'filter' => $filter,
            'noResultsMessage' => $noResultsMessage ?? '',
            'cartBookCount' => $cartBookCount,
            'isBookInCart' => function($bookId) {
                return $this->MainModel->isBookInCart($_SESSION['user_id'], $bookId);
            }
        ];

        $this->view('main', $data);
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /");
        exit();
    }
}
?>
