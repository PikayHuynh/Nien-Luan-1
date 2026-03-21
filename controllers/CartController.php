<?php
require_once ROOT . '/config/Database.php';
require_once ROOT . '/models/HangHoa.php';

/**
 * Controller quản lý toàn bộ chức năng giỏ hàng.
 * Chịu trách nhiệm xử lý các thao tác: thêm, xóa, cập nhật, hiển thị
 * và thanh toán giỏ hàng.
 */
class CartController
{
    private $db;
    private $hangHoaModel;

    /**
     * Khởi tạo CartController.
     *
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->hangHoaModel = new HangHoa($db);

        // Khởi tạo session nếu chưa tồn tại để đảm bảo an toàn
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Đảm bảo rằng giỏ hàng luôn là một mảng trong session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Hiển thị trang giỏ hàng.
     * Tính toán lại tổng giá trị và truyền dữ liệu giỏ hàng sang view.
     */
    public function index()
    {
        $total = $this->recalcCart();     // Tính lại tổng giỏ hàng
        $cart = $_SESSION['cart'];       // Lấy dữ liệu giỏ hàng
        include ROOT . '/views/client/cart/index.php';
    }

    /**
     * Xử lý quá trình thanh toán đơn hàng.
     * - Yêu cầu người dùng phải đăng nhập.
     * - Kiểm tra giỏ hàng không được rỗng.
     * - Sử dụng transaction để đảm bảo toàn vẹn dữ liệu (tạo đơn hàng và chi tiết đơn hàng).
     * - Phân biệt vai trò Admin và User thường để tạo loại chứng từ phù hợp.
     * - Xóa giỏ hàng sau khi thanh toán thành công.
     */
    public function checkout()
    {
        // Bắt đầu một transaction để đảm bảo tất cả các thao tác ghi vào DB
        // hoặc thành công hoàn toàn, hoặc thất bại hoàn toàn.
        $this->db->beginTransaction();

        // Lấy ID khách hàng từ session (hỗ trợ 2 cách lưu của bạn)
        $id_khachhang = $_SESSION['user_id'] ?? ($_SESSION['user']['ID_KHACH_HANG'] ?? null);

        // Chưa login → chuyển về trang login
        if (!$id_khachhang) {
            header("Location: index.php?controller=user&action=login");
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];

        // Giỏ hàng rỗng → quay về trang giỏ hàng
        if (empty($cart)) {
            header("Location: index.php?controller=cart&action=index");
            exit;
        }

        // Tính tổng tiền giỏ hàng
        $tongtien = $_SESSION['cart_total'] ?? $this->recalcCart();
        $ngaydathang = date('Y-m-d H:i:s');

        require_once ROOT . '/models/KhachHang.php';
        require_once ROOT . '/models/Kho.php';
        $khModel = new KhachHang($this->db);
        $khoModel = new Kho($this->db);
        $isAdmin = $khModel->isAdmin($id_khachhang);

        /**
         * Phân luồng xử lý dựa trên vai trò người dùng.
         * Nếu là Admin, hệ thống sẽ tạo một "Chứng từ Mua".
         * Nếu là User thường, hệ thống sẽ tạo một "Chứng từ Bán".
         */
        if ($isAdmin) { // Luồng xử lý cho Admin
            require_once ROOT . '/models/ChungTuMua.php';
            require_once ROOT . '/models/ChungTuMuaCT.php';

            $orderModel = new ChungTuMua($this->db);
            $orderDetailModel = new ChungTuMuaCT($this->db);

            $masoct = 'CTM-' . time(); // Mã số chứng từ duy nhất

            // Tạo chứng từ mua
            $orderId = $orderModel->create([
                'MASOCT' => $masoct,
                'NGAYPHATSINH' => $ngaydathang,
                'ID_KHACHHANG' => $id_khachhang,
                'TONGTIENHANG' => $tongtien,
                'THUE' => 10,
                'TRANGTHAI' => 'Đang xử lý'
            ]);

            // Thêm chi tiết từng sản phẩm
            foreach ($cart as $item) {
                // Kiểm tra tồn kho (tùy chọn cho Admin nếu muốn, nhưng thường Admin nhập hàng nên SOLUONG tăng)
                $orderDetailModel->create([
                    'ID_CTMUA' => $orderId,
                    'ID_HANGHOA' => $item['id'],
                    'GIAMUA' => (float) $item['price'],
                    'SOLUONG' => (int) $item['quantity']
                ]);
                $this->hangHoaModel->updateQuantity($item['id'], (int) $item['quantity']);
                $khoModel->create($item['id'], $orderId, null, (int) $item['quantity'], 'MUA');
            }
        } else { // Luồng xử lý cho User thường
            require_once ROOT . '/models/ChungTuBan.php';
            require_once ROOT . '/models/ChungTuBanCT.php';

            $orderModel = new ChungTuBan($this->db);
            $orderDetailModel = new ChungTuBanCT($this->db);

            $masoct = 'CTB-' . time();

            // Kiểm tra VIP để giảm giá
            $isVip = $khModel->checkVip($id_khachhang);
            $finalTotal = $tongtien;
            $note = '';

            if ($isVip) {
                $finalTotal = $tongtien * 0.8; // Giảm 20%
                $note = "Khách hàng VIP: Đã giảm 20% trên tổng hóa đơn.";
            }

            // Tạo chứng từ bán
            $orderId = $orderModel->create([
                'MASOCT' => $masoct,
                'NGAYDATHANG' => $ngaydathang,
                'ID_KHACHHANG' => $id_khachhang,
                'TONGTIENHANG' => $finalTotal,
                'THUE' => 10,
                'TRANGTHAI' => 'Đang xử lý',
                'GHICHU' => $note
            ]);

            // Kiểm tra tồn kho cho tất cả sản phẩm trước khi thực hiện trừ
            foreach ($cart as $item) {
                $p = $this->hangHoaModel->getById($item['id']);
                if (!$p || $p['SOLUONG'] < $item['quantity']) {
                    $this->db->rollBack();
                    $_SESSION['error'] = "Sản phẩm '" . ($item['name'] ?? $item['id']) . "' không đủ hàng trong kho (Hiện có: " . ($p['SOLUONG'] ?? 0) . ")";
                    header("Location: index.php?controller=cart&action=index");
                    exit;
                }
            }

            // Thêm chi tiết sản phẩm
            foreach ($cart as $item) {
                $orderDetailModel->create([
                    'ID_CTBAN' => $orderId,
                    'ID_HANGHOA' => $item['id'],
                    'GIABAN' => (float) $item['price'],
                    'SOLUONG' => (int) $item['quantity']
                ]);
                $this->hangHoaModel->updateQuantity($item['id'], -(int) $item['quantity']);
                $khoModel->create($item['id'], null, $orderId, (int) $item['quantity'], 'BAN');

                // Cảnh báo tồn kho thấp (< 5 cái)
                $pUpdated = $this->hangHoaModel->getById($item['id']);
                if ($pUpdated && $pUpdated['SOLUONG'] < 5) {
                    $tb->create([
                        'NOIDUNG' => "⚠️ Cảnh báo tồn kho: Sản phẩm **" . $pUpdated['TEN_HANGHOA'] . "** chỉ còn **" . $pUpdated['SOLUONG'] . "** cái. Hãy cân nhắc nhập thêm hàng nhé! 📦",
                        'LOAI' => 'admin'
                    ]);
                }
            }
        }

        // Tạo thông báo cho Admin
        require_once ROOT . '/models/ThongBao.php';
        $tb = new ThongBao($this->db);
        
        $msg = $isAdmin 
            ? "📦 Nhập hàng thành công! Chứng từ nhập **$masoct** đã được tạo." 
            : "🛒 Đơn hàng mới: **$masoct** vừa được khách hàng đặt thành công.";

        $tb->create([
            'NOIDUNG' => $msg,
            'LOAI' => 'admin'
        ]);

        // Nếu mọi thứ thành công, xác nhận transaction
        $this->db->commit();

        // Xoá giỏ hàng sau khi thanh toán
        unset($_SESSION['cart'], $_SESSION['cart_total']);

        header('Location: index.php?controller=user&action=orders');
        exit;
    }

