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
        // 1. Lấy ID_PHANLOAI từ URL (để lọc)
        // Nếu có id_phanloai trên URL, nó sẽ được dùng để lọc.
        $id_phanloai = isset($_GET['id_phanloai']) ? (int)$_GET['id_phanloai'] : null;
        $feature = isset($_GET['feature']) ? $_GET['feature'] : null;
        // price range filter format: min-max (e.g. 0-100000)
        $priceRange = isset($_GET['price']) ? $_GET['price'] : null;
        $minPrice = null; $maxPrice = null;
        if ($priceRange) {
            $parts = explode('-', $priceRange);
            if (count($parts) == 2) {
                $minPrice = (int) $parts[0];
                $maxPrice = (int) $parts[1];
            }
        }

        // search query (filter by name or description)
        $q = isset($_GET['q']) ? trim($_GET['q']) : null;
        // Only allow known features; ignore 'service' or any unknown values
        $allowedFeatures = ['new', 'promo'];
        if ($feature === '' || !in_array($feature, $allowedFeatures)) {
            $feature = null;
        }

        // 2. Lấy danh sách Phân loại để hiển thị sidebar lọc
        $phanloaiList = $this->phanLoaiModel->getAll(); 

        $limit = 9; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // 3. Lấy sản phẩm phân trang (Sử dụng hàm client mới và truyền tham số lọc)
        // Hàm này sẽ dùng logic trong HangHoa.php đã cập nhật ở Bước 3.
        $products = $this->productModel->getPagingClient($limit, $offset, $id_phanloai, $feature, $minPrice, $maxPrice, $q); 

        // 4. Tổng số sản phẩm (truyền tham số lọc để đếm đúng số lượng)
        $totalProducts = $this->productModel->countAllClient($id_phanloai, $minPrice, $maxPrice, $q); 
        $totalPages = ceil($totalProducts / $limit);

        // =========================
        // PHÂN TRANG GIỚI HẠN 5 TRANG (Giữ nguyên logic của bạn)
        // =========================
        $maxPages = 5; 
        $currentPage = $page; 

        // Trang bắt đầu và kết thúc
        $startPage = max(1, $currentPage - floor($maxPages / 2));
        $endPage = min($totalPages, $startPage + $maxPages - 1);
        if ($endPage - $startPage + 1 < $maxPages) {
            $startPage = max(1, $endPage - $maxPages + 1);
        }

        // 5. Tạo tham số lọc để giữ trạng thái lọc khi chuyển trang (cho Phân Trang)
        $filter_param = '';
        if ($id_phanloai !== null) $filter_param .= "&id_phanloai=" . $id_phanloai;
        if ($feature) $filter_param .= "&feature=" . urlencode($feature);
        if ($priceRange) $filter_param .= "&price=" . urlencode($priceRange);
        if ($q) $filter_param .= "&q=" . urlencode($q);

        include ROOT . '/views/client/product/list.php';
    }



    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getByIdClient($id);
        include ROOT . '/views/client/product/detail.php';
    }
}