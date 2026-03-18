<?php
require_once 'models/KhachHang.php';

/**
 * Controller quản lý Khách hàng trong khu vực admin.
 * Chịu trách nhiệm cho các thao tác CRUD (Create, Read, Update, Delete).
 */
class KhachHangController
{
    private $model; // Model khách hàng

    /**
     * Khởi tạo controller và nạp model KhachHang.
     *
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->model = new KhachHang($db);
    }

    /**
     * Danh sách khách hàng (có phân trang)
     * - Hỗ trợ tìm kiếm theo tên khách hàng.
     * - Xác định tài khoản admin để khóa các chức năng nhạy cảm trên view.
     */
    public function index()
    {
        require_once ROOT . '/utils/pagination.php';

        $q = trim($_GET['q'] ?? '');

        // Luồng 1: Có thực hiện tìm kiếm
        if ($q !== '') {
            // Khi tìm kiếm, gọi paginate với các phương thức và tham số dành riêng cho tìm kiếm
            $pag = paginate($this->model, [
                'limit'       => 10,
                'pageParam'   => 'page',
                'maxPages'    => 5,
                'getMethod'   => 'searchAndPaginateByName', // Phương thức lấy dữ liệu tìm kiếm
                'countMethod' => 'countSearchResults',      // Phương thức đếm kết quả tìm kiếm
                'getArgs'     => [$q],                      // Truyền $q vào getMethod
                'countArgs'   => [$q],                      // Truyền $q vào countMethod
                'offsetFirst' => true,
            ]);
        }
        // Luồng 2: Không tìm kiếm, chỉ phân trang
        else {
            $pag = paginate($this->model, [
                'limit'       => 10,
                'pageParam'   => 'page',
                'maxPages'    => 5,
                'getMethod'   => 'getAllPaging',
                'countMethod' => 'countAll',
                'offsetFirst' => true, // Model này yêu cầu offset trước limit
            ]);
        }

        $data        = $pag['items'];
        $totalPages  = $pag['totalPages'];
        $currentPage = $pag['currentPage'];
        $startPage   = $pag['startPage'];
        $endPage     = $pag['endPage'];

        // Đánh dấu Admin
        foreach ($data as &$row) {
            $row['IS_ADMIN'] = $this->model->isAdmin($row['ID_KHACH_HANG']);
        }
        unset($row);

        include ROOT . '/views/admin/khachhang/list.php';
    }

    /**
     * Xử lý việc tạo mới một khách hàng.
     * - GET: Hiển thị form tạo mới.
     * - POST: Kiểm tra username, xử lý upload hình ảnh và lưu dữ liệu.
     */
    public function create()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /** ====== KIỂM TRA TRÙNG USERNAME ====== */
            $tenKH = trim($_POST['TEN_KH'] ?? '');
            if ($tenKH !== '' && $this->model->getByName($tenKH)) {
                $error = 'Username đã tồn tại!';
            }

            // Nếu không có lỗi, tiếp tục xử lý
            if ($error === '') {
                // Xử lý upload hình ảnh và gán tên file vào mảng $_POST
                $_POST['HINHANH'] = $this->_handleImageUpload();

                // Lưu khách hàng
                $this->model->create($_POST);

                // Chuyển hướng về trang danh sách sau khi tạo thành công
                header('Location: index.php?controller=khachhang&action=index');
                exit;
            }
        }

        include ROOT . '/views/admin/khachhang/create.php';
    }

    /**
     * Xử lý việc chỉnh sửa một khách hàng.
     * - GET: Hiển thị form với dữ liệu cũ.
     * - POST: Kiểm tra quyền, xử lý upload hình ảnh và cập nhật dữ liệu.
     */
    public function edit()
    {
        $id         = $_GET['id'] ?? 0;
        $khachHang  = $this->model->getById($id);

        // Kiểm tra trạng thái admin
        $khachHang['IS_ADMIN'] = $this->model->isAdmin($id);

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /**  XỬ LÝ USERNAME  */
            if (!empty($khachHang['IS_ADMIN'])) {
                // Nếu là admin → không cho đổi username
                $_POST['TEN_KH'] = $khachHang['TEN_KH'];
            } else {
                $newUsername = trim($_POST['TEN_KH'] ?? '');

                if ($newUsername !== '' && $newUsername !== $khachHang['TEN_KH']) {

                    $existing = $this->model->getByName($newUsername); // Kiểm tra username mới
                    // Nếu username đã tồn tại và không phải chính mình
                    if ($existing && $existing['ID_KHACH_HANG'] != $id) {
                        $error = 'Username đã tồn tại!';
                    }
                }
            }

            /**  UPDATE NẾU KHÔNG LỖI  */
            if ($error === '') {

                // Xử lý upload hình, nếu không có hình mới thì giữ lại hình cũ
                $_POST['HINHANH'] = $this->_handleImageUpload($khachHang['HINHANH'] ?? null);

                // Cập nhật khách hàng
                $this->model->update($id, $_POST);

                header('Location: index.php?controller=khachhang&action=index');
                exit;
            }
        }

        include ROOT . '/views/admin/khachhang/edit.php';
    }

    /**
     * Hiển thị trang chi tiết của một khách hàng.
     */
    public function detail()
    {
        $id        = $_GET['id'] ?? 0;
        $khachHang = $this->model->getById($id);

        include ROOT . '/views/admin/khachhang/detail.php';
    }

    /**
     * Xóa một khách hàng.
     * - Chặn việc xóa tài khoản admin.
     * - Bắt ngoại lệ nếu có lỗi ràng buộc khóa ngoại từ database.
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        // Chặn xóa tài khoản admin
        if ($this->model->isAdmin($id)) {
            echo "<div class='container mt-4'>
                    <div class='alert alert-danger'>
                        Không thể xóa tài khoản quản trị (admin). <br>
                        <a href='index.php?controller=khachhang&action=index'>Quay lại danh sách</a>
                    </div>
                </div>";
            exit;
        }

        try {
            $this->model->delete($id);

            header('Location: index.php?controller=khachhang&action=index');
            exit;
        } catch (Exception $e) {

            echo "<div class='container mt-4'>
                    <div class='alert alert-danger'>
                        <strong>Lỗi:</strong> Không thể xóa khách hàng này. <br>
                        Lý do có thể là khách hàng đã có đơn hàng hoặc dữ liệu liên quan khác. <br>
                        <small>Chi tiết lỗi DB: " . $e->getMessage() . "</small> <br>
                        <a href='index.php?controller=khachhang&action=index' class='mt-2 btn btn-secondary'>Quay lại</a>
                    </div>
                  </div>";
            exit;
        }
    }

    /**
     * Xử lý việc tải lên hình ảnh đại diện.
     * - Nếu có tệp mới được tải lên, nó sẽ được lưu với một tên duy nhất.
     * - Nếu không, nó sẽ giữ lại tên tệp hiện tại.
     *
     * @param string|null $currentImage Tên tệp hình ảnh hiện tại.
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

            // Tạo tên tệp duy nhất bằng cách thêm timestamp
            $timestamp = (int) round(microtime(true) * 1000);
            $newFileName = $timestamp . '_' . basename($_FILES['HINHANH']['name']);

            // Di chuyển tệp đã tải lên vào thư mục đích
            if (move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $newFileName)) {
                return $newFileName; // Trả về tên tệp mới nếu thành công
            }
        }
        // Nếu không có tệp mới, trả về tên hình ảnh hiện tại
        return $currentImage;
    }
}
