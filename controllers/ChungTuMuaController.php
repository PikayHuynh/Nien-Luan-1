<?php
require_once ROOT . '/models/ChungTuMua.php';
require_once ROOT . '/models/ChungTuMuaCT.php';
require_once ROOT . '/models/KhachHang.php';
require_once ROOT . '/models/HangHoa.php';

class ChungTuMuaController {
    private $model;
    private $ctctModel;
    private $khModel;
    private $hhModel;

    public function __construct($db) {
        $this->model = new ChungTuMua($db);
        $this->ctctModel = new ChungTuMuaCT($db);
        $this->khModel = new KhachHang($db);
        $this->hhModel = new HangHoa($db);
    }

    public function index() {
        $data = $this->model->getAll();
        include ROOT . '/views/admin/chungtumua/list.php';
    }

    public function detail() {
        $id = $_GET['id'] ?? 0;
        $ctm = $this->model->getById($id);
        $ctmct = $this->ctctModel->getByCTMua($id);
        include ROOT . '/views/admin/chungtumua/detail.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=chungtumua&action=index');
        exit;
    }
}
