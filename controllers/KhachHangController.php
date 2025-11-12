<?php
require_once 'models/KhachHang.php';

class KhachHangController {
    private $model;

    public function __construct($db) {
        $this->model = new KhachHang($db);
    }

    public function index() {
        // Lấy trang hiện tại
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Lấy dữ liệu phân trang
        $data = $this->model->getAllPaging($offset, $limit);
        $totalRecords = $this->model->countAll();
        $totalPages = ceil($totalRecords / $limit);
        include ROOT . '/views/khachhang/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // upload hình
            $hinhanh = null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;
            $this->model->create($_POST);
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }
        include ROOT . '/views/khachhang/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $khachHang = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $khachHang['HINHANH'];
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;
            $this->model->update($id, $_POST);
            header('Location: index.php?controller=khachhang&action=index');
            exit;
        }

        include ROOT . '/views/khachhang/edit.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $khachHang = $this->model->getById($id);
        include ROOT . '/views/khachhang/detail.php';
    }

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
