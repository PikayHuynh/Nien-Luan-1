<?php
require_once 'models/HangHoa.php';
require_once 'models/PhanLoai.php'; // để lấy danh sách phân loại

class HangHoaController {
    private $model;
    private $phanLoaiModel;

    public function __construct($db) {
        $this->model = new HangHoa($db);
        $this->phanLoaiModel = new PhanLoai($db);
    }

    public function index() {
        // $data = $this->model->getAll();
        // $products = $this->productModel->getAllClient();
        $limit = 10; // mỗi trang hiển thị 10 sản phẩm
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // Lấy sản phẩm phân trang
        $data = $this->model->getPaging($limit, $offset);

        // Tổng số sản phẩm
        $totalProducts = $this->model->countAll();
        $totalPages = ceil($totalProducts / $limit);

        $maxPages = 5;              // số trang muốn hiển thị một lần
        $currentPage = $page;       // đổi tên cho dễ hiểu

        // Trang bắt đầu
        $startPage = max(1, $currentPage - floor($maxPages / 2));

        // Trang kết thúc
        $endPage = min($totalPages, $startPage + $maxPages - 1);

        // Nếu cuối danh sách không đủ 5 trang → dịch startPage lại
        if ($endPage - $startPage + 1 < $maxPages) {
            $startPage = max(1, $endPage - $maxPages + 1);
        }
        include ROOT . '/views/admin/hanghoa/list.php';
    }

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

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $hanghoa = $this->model->getById($id);
        include ROOT . '/views/admin/hanghoa/detail.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=hanghoa&action=index');
        exit;
    }
}
