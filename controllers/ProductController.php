<?php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/DonGiaBan.php';

class ProductController {
    private $db;
    private $productModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new HangHoa($db);
    }

    public function list() {
        $products = $this->productModel->getAllClient();
        include ROOT . '/views/client/product/list.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getByIdClient($id);
        include ROOT . '/views/client/product/detail.php';
    }
}