    /**
     * Thêm một sản phẩm vào giỏ hàng thông qua ID.
     * - Nếu sản phẩm đã tồn tại trong giỏ, tăng số lượng lên 1.
     * - Nếu chưa, lấy thông tin sản phẩm từ DB và thêm mới vào giỏ.
     * - Chuyển hướng người dùng về trang giỏ hàng.
     */
    public function add()
    {
        if (!isset($_GET['id']))
            die("Không có ID sản phẩm");

        $id = (int) $_GET['id'];

        // Nếu sản phẩm đã có trong giỏ → tăng số lượng
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            // Lấy thông tin sản phẩm (ưu tiên phương thức client)
            $product = method_exists($this->hangHoaModel, 'getByIdClient')
                ? $this->hangHoaModel->getByIdClient($id)
                : $this->hangHoaModel->getById($id);

            if (!$product)
                die("Sản phẩm không tồn tại");

            // Lưu vào giỏ hàng
            $_SESSION['cart'][$id] = [
                'id' => $product['ID_HANGHOA'],
                'name' => $product['TENHANGHOA'],
                'price' => $product['DONGIA'] ?? 0,
                'image' => $product['HINHANH'] ?? '',
                'quantity' => 1
            ];
        }

        // Cập nhật tổng tiền
        $this->recalcCart();

        header("Location: index.php?controller=cart&action=index");
        exit;
    }

    /**
     * Tính toán lại tổng giá trị của giỏ hàng.
     * Phương thức này duyệt qua tất cả sản phẩm trong giỏ, tính tổng phụ (subtotal)
     * và cập nhật tổng cuối cùng vào session.
     *
     * @return float Tổng giá trị của giỏ hàng.
     */
    private function recalcCart()
    {
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
            $_SESSION['cart_total'] = 0;
            return 0;
        }

        $total = 0;

        foreach ($_SESSION['cart'] as &$item) {
            $price = (float) ($item['price'] ?? 0);
            $qty = (int) ($item['quantity'] ?? 0);

            if ($qty < 0)
                $qty = 0; // Đảm bảo số lượng không âm

            $item['price'] = $price;
            $item['quantity'] = $qty;
            $item['subtotal'] = $price * $qty;

            $total += $item['subtotal'];
        }

        unset($item); // Hủy tham chiếu đến phần tử cuối cùng của vòng lặp

        $_SESSION['cart_total'] = $total;
        return $total;
    }

    /**
     * Xoá sản phẩm khỏi giỏ hàng theo ID.
     * Sau khi xóa, tính toán lại tổng giỏ hàng.
     */
    public function remove()
    {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=cart&action=index");
            exit;
        }

        $id = (int) $_GET['id'];

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $this->recalcCart();
        }

        header("Location: index.php?controller=cart&action=index");
        exit;
    }

    /**
     * Cập nhật số lượng của một sản phẩm trong giỏ hàng.
     * Dữ liệu được gửi qua phương thức POST.
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=cart&action=index");
            exit;
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $qty = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

        if ($id && isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, $qty); // Đảm bảo số lượng tối thiểu là 1
            $this->recalcCart();
        }

        header("Location: index.php?controller=cart&action=index");
        exit;
    }
}
