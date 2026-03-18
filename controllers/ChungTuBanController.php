<?php
require_once ROOT . '/models/ChungTuBan.php';
require_once ROOT . '/models/ChungTuBanCT.php';
require_once ROOT . '/models/KhachHang.php';
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/Kho.php';
/**
 * Controller quản lý Chứng từ Bán (đơn hàng của khách) trong khu vực admin.
 * Bao gồm các chức năng: danh sách, xem chi tiết, thêm, sửa, xóa.
 */
class ChungTuBanController
{
    private $model;        // Model ChungTuBan (master)
    private $ctctModel;    // Model ChungTuBanCT (detail)
    private $khModel;      // Model KhachHang
    private $hangHoaModel; // Model HangHoa
    private $khoModel;     // Model Kho

    /**
     * Khởi tạo controller và nạp các model cần thiết.
     *
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->model         = new ChungTuBan($db);
        $this->ctctModel     = new ChungTuBanCT($db);
        $this->khModel       = new KhachHang($db);
        $this->hangHoaModel  = new HangHoa($db);
        $this->khoModel      = new Kho($db);
    }

    /**
     * Hiển thị danh sách chứng từ bán với chức năng tìm kiếm và phân trang.
     * - Khi có tham số tìm kiếm `q`, thực hiện tìm kiếm trên toàn bộ dữ liệu.
     * - Khi không có, thực hiện phân trang bình thường.
     * - Đo lường thời gian thực thi cho mục đích phân tích hiệu năng.
     */
    public function index()
    {
        require_once ROOT . '/utils/pagination.php';
        require_once ROOT . '/utils/searching.php';
        $q = trim($_GET['q'] ?? '');

        // Luồng 1: Có thực hiện tìm kiếm
        if ($q !== '') {
            // 1. Lấy toàn bộ dữ liệu đã được sắp xếp theo tên khách hàng từ DB
            $all = $this->model->searchByName($q);

            // 2. Lọc kết quả bằng PHP (có thể dùng cho binary search hoặc filter)
            $exact = filter_by_field($all, 'TEN_KH', $q); // Lọc các kết quả chứa chuỗi q

            if ($exact !== null) {
                $data = $exact;
            } else {
                // 3. (Luồng dự phòng) Tìm kiếm tuần tự nếu cần
                $data = search_products($all, $q);
            }

            // Khi tìm kiếm, hiển thị tất cả kết quả trên một trang
            $totalPages = $currentPage = $startPage = $endPage = 1;
        }
        // Luồng 2: Không tìm kiếm, chỉ phân trang
        else {
            $pag = paginate($this->model, [
                'limit'       => 10,
                'pageParam'   => 'page',
                'maxPages'    => 5,
                'getMethod'   => 'getPaging',
                'countMethod' => 'countAll',
            ]);

            // Lấy kết quả từ hàm phân trang
            $data        = $pag['items'];
            $totalPages  = $pag['totalPages'];
            $currentPage = $pag['currentPage'];
            $startPage   = $pag['startPage'];
            $endPage     = $pag['endPage'];
        }

        // Cung cấp các model cho view để lấy thông tin liên quan (tên khách hàng,...)
        $khModel      = $this->khModel;
        $hangHoaModel = $this->hangHoaModel;

        include ROOT . '/views/admin/chungtuban/list.php';
    }

    /**
     * Hiển thị trang chi tiết của một chứng từ bán.
     * Lấy thông tin master, chi tiết, khách hàng và hàng hóa liên quan.
     */
    public function detail()
    {
        $id = $_GET['id'] ?? 0;

        // Lấy thông tin chứng từ
        $ct = $this->model->getById($id);

        // Lấy chi tiết chứng từ (sử dụng model đã được inject)
        $ctChiTiet   = $this->ctctModel->getByChungTu($id);

        // Lấy thông tin khách hàng
        $khachHang   = $this->khModel->getById($ct['ID_KHACHHANG']);

        // Lấy thông tin hàng hóa cho từng dòng chi tiết
        $hangHoaData = [];
        foreach ($ctChiTiet as $ctItem) {
            $hangHoaData[$ctItem['ID_HANGHOA']] = $this->hangHoaModel->getById($ctItem['ID_HANGHOA']);
        }

        include ROOT . '/views/admin/chungtuban/detail.php';
    }

