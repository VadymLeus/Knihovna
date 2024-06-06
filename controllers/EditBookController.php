<?php
require_once "../core/Controller.php";

class EditBookController extends Controller {
    private $editBookModel;

    public function __construct() {
        require_once "../models/EditBookModel.php";
        $this->editBookModel = new EditBookModel();
    }

    public function getBookById($id) {
        return $this->editBookModel->getBookById($id);
    }

    public function updateBook($id, $title, $author, $price, $discount, $quantity, $genre, $imagePath) {
        return $this->editBookModel->updateBook($id, $title, $author, $price, $discount, $quantity, $genre, $imagePath);
    }

    public function deleteBook($id) {
        return $this->editBookModel->deleteBook($id);
    }
}
?>
