<?php
require_once 'models/ThuocTinh.php';
require_once 'models/HangHoa.php';

/**
 * Lớp ThuocTinhController quản lý các chức năng liên quan đến thuộc tính.
 */
class ThuocTinhController {
    private $model;
    private $hangHoaModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new ThuocTinh($db);
        $this->hangHoaModel = new HangHoa($db);
    }

    /**
     * Hiển thị danh sách thuộc tính với phân trang.
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

        include ROOT . '/views/admin/thuoctinh/list.php';
    }

    /**
     * Tạo mới một thuộc tính.
     * Xử lý form POST để lưu dữ liệu, bao gồm upload hình ảnh nếu có, sau đó chuyển hướng.
     */
    public function create() {
        $hanghoas = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $ts = (int) round(microtime(true) * 1000);
                $hinhanh = $ts . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->create($_POST);
            header('Location: index.php?controller=thuoctinh&action=index');
            exit;
        }

        include ROOT . '/views/admin/thuoctinh/create.php';
    }

    /**
     * Sửa một thuộc tính hiện có.
     * Xử lý form POST để cập nhật dữ liệu, bao gồm upload hình ảnh mới nếu có, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $thuoctinh = $this->model->getById($id);
        $hanghoas = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhanh = $thuoctinh['HINHANH'];
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $ts = (int) round(microtime(true) * 1000);
                $hinhanh = $ts . '_' . basename($_FILES['HINHANH']['name']);
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }
            $_POST['HINHANH'] = $hinhanh;

            $this->model->update($id, $_POST);
            header('Location: index.php?controller=thuoctinh&action=index');
            exit;
        }

        include ROOT . '/views/admin/thuoctinh/edit.php';
    }

    /**
     * Hiển thị chi tiết một thuộc tính.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $thuoctinh = $this->model->getById($id);
        include ROOT . '/views/admin/thuoctinh/detail.php';
    }

    /**
     * Xóa một thuộc tính.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=thuoctinh&action=index');
        exit;
    }
}