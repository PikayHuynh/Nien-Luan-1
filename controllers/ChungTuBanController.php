<?php
require_once ROOT . '/models/ChungTuBan.php';
require_once ROOT . '/models/ChungTuBanCT.php';
require_once ROOT . '/models/KhachHang.php';
require_once ROOT . '/models/HangHoa.php';

class ChungTuBanController {
    private $model;
    private $khModel;
    private $hangHoaModel;

    public function __construct($db) {
        $this->model = new ChungTuBan($db);
        $this->khModel = new KhachHang($db);
        $this->hangHoaModel = new HangHoa($db);
    }

    public function index() {
        $data = $this->model->getAll();
        include ROOT . '/views/admin/chungtuban/list.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $ct = $this->model->getById($id);

        $ctModel = new ChungTuBanCT($this->model->getConnection());
        $ctChiTiet = $ctModel->getByChungTu($id);

        $khachHang = $this->khModel->getById($ct['ID_KHACHHANG']);
        $hangHoaData = [];
        foreach ($ctChiTiet as $ctItem) {
            $hangHoaData[$ctItem['ID_HANGHOA']] = $this->hangHoaModel->getById($ctItem['ID_HANGHOA']);
        }

        include ROOT . '/views/admin/chungtuban/detail.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->model->create($_POST);

            $ctbctModel = new ChungTuBanCT($this->model->getConnection());
            if(!empty($_POST['ID_HANGHOA'])) {
                foreach($_POST['ID_HANGHOA'] as $i => $idHH) {
                    $ctbctModel->create([
                        'ID_CTBAN' => $id,
                        'ID_HANGHOA' => $idHH,
                        'SOLUONG' => $_POST['SOLUONG'][$i],
                        'DONGIA' => $_POST['DONGIA'][$i]
                    ]);
                }
            }

            header('Location: index.php?controller=chungtuban&action=index');
            exit;
        }

        $khachHangList = $this->khModel->getAll();
        $hangHoaList = $this->hangHoaModel->getAll();
        include ROOT . '/views/admin/chungtuban/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $ct = $this->model->getById($id);

        $ctbctModel = new ChungTuBanCT($this->model->getConnection());
        $ctChiTiet = $ctbctModel->getByChungTu($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);

            $ctbctModel->deleteByChungTu($id);
            if(!empty($_POST['ID_HANGHOA'])) {
                foreach($_POST['ID_HANGHOA'] as $i => $idHH) {
                    $ctbctModel->create([
                        'ID_CTBAN' => $id,
                        'ID_HANGHOA' => $idHH,
                        'SOLUONG' => $_POST['SOLUONG'][$i],
                        'DONGIA' => $_POST['DONGIA'][$i]
                    ]);
                }
            }

            header('Location: index.php?controller=chungtuban&action=index');
            exit;
        }

        $khachHangList = $this->khModel->getAll();
        $hangHoaList = $this->hangHoaModel->getAll();
        include ROOT . '/views/admin/chungtuban/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=chungtuban&action=index');
        exit;
    }
}
