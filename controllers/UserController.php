<?php
require_once ROOT . '/models/KhachHang.php';

/**
 * Controller quản lý các hoạt động của người dùng.
 * Bao gồm: đăng nhập, đăng ký, xem/sửa hồ sơ, lịch sử đơn hàng và đăng xuất.
 */
class UserController
{
    private $khModel;
    private $db;

    /**
     * Khởi tạo controller và nạp model KhachHang.
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->khModel = new KhachHang($db);
    }

    /**
     * Xử lý yêu cầu đăng nhập của người dùng.
     * - POST: Xác thực thông tin đăng nhập, tạo session và chuyển hướng dựa trên vai trò.
     * - GET: Hiển thị form đăng nhập.
     */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $tenKH = $_POST['TEN_KH'] ?? '';
            $matkhau = $_POST['MATKHAU'] ?? '';

            // Lấy thông tin người dùng từ database
            $user = $this->khModel->getByName($tenKH);

            if ($user && $user['PASSWORD'] === $matkhau) {

                // Tạo session để duy trì trạng thái đăng nhập
                $_SESSION['user_id'] = $user['ID_KHACH_HANG'];
                $_SESSION['user_name'] = $user['TEN_KH'];

                // Chuyển hướng dựa trên vai trò: admin về dashboard, user về trang chủ
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
     * Xử lý yêu cầu đăng ký tài khoản mới.
     * - POST: Xác thực dữ liệu, kiểm tra username và tạo tài khoản.
     * - GET: Hiển thị form đăng ký.
     *
     * @note Về bảo mật: Mật khẩu nên được băm (hash) trước khi lưu vào CSDL.
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Mật khẩu không khớp!";
            } elseif ($this->khModel->getByName($username)) {
                $error = "Username đã tồn tại!";
            } else {
                // Tạo tài khoản mới với vai trò mặc định là 'user'
                $this->khModel->create([
                    'TEN_KH' => $username,
                    'PASSWORD' => $password,
                    'DIACHI' => '',
                    'SODIENTHOAI' => '',
                    'HINHANH' => null,
                    'SOB' => 'user'
                ]);

                // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
                header("Location: index.php?controller=user&action=login");
                exit;
            }
        }

        include ROOT . '/views/client/user/register.php';
    }

    /**
     * Hiển thị trang hồ sơ của người dùng đang đăng nhập.
     * Yêu cầu người dùng phải đăng nhập.
     */
    public function profile()
    {

        $userId = $_SESSION['user_id'] ?? null;
        // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $user = $this->khModel->getById($userId);
        $isAdmin = $this->khModel->isAdmin($userId);
        $isVip = $this->khModel->checkVip($userId);

        include ROOT . '/views/client/user/profile.php';
    }

    /**
     * Xử lý việc chỉnh sửa hồ sơ người dùng.
     * - GET: Hiển thị form chỉnh sửa với thông tin hiện tại.
     * - POST: Cập nhật thông tin và xử lý upload ảnh đại diện.
     */
    public function editProfile()
    {

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

            // Xử lý upload hình ảnh mới, nếu không có thì giữ lại hình cũ
            $hinhanh = $this->_handleImageUpload($user['HINHANH'] ?? null);

            // Chuẩn bị dữ liệu để cập nhật
            $updateData = [
                'TEN_KH' => $username,
                'DIACHI' => $diachi,
                'SODIENTHOAI' => $sdt,
                'HINHANH' => $hinhanh,
                'SOB' => $user['SOB'] ?? 'user'
            ];

            // Gọi model để cập nhật
            if ($this->khModel->update($userId, $updateData)) {

                $success = "Cập nhật thông tin thành công!";

                // Cập nhật lại tên trong session nếu có thay đổi
                $_SESSION['user_name'] = $username;

                // Tải lại thông tin người dùng để hiển thị trên form
                $user = $this->khModel->getById($userId);
            } else {
                $error = "Cập nhật thất bại!";
            }
        }

        include ROOT . '/views/client/user/edit_profile.php';
    }

    /**
     * Hiển thị lịch sử đơn hàng.
     * - Nếu là người dùng thường, hiển thị danh sách "Chứng từ Bán" (đơn hàng đã mua).
     * - Nếu là admin, hiển thị danh sách "Chứng từ Mua" (đơn hàng đã nhập).
     */
    public function orders()
    {

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $isAdmin = $this->khModel->isAdmin($userId);

        if ($isAdmin) {
            // Luồng xử lý cho Admin: Lấy các chứng từ mua do chính admin tạo
            require_once ROOT . '/models/ChungTuMua.php';
            $orderModel = new ChungTuMua($this->db);
            $orders = $orderModel->getByCustomerId($userId);
            $isPurchase = true; // Cờ để view biết đây là Chứng từ Mua
        } else {
            // Luồng xử lý cho người dùng thường: Lấy các chứng từ bán
            require_once ROOT . '/models/ChungTuBan.php';
            $orderModel = new ChungTuBan($this->db);
            $orders = $orderModel->getByUserId($userId);
            $isPurchase = false; // Đây là Chứng Từ Bán
        }

        // Truyền $isPurchase vào view để biết loại chứng từ và xây dựng link chi tiết đúng
        include ROOT . '/views/client/user/orders.php';
    }

    /**
     * Hiển thị chi tiết một đơn hàng (Chứng từ Mua hoặc Bán).
     * Thực hiện kiểm tra quyền sở hữu để đảm bảo người dùng chỉ xem được đơn hàng của mình.
     */
    public function orderDetail()
    {

        $userId = $_SESSION['user_id'] ?? null;
        $isAdmin = $this->khModel->isAdmin($userId); // Lấy trạng thái Admin

        if (!$userId) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        // Lấy ID và loại chứng từ từ URL
        $orderId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $type = isset($_GET['type']) ? $_GET['type'] : ''; // Lấy tham số type ('mua' hoặc 'ban')

        if (!$orderId || ($type !== 'mua' && $type !== 'ban')) {
            header("Location: index.php?controller=user&action=orders");
            exit;
        }

        $order = null;
        $items = [];
        $isPurchase = ($type === 'mua');

        // 1. Tải Model tương ứng dựa trên loại chứng từ
        if ($isPurchase) {
            // CHỨNG TỪ MUA (Thường dành cho Admin xem nhập hàng)
            require_once ROOT . '/models/ChungTuMua.php';
            require_once ROOT . '/models/ChungTuMuaCT.php';
            $orderModel = new ChungTuMua($this->db);
            $detailModel = new ChungTuMuaCT($this->db);
        } else {
            // CHỨNG TỪ BÁN (Đơn hàng của User)
            require_once ROOT . '/models/ChungTuBan.php';
            require_once ROOT . '/models/ChungTuBanCT.php';
            $orderModel = new ChungTuBan($this->db);
            $detailModel = new ChungTuBanCT($this->db);
        }

        // Lấy thông tin chứng từ
        $order = $orderModel->getById($orderId);

        // 2. Kiểm tra quyền truy cập
        // 2.1. Nếu chứng từ không tồn tại, chuyển hướng về danh sách
        if (!$order) {
            header("Location: index.php?controller=user&action=orders");
            exit;
        }

        // 2.2. Kiểm tra quyền sở hữu (Security Check)
        if ($isPurchase) {
            // Nếu là Chứng từ Mua, chỉ cho phép truy cập nếu là Admin
            // hoặc nếu người dùng hiện tại chính là người tạo chứng từ đó.
            if (!$isAdmin && $order['ID_KHACHHANG'] != $userId) {
                header("Location: index.php?controller=user&action=orders");
                exit;
            }
        } else {
            // Nếu là Chứng từ Bán (đơn hàng của người dùng),
            // bắt buộc ID_KHACHHANG phải khớp với người dùng đang đăng nhập.
            // Đây là bước bảo mật quan trọng để người dùng không xem được đơn hàng của nhau.
            if ($order['ID_KHACHHANG'] != $userId) {
                header("Location: index.php?controller=user&action=orders");
                exit;
            }
        }

        // 3. Lấy các dòng chi tiết của chứng từ
        $items = $detailModel->getByChungTu($orderId);

        include ROOT . '/views/client/user/order_detail.php';
    }

    /**
     * Xử lý việc tải lên hình ảnh đại diện.
     *
     * @param string|null $currentImage Tên tệp hình ảnh hiện tại.
     * @return string|null Tên tệp hình ảnh mới hoặc tên tệp hiện tại.
     */
    private function _handleImageUpload($currentImage = null)
    {
        if (isset($_FILES['HINHANH']) && $_FILES['HINHANH']['error'] === UPLOAD_ERR_OK) {
            $targetDir = ROOT . '/upload/';

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $timestamp = (int) round(microtime(true) * 1000);
            $newFileName = $timestamp . '_' . basename($_FILES['HINHANH']['name']);

            if (move_uploaded_file($_FILES['HINHANH']['tmp_name'], $targetDir . $newFileName)) {
                return $newFileName;
            }
        }
        return $currentImage;
    }

    /**
     * Xử lý yêu cầu đăng xuất.
     * Hủy toàn bộ session và chuyển hướng người dùng về trang đăng nhập.
     */
    public function logout()
    {
        session_destroy();
        header("Location: index.php?controller=user&action=login");
        exit;
    }
}
