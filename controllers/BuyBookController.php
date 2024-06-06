<?php
require_once "../models/BuyBookModel.php";

class BuyBookController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new BuyBookModel($dbConnection);
    }

    public function getCartItems($userId) {
        return $this->model->getCartItems($userId);
    }

    public function confirmOrder($userId) {
        return $this->model->confirmOrder($userId);
    }

    public function removeCartItem($userId, $bookId) {
        return $this->model->removeCartItem($userId, $bookId);
    }

    public function updateCartItemQuantity($userId, $bookId, $quantity) {
        return $this->model->updateCartItemQuantity($userId, $bookId, $quantity);
    }
}
?>
