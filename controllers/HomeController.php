<?php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/PhanLoai.php';

/**
 * Lớp HomeController quản lý trang chủ phía client.
 */
class HomeController {
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
     * Hiển thị trang chủ với sản phẩm nổi bật, danh mục và thống kê.
     */
    public function index() {
        // Lấy 8 sản phẩm nổi bật (mới nhất)
        $featuredProducts = $this->productModel->getPagingClient(8, 0, null, null, null, null, null);

        // Lấy danh sách danh mục
        $categories = $this->phanLoaiModel->getAll();

        // Lấy tổng số sản phẩm
        $totalProducts = $this->productModel->countAllClient();

        $title = "Trang chủ";
        include ROOT . '/views/client/layouts/header.php';
        include ROOT . '/views/client/layouts/navbar.php';
        include ROOT . '/views/client/home/index.php';
        include ROOT . '/views/client/layouts/footer.php';
    }
}