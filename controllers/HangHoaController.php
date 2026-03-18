<?php
require_once 'models/HangHoa.php';
require_once 'models/PhanLoai.php';

/**
 * Controller quản lý Hàng Hóa (Sản phẩm) trong khu vực admin.
 * Chịu trách nhiệm cho các thao tác CRUD (Create, Read, Update, Delete).
 */
class HangHoaController
{
    private $model;            // Model hàng hóa
    private $phanLoaiModel;    // Model phân loại

    /**
     * Khởi tạo controller và nạp các model cần thiết.
     *
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->model          = new HangHoa($db);
        $this->phanLoaiModel  = new PhanLoai($db);
    }

    /**
     * Hiển thị danh sách hàng hóa với chức năng phân trang.
     */
    public function index()
    {
        // Sử dụng helper phân trang để lấy dữ liệu và thông tin trang
        require_once ROOT . '/utils/pagination.php';

        $page = paginate($this->model, [
            'limit'       => 10,
            'pageParam'   => 'page',
            'maxPages'    => 5,
            'getMethod'   => 'getPaging',
            'countMethod' => 'countAll',
        ]);

        // Trích xuất các biến từ kết quả phân trang để truyền sang view
        $data        = $page['items'];
        $totalPages  = $page['totalPages'];
        $currentPage = $page['currentPage'];
        $startPage   = $page['startPage'];
        $endPage     = $page['endPage'];

        include ROOT . '/views/admin/hanghoa/list.php';
    }

    /**
     * Xử lý việc tạo mới một hàng hóa.
     * - GET: Hiển thị form tạo mới.
     * - POST: Xử lý upload hình ảnh và lưu dữ liệu vào cơ sở dữ liệu.
     */
    public function create()
    {
        // Nếu là POST request, xử lý lưu dữ liệu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload hình ảnh và gán tên file vào mảng $_POST
            $_POST['HINHANH'] = $this->_handleImageUpload();

            // Gọi model để tạo hàng hóa
            $this->model->create($_POST);

            // Chuyển hướng về trang danh sách sau khi tạo thành công
            header('Location: index.php?controller=hanghoa&action=index');
            exit;
        }

        // Nếu là GET request, load danh sách phân loại để hiển thị trong form
        $phanloaiList = $this->phanLoaiModel->getAll();
        include ROOT . '/views/admin/hanghoa/create.php';
    }

    /**
     * Xử lý việc chỉnh sửa một hàng hóa.
     * - GET: Hiển thị form với dữ liệu cũ.
     * - POST: Xử lý upload hình ảnh mới (nếu có) và cập nhật dữ liệu.
     */
    public function edit()
    {
        $id        = $_GET['id'] ?? 0;
        $hanghoa   = $this->model->getById($id);

        // Nếu là POST request, xử lý cập nhật dữ liệu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý upload hình, nếu không có hình mới thì giữ lại hình cũ
            $_POST['HINHANH'] = $this->_handleImageUpload($hanghoa['HINHANH'] ?? null);

            // Gọi model để cập nhật hàng hóa
            $this->model->update($id, $_POST);

            // Chuyển hướng về trang danh sách sau khi cập nhật
            header('Location: index.php?controller=hanghoa&action=index');
            exit;
        }

        // Nếu là GET request, load dữ liệu cần thiết cho form
        $phanloaiList = $this->phanLoaiModel->getAll();
        include ROOT . '/views/admin/hanghoa/edit.php';
    }

    /**
     * Chi tiết hàng hóa
     */
    public function detail()
    {
        $id       = $_GET['id'] ?? 0;
        // Lấy thông tin chi tiết của hàng hóa để truyền sang view
        $hanghoa  = $this->model->getById($id);

        include ROOT . '/views/admin/hanghoa/detail.php';
    }

    /**
     * Xóa một hàng hóa và các bản ghi liên quan.
     * Việc xóa các bản ghi phụ thuộc được xử lý trong `HangHoa::delete()`.
     * Sau khi xóa, chuyển hướng người dùng về trang danh sách.
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        $this->model->delete($id);

        header('Location: index.php?controller=hanghoa&action=index');
        exit;
    }

    /**
     * Xử lý việc tải lên hình ảnh cho hàng hóa.
     * - Nếu có tệp mới được tải lên, nó sẽ được lưu với một tên duy nhất.
     * - Nếu không, nó sẽ giữ lại tên tệp hiện tại.
     *
     * @param string|null $currentImage Tên tệp hình ảnh hiện tại (để giữ lại nếu không có upload mới).
     * @return string|null Tên tệp hình ảnh mới hoặc tên tệp hiện tại.
     */
    private function _handleImageUpload($currentImage = null)
    {
        // Kiểm tra xem có tệp nào được tải lên và không có lỗi không
        if (isset($_FILES['HINHANH']) && $_FILES['HINHANH']['error'] === UPLOAD_ERR_OK) {
            // Đường dẫn đến thư mục upload
            $targetDir = ROOT . '/upload/';

            // Tạo thư mục upload nếu nó chưa tồn tại
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Tạo tên tệp duy nhất bằng cách thêm timestamp vào trước tên gốc
            $timestamp = (int) round(microtime(true) * 1000);
            $originalName = basename($_FILES['HINHANH']['name']);
            $newFileName = $timestamp . '_' . $originalName;

            // Di chuyển tệp đã tải lên vào thư mục đích
            if (move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $newFileName)) {
                return $newFileName; // Trả về tên tệp mới nếu thành công
            }
        }

        // Nếu không có tệp mới nào được tải lên, trả về tên hình ảnh hiện tại
        return $currentImage;
    }
}
