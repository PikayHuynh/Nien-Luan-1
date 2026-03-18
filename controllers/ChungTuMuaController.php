<?php
require_once ROOT . '/models/ChungTuMua.php';
require_once ROOT . '/models/ChungTuMuaCT.php';
require_once ROOT . '/models/KhachHang.php';
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/Kho.php';

/**
 * Controller quản lý Chứng từ Mua (phiếu nhập hàng) trong khu vực admin.
 * Bao gồm các chức năng: danh sách, xem chi tiết, thêm, sửa, xóa.
 */
class ChungTuMuaController
{
    private $model;        // Model chứng từ mua (master)
    private $ctctModel;    // Model chi tiết chứng từ
    private $khModel;      // Model khách hàng
    private $hangHoaModel; // Model hàng hóa
    private $khoModel;     // Model kho

    /**
     * Khởi tạo controller và nạp các model cần thiết.
     *
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->model = new ChungTuMua($db);
        $this->ctctModel = new ChungTuMuaCT($db);
        $this->khModel = new KhachHang($db);
        $this->hangHoaModel = new HangHoa($db);
        $this->khoModel = new Kho($db);
    }

    /**
     * Hiển thị danh sách chứng từ mua với chức năng tìm kiếm và phân trang.
     * - Khi có tham số `q`, thực hiện tìm kiếm theo ngày phát sinh.
     * - Khi không có, thực hiện phân trang bình thường.
     *
     * @note Để tối ưu hiệu năng, logic tìm kiếm nên được chuyển xuống Model
     *       để truy vấn trực tiếp từ database thay vì tải tất cả và lọc bằng PHP.
     */
    public function index()
    {
        require_once ROOT . '/utils/pagination.php';

        $q = trim($_GET['q'] ?? '');

        // Luồng 1: Có thực hiện tìm kiếm
        if ($q !== '') {
            // Lấy toàn bộ chứng từ để thực hiện lọc bằng PHP
            $all = $this->model->getAll();

            // Lọc theo ngày phát sinh chứa chuỗi tìm kiếm
            $data = array_filter($all, function ($item) use ($q) {
                $date = $item['NGAYPHATSINH'] ?? '';
                return str_contains($date, $q);
            });
            $data = array_values($data); // Reset lại chỉ số mảng

            // Khi tìm kiếm, hiển thị tất cả kết quả trên một trang
            $totalPages = $currentPage = $startPage = $endPage = 1;
        }
        // Luồng 2: Không tìm kiếm, chỉ phân trang
        else {
            $page = paginate($this->model, [
                'limit' => 10,
                'pageParam' => 'page',
                'maxPages' => 5,
                'getMethod' => 'getPaging',
                'countMethod' => 'countAll',
            ]);

            // Lấy kết quả từ hàm phân trang
            $data = $page['items'];
            $totalPages = $page['totalPages'];
            $currentPage = $page['currentPage'];
            $startPage = $page['startPage'];
            $endPage = $page['endPage'];
        }
        include ROOT . '/views/admin/chungtumua/list.php';
    }


    /**
     * Hiển thị trang chi tiết của một chứng từ mua.
     * Lấy thông tin master và các dòng chi tiết liên quan.
     */
    public function detail()
    {
        $id = $_GET['id'] ?? 0;

        // Lấy thông tin chứng từ (master)
        $ctm = $this->model->getById($id);

        // Lấy chi tiết các mặt hàng (detail)
        $ctmct = $this->ctctModel->getByChungTu($id);

        include ROOT . '/views/admin/chungtumua/detail.php';
    }

    /**
     * Xử lý việc tạo mới một chứng từ mua.
     * - GET: Hiển thị form tạo mới.
     * - POST: Lưu chứng từ (master). Chi tiết sẽ được thêm ở màn hình sửa.
     */
    public function create()
    {
        // Nếu là POST request, xử lý lưu dữ liệu
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Chuẩn bị dữ liệu từ form để tạo chứng từ
            $data = [
                'MASOCT' => $_POST['MASOCT'] ?? 'CTM-' . time(),
                'NGAYPHATSINH' => $_POST['NGAYPHATSINH'] ?? date('Y-m-d H:i:s'),
                'ID_KHACHHANG' => $_POST['ID_KHACHHANG'] ?? null,
                'TONGTIENHANG' => $_POST['TONGTIENHANG'] ?? 0,
                'THUE' => $_POST['THUE'] ?? 10,
            ];

            // Gọi model để tạo chứng từ
            $this->model->create($data);

            header('Location: index.php?controller=chungtumua&action=index');
            exit;
        }

