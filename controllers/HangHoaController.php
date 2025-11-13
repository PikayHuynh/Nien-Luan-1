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
        $data = $this->model->getAll();
        include ROOT . '/views/admin/hanghoa/list.php';
    }

    public function create() {
        $phanloaiList = $this->phanLoaiModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = null;
            if(!empty($_FILES['HINHANH']['name'])){
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
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
            if(!empty($_FILES['HINHANH']['name'])){
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
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
