<?php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/PhanLoai.php';

/**
 * Controller chính cho trang chủ của client.
 * Chịu trách nhiệm tổng hợp và hiển thị dữ liệu cần thiết cho trang chủ,
 * bao gồm sản phẩm nổi bật và danh sách các danh mục.
 */
class HomeController
{
    private $db;
    private $productModel; // Model sản phẩm
    private $phanLoaiModel; // Model phân loại

    /**
     * Khởi tạo HomeController và nạp các model cần thiết.
     *
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->productModel = new HangHoa($db);
        $this->phanLoaiModel = new PhanLoai($db);
    }

    /**
     * Hiển thị trang chủ.
     * Phương thức này lấy danh sách sản phẩm nổi bật, danh sách các danh mục,
     * và tổng số sản phẩm để truyền sang view.
     */
    public function index()
    {

        // Lấy các danh sách sản phẩm hiển thị trên trang chủ
        $hotProducts = $this->productModel->getHotProducts(8);
        $newProducts = $this->productModel->getNewProducts(8);
        $saleProducts = $this->productModel->getSaleProducts(8);

        // Lấy toàn bộ danh sách danh mục để hiển thị trên menu hoặc sidebar
        $categories = $this->phanLoaiModel->getAll();

        // Tổng số sản phẩm trong hệ thống (dùng cho thống kê)
        $totalProducts = $this->productModel->countAllClient();

        // Tiêu đề trang
        $title = "Trang chủ";

        // Tải các thành phần của giao diện để hiển thị trang chủ
        include ROOT . '/views/client/layouts/header.php';
        include ROOT . '/views/client/layouts/navbar.php';
        include ROOT . '/views/client/home/index.php';
        include ROOT . '/views/client/layouts/footer.php';
    }
}
