<?php
require_once ROOT . '/models/ChungTuBan.php';
require_once ROOT . '/models/ChungTuBanCT.php';
require_once ROOT . '/models/KhachHang.php';
require_once ROOT . '/models/HangHoa.php';

/**
 * Lớp ChungTuBanController quản lý các chức năng liên quan đến chứng từ bán hàng (đơn hàng).
 */
class ChungTuBanController {
    private $model;
    private $khModel;
    private $hangHoaModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new ChungTuBan($db);
        $this->khModel = new KhachHang($db);
        $this->hangHoaModel = new HangHoa($db);
    }

    /**
     * Hiển thị danh sách chứng từ bán hàng với phân trang.
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

        include ROOT . '/views/admin/chungtuban/list.php';
    }

    /**
     * Hiển thị chi tiết một chứng từ bán hàng.
     */
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

    /**
     * Tạo mới một chứng từ bán hàng.
     * Xử lý form POST để lưu dữ liệu, sau đó chuyển hướng.
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->model->create($_POST);

            $ctbctModel = new ChungTuBanCT($this->model->getConnection());
            if (!empty($_POST['ID_HANGHOA'])) {
                foreach ($_POST['ID_HANGHOA'] as $i => $idHH) {
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

    /**
     * Sửa một chứng từ bán hàng hiện có.
     * Xử lý form POST để cập nhật dữ liệu, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $ct = $this->model->getById($id);

        $ctbctModel = new ChungTuBanCT($this->model->getConnection());
        $ctChiTiet = $ctbctModel->getByChungTu($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);

            // Xóa chi tiết cũ và tạo mới
            $ctbctModel->deleteByChungTu($id);
            if (!empty($_POST['ID_HANGHOA'])) {
                foreach ($_POST['ID_HANGHOA'] as $i => $idHH) {
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

    /**
     * Xóa một chứng từ bán hàng.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=chungtuban&action=index');
        exit;
    }
}