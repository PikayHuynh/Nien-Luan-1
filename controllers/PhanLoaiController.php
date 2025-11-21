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
        require_once ROOT . '/utils/pagination.php';

        $pag = paginate($this->model, [
            'limit' => 10,
            'pageParam' => 'page',
            'maxPages' => 5,
            'getMethod' => 'getPaging',
            'countMethod' => 'countAll',
        ]);

        $data = $pag['items'];
        $totalPages = $pag['totalPages'];
        $currentPage = $pag['currentPage'];
        $startPage = $pag['startPage'];
        $endPage = $pag['endPage'];

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