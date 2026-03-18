<?php
require_once 'models/DonGiaBan.php';
require_once 'models/HangHoa.php';

/**
 * Controller quản lý Đơn giá bán trong khu vực admin.
 * Chịu trách nhiệm cho các thao tác CRUD (Create, Read, Update, Delete)
 * đối với đơn giá của sản phẩm.
 */
class DonGiaBanController
{
    private $model;          // Model đơn giá bán
    private $hangHoaModel;   // Model hàng hóa

    /**
     * Khởi tạo controller và nạp các model cần thiết.
     *
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->model         = new DonGiaBan($db);
        $this->hangHoaModel  = new HangHoa($db);
    }

    /**
     * Hiển thị danh sách các đơn giá bán với chức năng phân trang và tìm kiếm.
     */
    public function index()
    {
        // Sử dụng helper phân trang để lấy dữ liệu và thông tin trang
        require_once ROOT . '/utils/pagination.php';

        // Lấy từ khóa tìm kiếm từ query string
        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

        // Cấu hình phân trang
        $config = [
            'limit'       => 10,
            'pageParam'   => 'page',
            'maxPages'    => 5,
            'getMethod'   => 'getPaging',
            'countMethod' => 'countAll',
        ];

        // Nếu có từ khóa tìm kiếm, sử dụng phương thức tìm kiếm
        if (!empty($searchQuery)) {
            $config['getMethod']   = 'searchPaging';
            $config['countMethod'] = 'countSearch';
            $config['getArgs']     = [$searchQuery];
            $config['countArgs']   = [$searchQuery];
        }

        $page = paginate($this->model, $config);

        // Trích xuất các biến từ kết quả phân trang để truyền sang view
        $data        = $page['items'];
        $totalPages  = $page['totalPages'];
        $currentPage = $page['currentPage'];
        $startPage   = $page['startPage'];
        $endPage     = $page['endPage'];

        include ROOT . '/views/admin/dongiaban/list.php';
    }

    /**
     * Xử lý việc tạo mới một đơn giá bán.
     * - GET: Hiển thị form tạo mới.
     * - POST: Lưu dữ liệu từ form vào cơ sở dữ liệu.
     */
    public function create()
    {
        // Nếu là POST request, xử lý lưu dữ liệu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->create($_POST);

            // Chuyển hướng về trang danh sách sau khi tạo thành công
            header('Location: index.php?controller=dongiaban&action=index');
            exit;
        }

        // Nếu là GET request, load danh sách hàng hóa để hiển thị trong form
        $hanghoas = $this->hangHoaModel->getAll();

        include ROOT . '/views/admin/dongiaban/create.php';
    }

    /**
     * Xử lý việc chỉnh sửa một đơn giá bán.
     * - GET: Hiển thị form với dữ liệu cũ của đơn giá.
     * - POST: Cập nhật dữ liệu mới vào cơ sở dữ liệu.
     */
    public function edit()
    {
        $id        = $_GET['id'] ?? 0;

        // Nếu là POST request, xử lý cập nhật dữ liệu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);

            // Chuyển hướng về trang danh sách sau khi cập nhật
            header('Location: index.php?controller=dongiaban&action=index');
            exit;
        }

        // Nếu là GET request, lấy dữ liệu hiện tại để hiển thị trên form
        $dongia    = $this->model->getById($id);
        $hanghoas  = $this->hangHoaModel->getAll();

        include ROOT . '/views/admin/dongiaban/edit.php';
    }

    /**
     * Hiển thị trang chi tiết của một đơn giá bán.
     */
    public function detail()
    {
        $id     = $_GET['id'] ?? 0;
        // Lấy thông tin chi tiết của đơn giá để truyền sang view
        $dongia = $this->model->getById($id);

        include ROOT . '/views/admin/dongiaban/detail.php';
    }

    /**
     * Xóa đơn giá bán
     * Sau khi xóa, chuyển hướng người dùng về trang danh sách.
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        $this->model->delete($id);

        header('Location: index.php?controller=dongiaban&action=index');
        exit;
    }
}
