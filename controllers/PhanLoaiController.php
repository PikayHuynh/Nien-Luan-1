<?php
require_once 'models/PhanLoai.php';

/**
 * Controller quản lý Phân Loại (Danh mục sản phẩm)
 * Bao gồm: danh sách – thêm – sửa – xem – xóa
 */
class PhanLoaiController
{
    private $model;

    /**
     * Khởi tạo controller và nạp model
     */
    public function __construct($db)
    {
        $this->model = new PhanLoai($db);
    }

    /**
     * Danh sách phân loại (có phân trang)
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

        // Dữ liệu gửi sang view
        $data        = $page['items'];
        $totalPages  = $page['totalPages'];
        $currentPage = $page['currentPage'];
        $startPage   = $page['startPage'];
        $endPage     = $page['endPage'];

        include ROOT . '/views/admin/phanloai/list.php';
    }

    /**
     * Thêm phân loại mới
     * - Upload hình nếu có
     */
    public function create()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $hinhanh = null;

            /** ====== UPLOAD HÌNH (NẾU CÓ) ====== */
            if (!empty($_FILES['HINHANH']['name'])) {

                $targetDir = __DIR__ . '/../upload/';

                // Tạo thư mục upload nếu chưa có
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Tên file duy nhất
                $ts       = (int) round(microtime(true) * 1000);
                $hinhanh  = $ts . '_' . basename($_FILES['HINHANH']['name']);

                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }

            $_POST['HINHANH'] = $hinhanh;

            // Lưu phân loại
            $this->model->create($_POST);

            header('Location: index.php?controller=phanloai&action=index');
            exit;
        }

        include ROOT . '/views/admin/phanloai/create.php';
    }

    /**
     * Sửa phân loại
     * - Giữ hình cũ nếu không upload hình mới
     */
    public function edit()
    {
        $id       = $_GET['id'] ?? 0;
        $phanloai = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $hinhanh = $phanloai['HINHANH']; // Giữ hình cũ

            /** ====== UPLOAD HÌNH MỚI ====== */
            if (!empty($_FILES['HINHANH']['name'])) {

                $targetDir = __DIR__ . '/../upload/';

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $ts       = (int) round(microtime(true) * 1000);
                $hinhanh  = $ts . '_' . basename($_FILES['HINHANH']['name']);

                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }

            $_POST['HINHANH'] = $hinhanh;

            // Cập nhật phân loại
            $this->model->update($id, $_POST);

            header('Location: index.php?controller=phanloai&action=index');
            exit;
        }

        include ROOT . '/views/admin/phanloai/edit.php';
    }

    /**
     * Xem chi tiết phân loại
     */
    public function detail()
    {
        $id       = $_GET['id'] ?? 0;
        $phanloai = $this->model->getById($id);

        include ROOT . '/views/admin/phanloai/detail.php';
    }

    /**
     * Xóa phân loại
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        if ($this->model->hasHangHoa($id)) {
            header(
                'Location: index.php?controller=phanloai&action=index&error=has_hanghoa'
            );
            exit;
        }


        $this->model->delete($id);

        header('Location: index.php?controller=phanloai&action=index');
        exit;
    }
}
