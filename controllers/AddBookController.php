<?php
require_once "../core/Controller.php";

class AddBookController extends Controller {
    private $addBookModel;

    public function __construct() {
        require_once "../models/AddBookModel.php";
        $this->addBookModel = new AddBookModel();
    }

    public function addNewBook($title, $author, $price, $discount, $quantity, $genre, $imagePath) {
        return $this->addBookModel->insertBook($title, $author, $price, $discount, $quantity, $genre, $imagePath);
    }
}
?>