    /**
     * Xử lý việc tạo mới một chứng từ bán.
     * - GET: Hiển thị form tạo mới.
     * - POST: Lưu chứng từ (master) và các chi tiết (detail) của nó.
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Tạo chứng từ bán (master) và lấy ID vừa tạo
            $id = $this->model->create($_POST);

            // 2. Tạo các dòng chi tiết (detail) cho chứng từ đó
            if (!empty($_POST['ID_HANGHOA'])) {
                foreach ($_POST['ID_HANGHOA'] as $i => $idHH) {
                    $this->ctctModel->create([
                        'ID_CTBAN'   => $id,
                        'ID_HANGHOA' => $idHH,
                        'SOLUONG'    => $_POST['SOLUONG'][$i],
                        'DONGIA'     => $_POST['DONGIA'][$i]
                    ]);
                    $this->hangHoaModel->updateQuantity($idHH, -$_POST['SOLUONG'][$i]);
                    $this->khoModel->create($idHH, null, $id, $_POST['SOLUONG'][$i], 'BAN');
                }
            }

            header('Location: index.php?controller=chungtuban&action=index');
            exit;
        }

        // Nếu là GET request, load dữ liệu cần thiết cho form
        $khachHangList = $this->khModel->getAll();
        $hangHoaList   = $this->hangHoaModel->getAll();

        include ROOT . '/views/admin/chungtuban/create.php';
    }

    /**
     * Xử lý việc chỉnh sửa một chứng từ bán.
     * - GET: Hiển thị form với dữ liệu cũ.
     * - POST: Cập nhật master, xóa tất cả chi tiết cũ và ghi lại chi tiết mới.
     */
    public function edit()
    {
        $id = $_GET['id'] ?? 0;

        // Lấy chứng từ
        $ct = $this->model->getById($id);

        // Nếu không tồn tại → quay về danh sách
        if (!$ct) {
            header('Location: index.php?controller=chungtuban&action=index');
            exit;
        }

        // Lấy chi tiết cũ để hiển thị trên form
        $ctChiTiet  = $this->ctctModel->getByChungTu($id);

        // Nếu submit form → xử lý cập nhật
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Cập nhật thông tin master của chứng từ
            $this->model->update($id, $_POST);

            // Rollback HangHoa SOLUONG cho các chi tiết cũ
            $oldDetails = $this->ctctModel->getByChungTu($id);
            if ($oldDetails) {
                foreach ($oldDetails as $od) {
                    $this->hangHoaModel->updateQuantity($od['ID_HANGHOA'], $od['SOLUONG']); // Cộng lại kho vì bị trừ đi khi bán
                }
            }
            $this->khoModel->deleteByCtBan($id);

            // 2. Xoá toàn bộ chi tiết cũ
            $this->ctctModel->deleteByChungTu($id);

            // 3. Tạo lại các dòng chi tiết mới từ dữ liệu form
            if (!empty($_POST['ID_HANGHOA'])) {
                foreach ($_POST['ID_HANGHOA'] as $i => $idHH) {
                    $this->ctctModel->create([
                        'ID_CTBAN'   => $id,
                        'ID_HANGHOA' => $idHH,
                        'SOLUONG'    => $_POST['SOLUONG'][$i],
                        'DONGIA'     => $_POST['DONGIA'][$i]
                    ]);
                    $this->hangHoaModel->updateQuantity($idHH, -$_POST['SOLUONG'][$i]);
                    $this->khoModel->create($idHH, null, $id, $_POST['SOLUONG'][$i], 'BAN');
                }
            }

            header('Location: index.php?controller=chungtuban&action=index');
            exit;
        }

        // Nếu là GET, load dữ liệu cho các dropdown list trong form
        $khachHangList = $this->khModel->getAll() ?: [];
        $hangHoaList   = $this->hangHoaModel->getAll() ?: [];
        $ctChiTiet     = $ctChiTiet ?: [];

        include ROOT . '/views/admin/chungtuban/edit.php';
    }

    /**
     * Xóa một chứng từ bán và các chi tiết liên quan.
     * Việc xóa chi tiết được xử lý bên trong `ChungTuBan::delete()`.
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        $this->model->delete($id);

        header('Location: index.php?controller=chungtuban&action=index');
        exit;
    }
}
