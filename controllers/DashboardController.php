<?php
require_once 'models/KhachHang.php';
require_once 'models/PhanLoai.php';
require_once 'models/HangHoa.php';
require_once 'models/ThuocTinh.php';
require_once 'models/DonGiaBan.php';
require_once 'models/ChungTuMua.php';
require_once 'models/ChungTuMuaCT.php';
require_once 'models/ChungTuBan.php';
require_once 'models/ChungTuBanCT.php';

class DashboardController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function index() {
        // Tạo object từng model
        $khModel = new KhachHang($this->conn);
        $plModel = new PhanLoai($this->conn);
        $hhModel = new HangHoa($this->conn);
        $ttModel = new ThuocTinh($this->conn);
        $dgbModel = new DonGiaBan($this->conn);
        $ctmModel = new ChungTuMua($this->conn);
        $ctmctModel = new ChungTuMuaCT($this->conn);
        $ctbModel = new ChungTuBan($this->conn);
        $ctbctModel = new ChungTuBanCT($this->conn);

        // Lấy tổng số record từng module
        $data = [
            'khachhang' => count($khModel->getAll()),
            'phanloai' => count($plModel->getAll()),
            'hanghoa' => count($hhModel->getAll()),
            'thuoctinh' => count($ttModel->getAll()),
            'dongiaban' => count($dgbModel->getAll()),
            'chungtumua' => count($ctmModel->getAll()),
            'chungtumua_ct' => count($ctmctModel->getAll()),
            'chungtuban' => count($ctbModel->getAll()),
            'chungtuban_ct' => count($ctbctModel->getAll())
        ];

        include ROOT . '/views/dashboard/index.php';
    }
}
