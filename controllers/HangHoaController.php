<?php
require_once 'models/HangHoa.php';
require_once 'models/PhanLoai.php';

/**
 * Lớp HangHoaController quản lý các chức năng liên quan đến hàng hóa (sản phẩm).
 */
class HangHoaController {
    private $model;
    private $phanLoaiModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new HangHoa($db);
        $this->phanLoaiModel = new PhanLoai($db);
    }

    /**
     * Hiển thị danh sách hàng hóa với phân trang.
     */
    public function index() {
        $limit = 10; // Số lượng sản phẩm mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // Lấy danh sách sản phẩm theo phân trang
        $data = $this->model->getPaging($limit, $offset);

        // Tổng số sản phẩm
        $totalProducts = $this->model->countAll();
        $totalPages = ceil($totalProducts / $limit);

        $maxPages = 5;
        $currentPage = $page;

        // Tính toán trang bắt đầu và kết thúc cho phân trang
        $startPage = max(1, $currentPage - floor($maxPages / 2));
        $endPage = min($totalPages, $startPage + $maxPages - 1);

        // Điều chỉnh nếu không đủ số trang hiển thị
        if ($endPage - $startPage + 1 < $maxPages) {
            $startPage = max(1, $endPage - $maxPages + 1);
        }

        include ROOT . '/views/admin/hanghoa/list.php';
    }

    /**
     * Tạo mới một hàng hóa.
     * Xử lý form POST để lưu dữ liệu, bao gồm upload hình ảnh, sau đó chuyển hướng.
     */
    public function create() {
        $phanloaiList = $this->phanLoaiModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $ts = (int) round(microtime(true) * 1000);
                $original = basename($_FILES['HINHANH']['name']);
                $hinhanh = $ts . '_' . $original;
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->create($_POST);
            header('Location: index.php?controller=hanghoa&action=index');
            exit;
        }

        include ROOT . '/views/admin/hanghoa/create.php';
    }

    /**
     * Sửa một hàng hóa hiện có.
     * Xử lý form POST để cập nhật dữ liệu, bao gồm upload hình ảnh mới nếu có, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $hanghoa = $this->model->getById($id);
        $phanloaiList = $this->phanLoaiModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $hanghoa['HINHANH'];
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $ts = (int) round(microtime(true) * 1000);
                $original = basename($_FILES['HINHANH']['name']);
                $hinhanh = $ts . '_' . $original;
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->update($id, $_POST);
            header('Location: index.php?controller=hanghoa&action=index');
            exit;
        }

        include ROOT . '/views/admin/hanghoa/edit.php';
    }

    /**
     * Hiển thị chi tiết một hàng hóa.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $hanghoa = $this->model->getById($id);
        include ROOT . '/views/admin/hanghoa/detail.php';
    }

    /**
     * Xóa một hàng hóa.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=hanghoa&action=index');
        exit;
    }
}