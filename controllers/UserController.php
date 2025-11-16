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

            if ($this->khModel->updateProfile($userId, [
                'TEN_KH' => $username,
                'DIACHI' => $diadi,
                'SODIENTHOAI' => $sdt
            ])) {
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
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        // TODO: Lấy đơn hàng từ CHUNG_TU_BAN dựa theo $userId
        // $orders = $this->orderModel->getByUserId($userId);

        include ROOT . '/views/client/user/orders.php';
    }

    // Logout
    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?controller=user&action=login");
        exit;
    }
}
