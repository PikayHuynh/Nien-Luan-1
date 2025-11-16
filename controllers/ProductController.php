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
        // $products = $this->productModel->getAllClient();
        $limit = 16; // mỗi trang hiển thị 16 sản phẩm
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // Lấy sản phẩm phân trang
        $products = $this->productModel->getPaging($limit, $offset);

        // Tổng số sản phẩm
        $totalProducts = $this->productModel->countAll();
        $totalPages = ceil($totalProducts / $limit);


        // =========================
        //  PHÂN TRANG GIỚI HẠN 5 TRANG
        // =========================

        $maxPages = 5;              // số trang muốn hiển thị một lần
        $currentPage = $page;       // đổi tên cho dễ hiểu

        // Trang bắt đầu
        $startPage = max(1, $currentPage - floor($maxPages / 2));

        // Trang kết thúc
        $endPage = min($totalPages, $startPage + $maxPages - 1);

        // Nếu cuối danh sách không đủ 5 trang → dịch startPage lại
        if ($endPage - $startPage + 1 < $maxPages) {
            $startPage = max(1, $endPage - $maxPages + 1);
        }
        include ROOT . '/views/client/product/list.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getByIdClient($id);
        include ROOT . '/views/client/product/detail.php';
    }
}
