<?php
require_once 'models/DonGiaBan.php';
require_once 'models/HangHoa.php';

class DonGiaBanController {
    private $model;
    private $hangHoaModel;

    public function __construct($db) {
        $this->model = new DonGiaBan($db);
        $this->hangHoaModel = new HangHoa($db);
    }

    public function index() {
        $data = $this->model->getAll();
        include ROOT . '/views/dongiaban/list.php';
    }

    public function create() {
        $hanghoas = $this->hangHoaModel->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header('Location: index.php?controller=dongiaban&action=index');
            exit;
        }
        include ROOT . '/views/dongiaban/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $dongia = $this->model->getById($id);
        $hanghoas = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header('Location: index.php?controller=dongiaban&action=index');
            exit;
        }

        include ROOT . '/views/dongiaban/edit.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $dongia = $this->model->getById($id);
        include ROOT . '/views/dongiaban/detail.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=dongiaban&action=index');
        exit;
    }
}
 