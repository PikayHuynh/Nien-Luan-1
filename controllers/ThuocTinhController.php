<?php
require_once 'models/ThuocTinh.php';
require_once 'models/HangHoa.php';

class ThuocTinhController {
    private $model;
    private $hangHoaModel;

    public function __construct($db) {
        $this->model = new ThuocTinh($db);
        $this->hangHoaModel = new HangHoa($db);
    }

    public function index() {
        $data = $this->model->getAll();
        include ROOT . '/views/thuoctinh/list.php';
    }

    public function create() {
        $hanghoas = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // upload hình nếu có
            $hinhanh = null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->create($_POST);
            header('Location: index.php?controller=thuoctinh&action=index');
            exit;
        }

        include ROOT . '/views/thuoctinh/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $thuoctinh = $this->model->getById($id);
        $hanghoas = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $thuoctinh['HINHANH'];
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->update($id, $_POST);
            header('Location: index.php?controller=thuoctinh&action=index');
            exit;
        }

        include ROOT . '/views/thuoctinh/edit.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $thuoctinh = $this->model->getById($id);
        include ROOT . '/views/thuoctinh/detail.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=thuoctinh&action=index');
        exit;
    }
}
