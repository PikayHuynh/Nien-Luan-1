<?php
require_once 'models/DonGiaBan.php';
require_once 'models/HangHoa.php';

/**
 * Lớp DonGiaBanController quản lý các chức năng liên quan đến đơn giá bán.
 */
class DonGiaBanController {
    private $model;
    private $hangHoaModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new DonGiaBan($db);
        $this->hangHoaModel = new HangHoa($db);
    }

    /**
     * Hiển thị danh sách đơn giá bán với phân trang.
     */
    public function index() {
        require_once ROOT . '/utils/pagination.php';

        $pag = paginate($this->model, [
            'limit' => 10,
            'pageParam' => 'page',
            'maxPages' => 5,
            'getMethod' => 'getPaging',
            'countMethod' => 'countAll',
        ]);

        $data = $pag['items'];
        $totalPages = $pag['totalPages'];
        $currentPage = $pag['currentPage'];
        $startPage = $pag['startPage'];
        $endPage = $pag['endPage'];

        include ROOT . '/views/admin/dongiaban/list.php';
    }

    /**
     * Tạo mới một đơn giá bán.
     * Xử lý form POST để lưu dữ liệu, sau đó chuyển hướng.
     */
    public function create() {
        $hanghoas = $this->hangHoaModel->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);
            header('Location: index.php?controller=dongiaban&action=index');
            exit;
        }
        include ROOT . '/views/admin/dongiaban/create.php';
    }

    /**
     * Sửa một đơn giá bán hiện có.
     * Xử lý form POST để cập nhật dữ liệu, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $dongia = $this->model->getById($id);
        $hanghoas = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header('Location: index.php?controller=dongiaban&action=index');
            exit;
        }

        include ROOT . '/views/admin/dongiaban/edit.php';
    }

    /**
     * Hiển thị chi tiết một đơn giá bán.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $dongia = $this->model->getById($id);
        include ROOT . '/views/admin/dongiaban/detail.php';
    }

    /**
     * Xóa một đơn giá bán.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=dongiaban&action=index');
        exit;
    }
}