<?php
require_once 'models/KhachHang.php';
require_once 'models/PhanLoai.php';
require_once 'models/HangHoa.php';
require_once 'models/ThuocTinh.php';
require_once 'models/DonGiaBan.php';
require_once 'models/ChungTuMua.php';
require_once 'models/ChungTuMuaCT.php';
require_once 'models/ChungTuBan.php';
require_once 'models/ChungTuBanCT.php';
require_once 'models/Kho.php';

/**
 * Controller quản lý trang Dashboard trong admin
 * Hiển thị các thống kê tổng quan hệ thống
 */
class DashboardController
{
    private $conn;

    /**
     * Truyền kết nối database vào controller
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Trang dashboard:
     * - Khởi tạo model
     * - Lấy tổng số bản ghi từ từng bảng
     * - Truyền dữ liệu sang view
     */
    public function index()
    {

        // Khởi tạo model
        $khModel = new KhachHang($this->conn);
        $plModel = new PhanLoai($this->conn);
        $hhModel = new HangHoa($this->conn);
        $ttModel = new ThuocTinh($this->conn);
        $dgbModel = new DonGiaBan($this->conn);
        $ctmModel = new ChungTuMua($this->conn);
        $ctmctModel = new ChungTuMuaCT($this->conn);
        $ctbModel = new ChungTuBan($this->conn);
        $ctbctModel = new ChungTuBanCT($this->conn);
        $khoModel = new Kho($this->conn);

        /**
         * Lấy tổng số lượng bản ghi từ từng bảng
         * Dùng count(getAll()) → phù hợp logic hiện tại của dự án bạn
         */
        $data = [
            'khachhang' => count($khModel->getAll()),
            'phanloai' => count($plModel->getAll()),
            'hanghoa' => count($hhModel->getAll()),
            'thuoctinh' => count($ttModel->getAll()),
            'dongiaban' => count($dgbModel->getAll()),
            'chungtumua' => count($ctmModel->getAll()),
            'chungtumua_ct' => count($ctmctModel->getAll()),
            'chungtuban' => count($ctbModel->getAll()),
            'chungtuban_ct' => count($ctbctModel->getAll()),
            'kho' => $khoModel->countAll(),

            // Dữ liệu biểu đồ doanh thu
            'revenueData' => $ctbModel->getRevenueByDay(date('m'), date('Y'))
        ];

        // Hiển thị giao diện dashboard
        include ROOT . '/views/admin/dashboard/index.php';
    }

    /**
     * Trang lịch sử thông báo Admin
     */
    public function notifications()
    {
        require_once ROOT . '/models/ThongBao.php';
        require_once ROOT . '/utils/pagination.php';
        $tbModel = new ThongBao($this->conn);

        $page = paginate($tbModel, [
            'limit' => 10,
            'getMethod' => 'getPagingForAdmin',
            'countMethod' => 'countAllForAdmin'
        ]);

        $notifications = $page['items'];
        $totalPages = $page['totalPages'];
        $currentPage = $page['currentPage'];
        $pages = $page['pages'];

        include ROOT . '/views/admin/dashboard/notifications.php';
    }
}
