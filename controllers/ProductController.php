<?php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/PhanLoai.php';
require_once ROOT . '/models/DonGiaBan.php';

/**
 * Lớp ProductController quản lý các chức năng liên quan đến sản phẩm phía client.
 */
class ProductController {
    private $db;
    private $productModel;
    private $phanLoaiModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new HangHoa($db);
        $this->phanLoaiModel = new PhanLoai($db);
    }

    /**
     * Hiển thị danh sách sản phẩm với lọc, sắp xếp và phân trang.
     */
    public function list() {
        // Lấy ID phân loại
        $id_phanloai = isset($_GET['id_phanloai']) ? (int)$_GET['id_phanloai'] : null;

        // Lọc theo tính năng
        $feature = isset($_GET['feature']) ? $_GET['feature'] : null;
        $allowedFeatures = ['new', 'promo'];
        if ($feature === '' || !in_array($feature, $allowedFeatures)) {
            $feature = null;
        }

        // Lọc và sắp xếp theo giá
        $priceParam = isset($_GET['price']) ? $_GET['price'] : null;
        $minPrice = $maxPrice = null;
        $sortPrice = null;

        if ($priceParam) {
            if (strpos($priceParam, '-') !== false) {
                // Lọc khoảng giá
                $parts = explode('-', $priceParam);
                if (count($parts) == 2) {
                    $minPrice = (int)$parts[0];
                    $maxPrice = (int)$parts[1];
                }
            } elseif ($priceParam === 'price_asc' || $priceParam === 'price_desc') {
                // Sắp xếp theo giá
                $sortPrice = $priceParam;
            }
        }

        // Tìm kiếm
        $q = isset($_GET['q']) ? trim($_GET['q']) : null;

        // Danh sách phân loại cho sidebar
        $phanloaiList = $this->phanLoaiModel->getAll();

        // Phân trang
        $limit = 9;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;
        $currentPage = $page;

        // Lấy danh sách sản phẩm
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

        // Phân trang giới hạn 5 trang
        $maxPages = 5;
        $startPage = max(1, $page - floor($maxPages / 2));
        $endPage = min($totalPages, $startPage + $maxPages - 1);

        if ($endPage - $startPage + 1 < $maxPages) {
            $startPage = max(1, $endPage - $maxPages + 1);
        }

        // Giữ tham số lọc khi phân trang
        $filter_param = '';
        if ($id_phanloai) $filter_param .= "&id_phanloai=$id_phanloai";
        if ($feature) $filter_param .= "&feature=" . urlencode($feature);
        if ($priceParam) $filter_param .= "&price=" . urlencode($priceParam);
        if ($q) $filter_param .= "&q=" . urlencode($q);

        include ROOT . '/views/client/product/list.php';
    }

    /**
     * Hiển thị chi tiết một sản phẩm.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getByIdClient($id);
        include ROOT . '/views/client/product/detail.php';
    }
}