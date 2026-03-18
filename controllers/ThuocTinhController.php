<?php
require_once 'models/ThuocTinh.php';
require_once 'models/HangHoa.php';

/**
 * Controller quản lý Thuộc Tính sản phẩm
 * Bao gồm: danh sách – thêm – sửa – xem – xóa
 */
class ThuocTinhController
{
    private $model;
    private $hangHoaModel;

    /**
     * Khởi tạo controller và nạp model
     */
    public function __construct($db)
    {
        $this->model         = new ThuocTinh($db);
        $this->hangHoaModel  = new HangHoa($db);
    }

    /**
     * Danh sách thuộc tính (có phân trang)
     */
    public function index()
    {
        require_once ROOT . '/utils/pagination.php';

        $page = paginate($this->model, [
            'limit'       => 10,
            'pageParam'   => 'page',
            'maxPages'    => 5,
            'getMethod'   => 'getPaging',
            'countMethod' => 'countAll',
        ]);

        // Truyền dữ liệu sang view
        $data        = $page['items'];
        $totalPages  = $page['totalPages'];
        $currentPage = $page['currentPage'];
        $startPage   = $page['startPage'];
        $endPage     = $page['endPage'];

        include ROOT . '/views/admin/thuoctinh/list.php';
    }

    /**
     * Thêm thuộc tính mới
     * - Upload hình (nếu có)
     * - Lưu thuộc tính
     */
    public function create()
    {

        // Lấy danh sách hàng hóa để hiển thị select
        $hanghoas = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** ==== UPLOAD HÌNH (NẾU CÓ) ==== */
            $hinhanh = null;

            if (!empty($_FILES['HINHANH']['name'])) {

                $targetDir = __DIR__ . '/../upload/';

                // Tạo thư mục nếu chưa có
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Tên file duy nhất
                $ts       = (int) round(microtime(true) * 1000);
                $filename = basename($_FILES['HINHANH']['name']);
                $hinhanh  = $ts . '_' . $filename;

                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }

            $_POST['HINHANH'] = $hinhanh;

            // Lưu thuộc tính
            $this->model->create($_POST);

            header('Location: index.php?controller=thuoctinh&action=index');
            exit;
        }

        include ROOT . '/views/admin/thuoctinh/create.php';
    }

    /**
     * Sửa thuộc tính:
     * - Giữ hình cũ nếu không upload mới
     * - Upload hình mới nếu người dùng chọn
     */
    public function edit()
    {
        $id         = $_GET['id'] ?? 0;
        $thuoctinh  = $this->model->getById($id);
        $hanghoas   = $this->hangHoaModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $hinhanh = $thuoctinh['HINHANH']; // giữ hình cũ

            /** ==== UPLOAD HÌNH MỚI (NẾU CÓ) ==== */
            if (!empty($_FILES['HINHANH']['name'])) {

                $targetDir = __DIR__ . '/../upload/';

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $ts       = (int) round(microtime(true) * 1000);
                $filename = basename($_FILES['HINHANH']['name']);
                $hinhanh  = $ts . '_' . $filename;

                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }

            $_POST['HINHANH'] = $hinhanh;

            // Cập nhật
            $this->model->update($id, $_POST);

            header('Location: index.php?controller=thuoctinh&action=index');
            exit;
        }

        include ROOT . '/views/admin/thuoctinh/edit.php';
    }

    /**
     * Chi tiết thuộc tính
     */
    public function detail()
    {
        $id         = $_GET['id'] ?? 0;
        $thuoctinh  = $this->model->getById($id);

        include ROOT . '/views/admin/thuoctinh/detail.php';
    }

    /**
     * Xóa thuộc tính
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        $this->model->delete($id);

        header('Location: index.php?controller=thuoctinh&action=index');
        exit;
    }
}
