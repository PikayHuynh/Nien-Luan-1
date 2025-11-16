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
        // $data = $this->model->getAll();
        $limit = 10; // mỗi trang hiển thị 10 sản phẩm
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // Lấy sản phẩm phân trang
        $data = $this->model->getPaging($limit, $offset);

        // Tổng số sản phẩm
        $totalProducts = $this->model->countAll();
        $totalPages = ceil($totalProducts / $limit);


        // =========================
        //  PHÂN TRANG GIỚI HẠN 5 TRANG
        // =========================

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
