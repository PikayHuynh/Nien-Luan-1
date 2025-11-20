<?php
// controllers/ProductController.php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/PhanLoai.php'; // <== Dòng Cần Thêm (hoặc đảm bảo đã có)
require_once ROOT . '/models/DonGiaBan.php';

class ProductController {
    private $db;
    private $productModel;
    private $phanLoaiModel; // <== Dòng Cần Thêm

    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new HangHoa($db);
        $this->phanLoaiModel = new PhanLoai($db); // <== Dòng Cần Thêm
    }

    public function list() {
        // Lấy ID_PHANLOAI
        $id_phanloai = isset($_GET['id_phanloai']) ? (int)$_GET['id_phanloai'] : null;

        // Feature filter
        $feature = isset($_GET['feature']) ? $_GET['feature'] : null;
        $allowedFeatures = ['new', 'promo'];
        if ($feature === '' || !in_array($feature, $allowedFeatures)) {
            $feature = null;
        }

        // PRICE FILTER (lọc + sort)
        $priceParam = isset($_GET['price']) ? $_GET['price'] : null;
        $minPrice = $maxPrice = null;
        $sortPrice = null;

        if ($priceParam) {
            if (strpos($priceParam, '-') !== false) {
                // lọc khoảng giá
                $parts = explode('-', $priceParam);
                if (count($parts) == 2) {
                    $minPrice = (int)$parts[0];
                    $maxPrice = (int)$parts[1];
                }
            } elseif ($priceParam === 'price_asc' || $priceParam === 'price_desc') {
                // sắp xếp theo giá
                $sortPrice = $priceParam;
            }
        }

        // SEARCH
        $q = isset($_GET['q']) ? trim($_GET['q']) : null;

        // Phân loại sidebar
        $phanloaiList = $this->phanLoaiModel->getAll();

        // PAGINATION
        $limit = 9;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;
        $currentPage = $page; // để view dùng phân trang


        // Lấy sản phẩm
        $products = $this->productModel->getPagingClient(
            $limit, $offset,
            $id_phanloai,
            $feature,
            $minPrice, $maxPrice,
            $q,
            $sortPrice
        );

        // Tổng số sản phẩm
        $totalProducts = $this->productModel->countAllClient(
            $id_phanloai,
            $minPrice, $maxPrice,
            $q
        );

        $totalPages = ceil($totalProducts / $limit);

        // PHÂN TRANG TỐI ĐA 5 TRANG
        $maxPages = 5;
        $startPage = max(1, $page - floor($maxPages / 2));
        $endPage   = min($totalPages, $startPage + $maxPages - 1);

        if ($endPage - $startPage + 1 < $maxPages) {
            $startPage = max(1, $endPage - $maxPages + 1);
        }

        // GIỮ THAM SỐ LỌC KHI PHÂN TRANG
        $filter_param = '';
        if ($id_phanloai) $filter_param .= "&id_phanloai=$id_phanloai";
        if ($feature) $filter_param .= "&feature=" . urlencode($feature);
        if ($priceParam) $filter_param .= "&price=" . urlencode($priceParam);
        if ($q) $filter_param .= "&q=" . urlencode($q);

        include ROOT . '/views/client/product/list.php';
    }


    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getByIdClient($id);
        include ROOT . '/views/client/product/detail.php';
    }
}