<?php
require_once ROOT . '/models/ChungTuMua.php';
require_once ROOT . '/models/ChungTuMuaCT.php';
require_once ROOT . '/models/KhachHang.php';
require_once ROOT . '/models/HangHoa.php';

/**
 * Lớp ChungTuMuaController quản lý các chức năng liên quan đến chứng từ mua hàng.
 */
class ChungTuMuaController {
    private $model;
    private $ctctModel;
    private $khModel;
    private $hhModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new ChungTuMua($db);
        $this->ctctModel = new ChungTuMuaCT($db);
        $this->khModel = new KhachHang($db);
        $this->hhModel = new HangHoa($db);
    }

    /**
     * Hiển thị danh sách chứng từ mua hàng với phân trang.
     */
    public function index() {
        $limit = 10; // Số lượng chứng từ mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $limit;

        // Lấy danh sách chứng từ theo phân trang
        $data = $this->model->getPaging($limit, $offset);

        // Tổng số chứng từ
        $totalProducts = $this->model->countAll();
        $totalPages = ceil($totalProducts / $limit);

        $maxPages = 5;
        $currentPage = $page;

        // Tính toán trang bắt đầu và kết thúc cho phân trang
        $startPage = max(1, $currentPage - floor($maxPages / 2));
        $endPage = min($totalPages, $startPage + $maxPages - 1);

        // Điều chỉnh nếu không đủ số trang hiển thị
        if ($endPage - $startPage + 1 < $maxPages) {
            $startPage = max(1, $endPage - $maxPages + 1);
        }

        include ROOT . '/views/admin/chungtumua/list.php';
    }

    /**
     * Hiển thị chi tiết một chứng từ mua hàng.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $ctm = $this->model->getById($id);
        $ctmct = $this->ctctModel->getByCTMua($id);
        include ROOT . '/views/admin/chungtumua/detail.php';
    }

    /**
     * Tạo mới một chứng từ mua hàng.
     * Xử lý form POST để lưu dữ liệu, sau đó chuyển hướng.
     */
    public function create() {
        $kh = $this->khModel->getAll();
        $hh = $this->hhModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MASOCT' => $_POST['MASOCT'] ?? 'CTM-' . time(),
                'NGAYPHATSINH' => $_POST['NGAYPHATSINH'] ?? date('Y-m-d H:i:s'),
                'ID_KHACHHANG' => $_POST['ID_KHACHHANG'] ?? null,
                'TONGTIENHANG' => $_POST['TONGTIENHANG'] ?? 0,
                'THUE' => $_POST['THUE'] ?? 0
            ];

            $id = $this->model->create($data);
            header('Location: index.php?controller=chungtumua&action=index');
            exit;
        }

        include ROOT . '/views/admin/chungtumua/create.php';
    }

    /**
     * Sửa một chứng từ mua hàng hiện có.
     * Xử lý form POST để cập nhật dữ liệu, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $ctm = $this->model->getById($id);
        if (!$ctm) {
            header('Location: index.php?controller=chungtumua&action=index');
            exit;
        }

        $kh = $this->khModel->getAll();
        $hh = $this->hhModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MASOCT' => $_POST['MASOCT'] ?? $ctm['MASOCT'],
                'NGAYPHATSINH' => $_POST['NGAYPHATSINH'] ?? $ctm['NGAYPHATSINH'],
                'ID_KHACHHANG' => $_POST['ID_KHACHHANG'] ?? $ctm['ID_KHACHHANG'],
                'TONGTIENHANG' => $_POST['TONGTIENHANG'] ?? $ctm['TONGTIENHANG'],
                'THUE' => $_POST['THUE'] ?? $ctm['THUE']
            ];

            $this->model->update($id, $data);
            header('Location: index.php?controller=chungtumua&action=detail&id=' . $id);
            exit;
        }

        include ROOT . '/views/admin/chungtumua/edit.php';
    }

    /**
     * Xóa một chứng từ mua hàng.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=chungtumua&action=index');
        exit;
    }
}