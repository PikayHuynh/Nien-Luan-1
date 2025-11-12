<?php
require_once 'models/PhanLoai.php';

class PhanLoaiController {
    private $model;

    public function __construct($db) {
        $this->model = new PhanLoai($db);
    }

    public function index() {
        $data = $this->model->getAll();
        include ROOT . '/views/phanloai/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->create($_POST);
            header('Location: index.php?controller=phanloai&action=index');
            exit;
        }
        include ROOT . '/views/phanloai/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $phanloai = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $phanloai['HINHANH'];
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = "uploads/";
                $hinhanh = time() . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->update($id, $_POST);
            header('Location: index.php?controller=phanloai&action=index');
            exit;
        }

        include ROOT . '/views/phanloai/edit.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $phanloai = $this->model->getById($id);
        include ROOT . '/views/phanloai/detail.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=phanloai&action=index');
        exit;
    }
}
