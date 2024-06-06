<?php
class Model {
    protected $db;
    public function __construct() {
        require '../core/database.php';
        $this->db = $db;
    }
}
?>
