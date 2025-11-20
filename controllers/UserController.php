<?php
require_once ROOT . '/models/KhachHang.php';

/**
 * Lớp UserController quản lý các chức năng liên quan đến người dùng.
 */
class UserController {
    private $khModel;
    private $db;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và model KhachHang.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->db = $db;
        $this->khModel = new KhachHang($db);
    }

    /**
     * Xử lý trang đăng nhập.
     * Kiểm tra thông tin đăng nhập và chuyển hướng dựa trên quyền hạn.
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenKH = $_POST['TEN_KH'] ?? '';
            $matkhau = $_POST['MATKHAU'] ?? '';

            $user = $this->khModel->getByName($tenKH);
            if ($user && $user['PASSWORD'] === $matkhau) {
                $_SESSION['user_id'] = $user['ID_KHACH_HANG'];
                $_SESSION['user_name'] = $user['TEN_KH'];

                // Chuyển hướng dựa trên quyền
                if ($this->khModel->isAdmin($user['ID_KHACH_HANG'])) {
                    header("Location: index.php?controller=dashboard&action=index");
                } else {
                    header("Location: index.php?controller=home&action=index");
                }
                exit;
            } else {
                $error = $user ? "Sai mật khẩu!" : "User không tồn tại!";
            }
        }

        include ROOT . '/views/client/user/login.php';
    }

    /**
     * Xử lý trang đăng ký.
     * Kiểm tra thông tin và tạo tài khoản mới nếu hợp lệ.
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Mật khẩu không khớp!";
            } elseif ($this->khModel->getByName($username)) {
                $error = "Username đã tồn tại!";
            } else {
                $this->khModel->create([
                    'TEN_KH' => $username,
                    'PASSWORD' => $password,
                    'DIACHI' => '',
                    'SODIENTHOAI' => '',
                    'HINHANH' => null,
                    'SOB' => 'user'
                ]);
                header("Location: index.php?controller=user&action=login");
                exit;
            }
        }

        include ROOT . '/views/client/user/register.php';
    }

    /**
     * Hiển thị trang hồ sơ người dùng.
     * Yêu cầu đăng nhập.
     */
    public function profile() {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $user = $this->khModel->getById($userId);
        $isAdmin = $this->khModel->isAdmin($userId);

        include ROOT . '/views/client/user/profile.php';
    }

    /**
     * Xử lý chỉnh sửa hồ sơ người dùng.
     * Cập nhật thông tin và ảnh đại diện nếu có.
     */
    public function editProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->khModel->getById($userId);
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['TEN_KH'] ?? '';
            $diachi = $_POST['DIACHI'] ?? '';
            $sdt = $_POST['SODIENTHOAI'] ?? '';

            // Xử lý upload ảnh đại diện
            $hinhanh = $user['HINHANH'] ?? null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $ts = (int) round(microtime(true) * 1000);
                $original = basename($_FILES['HINHANH']['name']);
                $hinhanh = $ts . '_' . $original;
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }

            // Dữ liệu cập nhật
            $updateData = [
                'TEN_KH' => $username,
                'DIACHI' => $diachi,
                'SODIENTHOAI' => $sdt,
                'HINHANH' => $hinhanh,
                'SOB' => $user['SOB'] ?? 'user'
            ];

            if ($this->khModel->update($userId, $updateData)) {
                $success = "Cập nhật thông tin thành công!";
                $_SESSION['user_name'] = $username;
                $user = $this->khModel->getById($userId);
            } else {
                $error = "Cập nhật thất bại!";
            }
        }

        include ROOT . '/views/client/user/edit_profile.php';
    }

    /**
     * Hiển thị danh sách đơn hàng của người dùng.
     * Yêu cầu đăng nhập.
     */
    public function orders() {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        require_once ROOT . '/models/ChungTuBan.php';
        $orderModel = new ChungTuBan($this->db);
        $orders = $orderModel->getByUserId($userId);

        include ROOT . '/views/client/user/orders.php';
    }

    /**
     * Hiển thị chi tiết một đơn hàng.
     * Kiểm tra quyền sở hữu và yêu cầu đăng nhập.
     */
    public function orderDetail() {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$orderId) {
            header("Location: index.php?controller=user&action=orders");
            exit;
        }

        require_once ROOT . '/models/ChungTuBan.php';
        require_once ROOT . '/models/ChungTuBanCT.php';

        $orderModel = new ChungTuBan($this->db);
        $detailModel = new ChungTuBanCT($this->db);

        $order = $orderModel->getById($orderId);
        if (!$order || $order['ID_KHACHHANG'] != $userId) {
            header("Location: index.php?controller=user&action=orders");
            exit;
        }

        $items = $detailModel->getByChungTu($orderId);

        include ROOT . '/views/client/user/order_detail.php';
    }

    /**
     * Xử lý đăng xuất.
     * Hủy session và chuyển hướng về trang đăng nhập.
     */
    public function logout() {
        session_destroy();
        header("Location: index.php?controller=user&action=login");
        exit;
    }
}