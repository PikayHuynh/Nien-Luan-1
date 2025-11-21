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
        require_once ROOT . '/utils/pagination.php';

        $pag = paginate($this->model, [
            'limit' => 10,
            'pageParam' => 'page',
            'maxPages' => 5,
            'getMethod' => 'getAllPaging',
            'countMethod' => 'countAll',
            'offsetFirst' => true,
        ]);

        $data = $pag['items'];
        // Mark which rows are admin so views can hide actions like delete
        foreach ($data as &$row) {
            $row['IS_ADMIN'] = $this->model->isAdmin($row['ID_KHACH_HANG']);
        }
        unset($row);
        $totalPages = $pag['totalPages'];
        $currentPage = $pag['currentPage'];
        $page = $currentPage; // keep legacy variable used in view
        $startPage = $pag['startPage'];
        $endPage = $pag['endPage'];

        include ROOT . '/views/admin/khachhang/list.php';
    }

    /**
     * Tạo mới một khách hàng.
     * Xử lý form POST để lưu dữ liệu, bao gồm upload hình ảnh, sau đó chuyển hướng.
     */
    public function create() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = null;
            $username = trim($_POST['TEN_KH'] ?? '');
            // Ensure username is unique
            if ($username !== '' && $this->model->getByName($username)) {
                $error = 'Username đã tồn tại!';
            }

            if ($error === '') {
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

        // mark admin status for view and logic
        $khachHang['IS_ADMIN'] = $this->model->isAdmin($id);
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $khachHang['HINHANH'];

            // If this account is admin, do not allow changing the username
            if (!empty($khachHang['IS_ADMIN'])) {
                $_POST['TEN_KH'] = $khachHang['TEN_KH'];
            } else {
                $newUsername = trim($_POST['TEN_KH'] ?? '');
                if ($newUsername !== '' && $newUsername !== $khachHang['TEN_KH']) {
                    $existing = $this->model->getByName($newUsername);
                    if ($existing && $existing['ID_KHACH_HANG'] != $id) {
                        $error = 'Username đã tồn tại!';
                    }
                }
            }

            if ($error === '') {
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
        // Prevent deleting admin accounts
        if ($this->model->isAdmin($id)) {
            echo "<div class='container mt-4'><div class='alert alert-danger'>Không thể xóa tài khoản quản trị (admin).</div></div>";
            exit;
        }

        try {
            $this->model->delete($id);
            header('Location: index.php?controller=khachhang&action=index');
        } catch (Exception $e) {
            echo "<div class='container mt-4'><div class='alert alert-danger'>".$e->getMessage()."</div></div>";
        }
        exit;
    }
}