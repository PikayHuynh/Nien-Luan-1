<?php
require_once 'models/PhanLoai.php';

/**
 * Lớp PhanLoaiController quản lý các chức năng liên quan đến phân loại (danh mục).
 */
class PhanLoaiController {
    private $model;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new PhanLoai($db);
    }

    /**
     * Hiển thị danh sách phân loại với phân trang.
     */
    public function index() {
        $limit = 10; // Số lượng phân loại mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // Lấy danh sách phân loại theo phân trang
        $data = $this->model->getPaging($limit, $offset);

        // Tổng số phân loại
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

        include ROOT . '/views/admin/phanloai/list.php';
    }

    /**
     * Tạo mới một phân loại.
     * Xử lý form POST để lưu dữ liệu, bao gồm upload hình ảnh, sau đó chuyển hướng.
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $ts = (int) round(microtime(true) * 1000);
                $hinhanh = $ts . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->create($_POST);
            header('Location: index.php?controller=phanloai&action=index');
            exit;
        }
        include ROOT . '/views/admin/phanloai/create.php';
    }

    /**
     * Sửa một phân loại hiện có.
     * Xử lý form POST để cập nhật dữ liệu, bao gồm upload hình ảnh mới nếu có, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $phanloai = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $phanloai['HINHANH'];
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $ts = (int) round(microtime(true) * 1000);
                $hinhanh = $ts . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->update($id, $_POST);
            header('Location: index.php?controller=phanloai&action=index');
            exit;
        }

        include ROOT . '/views/admin/phanloai/edit.php';
    }

    /**
     * Hiển thị chi tiết một phân loại.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $phanloai = $this->model->getById($id);
        include ROOT . '/views/admin/phanloai/detail.php';
    }

    /**
     * Xóa một phân loại.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=phanloai&action=index');
        exit;
    }
}