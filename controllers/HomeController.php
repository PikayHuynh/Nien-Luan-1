<?php

class HomeController {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function index() {
        $title = "Trang chủ";
        include ROOT . '/views/client/layouts/header.php';
        include ROOT . '/views/client/layouts/navbar.php';
        include ROOT . '/views/client/home/index.php';
        include ROOT . '/views/client/layouts/footer.php';
    }
}
