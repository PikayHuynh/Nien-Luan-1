<?php
require_once ROOT . '/models/KhachHang.php';

class UserController {
    private $khModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->khModel = new KhachHang($db);
    }

    // Trang login
    public function login() {
        // session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenKH = $_POST['TEN_KH'] ?? '';
            $matkhau = $_POST['MATKHAU'] ?? '';

            $user = $this->khModel->getByName($tenKH);
            if ($user) {
                // Kiểm tra password
                if ($user['PASSWORD'] === $matkhau) { // so sánh trực tiếp vì bạn không hash
                    $_SESSION['user_id'] = $user['ID_KHACH_HANG'];
                    $_SESSION['user_name'] = $user['TEN_KH'];

                    // Phân quyền
                    if ($this->khModel->isAdmin($user['ID_KHACH_HANG'])) {
                        header("Location: index.php?controller=dashboard&action=index"); // admin
                    } else {
                        header("Location: index.php?controller=home&action=index"); // client
                    }
                    exit;
                } else {
                    $error = "Sai mật khẩu!";
                }
            } else {
                $error = "User không tồn tại!";
            }
        }

        include ROOT . '/views/client/user/login.php';
    }

    // Trang register
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Kiểm tra confirm password
            if ($password !== $confirm_password) {
                $error = "Mật khẩu không khớp!";
            } else {
                // Kiểm tra user đã tồn tại chưa
                if ($this->khModel->getByName($username)) {
                    $error = "Username đã tồn tại!";
                } else {
                    // Tạo user mới
                    $this->khModel->create([
                        'TEN_KH' => $username,
                        'PASSWORD' => $password,
                        'DIACHI' => '',
                        'SODIENTHOAI' => '',
                        'HINHANH' => null,
                        'SOB' => 'user'  // đặt mặc định quyền là user
                    ]);
                    // Redirect về login
                    header("Location: index.php?controller=user&action=login");
                    exit;
                }
            }
        }

        include ROOT . '/views/client/user/register.php';
    }

    // Trang profile
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
            $diadi = $_POST['DIACHI'] ?? '';
            $sdt = $_POST['SODIENTHOAI'] ?? '';

            // handle optional avatar upload
            $hinhanh = $user['HINHANH'] ?? null;
            if (!empty($_FILES['HINHANH']['name'])) {
                $targetDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
                $ts = (int) round(microtime(true) * 1000);
                $original = basename($_FILES['HINHANH']['name']);
                $hinhanh = $ts . '_' . $original;
                move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $hinhanh);
            }

            // Use update() to allow updating HINHANH and preserve SOB
            $updateData = [
                'TEN_KH' => $username,
                'DIACHI' => $diadi,
                'SODIENTHOAI' => $sdt,
                'HINHANH' => $hinhanh,
                'SOB' => $user['SOB'] ?? 'user'
            ];

            if ($this->khModel->update($userId, $updateData)) {
                $success = "Cập nhật thông tin thành công!";
                // Cập nhật session tên user mới
                $_SESSION['user_name'] = $username;
                $user = $this->khModel->getById($userId); // refresh thông tin
            } else {
                $error = "Cập nhật thất bại!";
            }
        }

        include ROOT . '/views/client/user/edit_profile.php';
    }

    // Trang orders
    public function orders() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        // Load user's orders
        require_once ROOT . '/models/ChungTuBan.php';
        $orderModel = new ChungTuBan($this->db);
        $orders = $orderModel->getByUserId($userId);

        include ROOT . '/views/client/user/orders.php';
    }

    // Show order detail
    public function orderDetail() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
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
        if (!$order) {
            header("Location: index.php?controller=user&action=orders");
            exit;
        }

        // Ensure the order belongs to the logged-in user
        $ownerId = $order['ID_KHACHHANG'] ?? null;
        if ($ownerId != $userId) {
            // unauthorized
            header("Location: index.php?controller=user&action=orders");
            exit;
        }

        $items = $detailModel->getByChungTu($orderId);

        include ROOT . '/views/client/user/order_detail.php';
    }

    // Logout
    public function logout() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_destroy();
        header("Location: index.php?controller=user&action=login");
        exit;
    }
}
