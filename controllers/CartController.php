<?php
class CartController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        if(!isset($_SESSION)) session_start();
        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    }

    public function index() {
        $cart = $_SESSION['cart'];
        include ROOT . '/views/client/cart/index.php';
    }

    public function checkout() {
        $cart = $_SESSION['cart'];
        include ROOT . '/views/client/cart/checkout.php';
    }
}
