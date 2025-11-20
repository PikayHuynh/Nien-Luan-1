<?php
require_once 'models/KhachHang.php';

/**
 * Lớp KhachHangController quản lý các chức năng liên quan đến khách hàng.
 */
class KhachHangController {
    private $model;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new KhachHang($db);
    }

    /**
     * Hiển thị danh sách khách hàng với phân trang.
     */
    public function index() {
        // Lấy trang hiện tại
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Lấy dữ liệu phân trang
        $data = $this->model->getAllPaging($offset, $limit);
        $totalRecords = $this->model->countAll();
        $totalPages = ceil($totalRecords / $limit);

        include ROOT . '/views/admin/khachhang/list.php';
    }

    /**
     * Tạo mới một khách hàng.
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
                $original = basename($_FILES['HINHANH']['name']);
                $hinhanh = $ts . '_' . $original;
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;
            $this->model->create($_POST);
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }
        include ROOT . '/views/admin/khachhang/create.php';
    }

    /**
     * Sửa một khách hàng hiện có.
     * Xử lý form POST để cập nhật dữ liệu, bao gồm upload hình ảnh mới nếu có, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $khachHang = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $khachHang['HINHANH'];
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
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }

        include ROOT . '/views/admin/khachhang/edit.php';
    }

    /**
     * Hiển thị chi tiết một khách hàng.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $khachHang = $this->model->getById($id);
        include ROOT . '/views/admin/khachhang/detail.php';
    }

    /**
     * Xóa một khách hàng.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        try {
            $this->model->delete($id);
            header('Location: index.php?controller=khachhang&action=index');
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>".$e->getMessage()."</div>";
        }
        exit;
    }
}