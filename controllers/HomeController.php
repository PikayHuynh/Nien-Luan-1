<?php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/PhanLoai.php';

class HomeController {
    private $db;
    private $productModel;
    private $phanLoaiModel;
    
    public function __construct($db) { 
        $this->db = $db;
        $this->productModel = new HangHoa($db);
        $this->phanLoaiModel = new PhanLoai($db);
    }

    public function index() {
        // Fetch featured products (latest 8 products)
        $featuredProducts = $this->productModel->getPagingClient(8, 0, null, null, null, null, null);
        
        // Fetch categories for display
        $categories = $this->phanLoaiModel->getAll();
        
        // Get total product count for stats
        $totalProducts = $this->productModel->countAllClient();
        
        $title = "Trang chủ";
        include ROOT . '/views/client/layouts/header.php';
        include ROOT . '/views/client/layouts/navbar.php';
        include ROOT . '/views/client/home/index.php';
        include ROOT . '/views/client/layouts/footer.php';
    }
}