        // Nếu là GET request, load dữ liệu cần thiết cho form
        $khachHangList = $this->khModel->getAll();
        $hangHoaList = $this->hangHoaModel->getAll();

        include ROOT . '/views/admin/chungtumua/create.php';
    }

    /**
     * Xử lý việc chỉnh sửa một chứng từ mua.
     * - GET: Hiển thị form với dữ liệu cũ.
     * - POST: Cập nhật master, xóa tất cả chi tiết cũ và ghi lại chi tiết mới.
     */
    public function edit()
    {
        $id = $_GET['id'] ?? 0;

        // Lấy dữ liệu chứng từ hiện tại
        $ctm = $this->model->getById($id);
        if (!$ctm) {
            header('Location: index.php?controller=chungtumua&action=index');
            exit;
        }

        // Nếu là POST request, xử lý cập nhật
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Cập nhật thông tin master của chứng từ
            $data = [
                'MASOCT' => $_POST['MASOCT'] ?? $ctm['MASOCT'],
                'NGAYPHATSINH' => $_POST['NGAYPHATSINH'] ?? $ctm['NGAYPHATSINH'],
                'ID_KHACHHANG' => $_POST['ID_KHACHHANG'] ?? $ctm['ID_KHACHHANG'],
                'TONGTIENHANG' => $_POST['TONGTIENHANG'] ?? $ctm['TONGTIENHANG'],
                'THUE' => $_POST['THUE'] ?? $ctm['THUE'],
            ];
            $this->model->update($id, $data);

            // Rollback HangHoa SOLUONG cho các chi tiết cũ
            $oldDetails = $this->ctctModel->getByChungTu($id);
            if ($oldDetails) {
                foreach ($oldDetails as $od) {
                    $this->hangHoaModel->updateQuantity($od['ID_HANGHOA'], -$od['SOLUONG']);
                }
            }
            $this->khoModel->deleteByCtMua($id);

            // 2. Xử lý cập nhật các dòng chi tiết (detail)
            if (!empty($_POST['ID_HANGHOA']) && is_array($_POST['ID_HANGHOA'])) {

                // Xoá toàn bộ chi tiết cũ để đảm bảo tính nhất quán
                $this->ctctModel->deleteByChungTu($id);

                // Tạo lại các dòng chi tiết mới từ dữ liệu form
                foreach ($_POST['ID_HANGHOA'] as $i => $idHH) {
                    $soluong = $_POST['SOLUONG'][$i] ?? 0;
                    $giamua = $_POST['GIAMUA'][$i] ?? 0;

                    $this->ctctModel->create([
                        'ID_CTMUA' => $id,
                        'ID_HANGHOA' => $idHH,
                        'SOLUONG' => $soluong,
                        'GIAMUA' => $giamua,
                    ]);

                    $this->hangHoaModel->updateQuantity($idHH, $soluong);
                    $this->khoModel->create($idHH, $id, null, $soluong, 'MUA');
                }
            }

            // Chuyển hướng về trang chi tiết sau khi cập nhật
            header('Location: index.php?controller=chungtumua&action=detail&id=' . $id);
            exit;
        }

        // Nếu là GET request, load dữ liệu cần thiết cho form
        $khachHangList = $this->khModel->getAll() ?: [];
        $hangHoaList = $this->hangHoaModel->getAll() ?: [];
        $ctmct = $this->ctctModel->getByChungTu($id) ?: [];

        include ROOT . '/views/admin/chungtumua/edit.php';
    }

    /**
     * Xóa một chứng từ mua và các chi tiết liên quan.
     * Việc xóa chi tiết được xử lý bên trong `ChungTuMua::delete()`.
     */
    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        $this->model->delete($id);

        header('Location: index.php?controller=chungtumua&action=index');
        exit;
    }
}
