<?php
require_once "../models/HistoryModel.php";

class HistoryController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new HistoryModel($dbConnection);
        
    }

    public function getUserOrders($userId) {
        return $this->model->getUserOrders($userId);
    }

    public function getAllOrdersWithUserEmails() {
        return $this->model->getAllOrdersWithUserEmails();
    }

    public function getUserOrdersWithSearch($userId, $searchBook) {
        return $this->model->getUserOrdersWithSearch($userId, $searchBook);
    }

    public function getUserOrdersByEmail($email) {
        return $this->model->getUserOrdersByEmail($email);
    }
}
?>
