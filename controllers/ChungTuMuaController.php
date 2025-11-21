<?php
require_once ROOT . '/models/ChungTuMua.php';
require_once ROOT . '/models/ChungTuMuaCT.php';
require_once ROOT . '/models/KhachHang.php';
require_once ROOT . '/models/HangHoa.php';

/**
 * Lớp ChungTuMuaController quản lý các chức năng liên quan đến chứng từ mua hàng.
 */
class ChungTuMuaController {
    private $model;
    private $ctctModel;
    private $khModel;
    private $hhModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->model = new ChungTuMua($db);
        $this->ctctModel = new ChungTuMuaCT($db);
        $this->khModel = new KhachHang($db);
        $this->hhModel = new HangHoa($db);
    }

    /**
     * Hiển thị danh sách chứng từ mua hàng với phân trang.
     */
    public function index() {
        require_once ROOT . '/utils/pagination.php';

        $pag = paginate($this->model, [
            'limit' => 10,
            'pageParam' => 'page',
            'maxPages' => 5,
            'getMethod' => 'getPaging',
            'countMethod' => 'countAll',
        ]);

        $data = $pag['items'];
        $totalPages = $pag['totalPages'];
        $currentPage = $pag['currentPage'];
        $startPage = $pag['startPage'];
        $endPage = $pag['endPage'];

        include ROOT . '/views/admin/chungtumua/list.php';
    }

    /**
     * Hiển thị chi tiết một chứng từ mua hàng.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $ctm = $this->model->getById($id);
        $ctmct = $this->ctctModel->getByCTMua($id);
        include ROOT . '/views/admin/chungtumua/detail.php';
    }

    /**
     * Tạo mới một chứng từ mua hàng.
     * Xử lý form POST để lưu dữ liệu, sau đó chuyển hướng.
     */
    public function create() {
        $kh = $this->khModel->getAll();
        $hh = $this->hhModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MASOCT' => $_POST['MASOCT'] ?? 'CTM-' . time(),
                'NGAYPHATSINH' => $_POST['NGAYPHATSINH'] ?? date('Y-m-d H:i:s'),
                'ID_KHACHHANG' => $_POST['ID_KHACHHANG'] ?? null,
                'TONGTIENHANG' => $_POST['TONGTIENHANG'] ?? 0,
                'THUE' => $_POST['THUE'] ?? 0
            ];

            $id = $this->model->create($data);
            header('Location: index.php?controller=chungtumua&action=index');
            exit;
        }

        include ROOT . '/views/admin/chungtumua/create.php';
    }

    /**
     * Sửa một chứng từ mua hàng hiện có.
     * Xử lý form POST để cập nhật dữ liệu, sau đó chuyển hướng.
     */
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $ctm = $this->model->getById($id);
        if (!$ctm) {
            header('Location: index.php?controller=chungtumua&action=index');
            exit;
        }

        // load related lists and detail items; ensure arrays to avoid view errors
        $kh = $this->khModel->getAll() ?: [];
        $hh = $this->hhModel->getAll() ?: [];
        $ctmct = $this->ctctModel->getByCTMua($id) ?: [];

        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MASOCT' => $_POST['MASOCT'] ?? $ctm['MASOCT'],
                'NGAYPHATSINH' => $_POST['NGAYPHATSINH'] ?? $ctm['NGAYPHATSINH'],
                'ID_KHACHHANG' => $_POST['ID_KHACHHANG'] ?? $ctm['ID_KHACHHANG'],
                'TONGTIENHANG' => $_POST['TONGTIENHANG'] ?? $ctm['TONGTIENHANG'],
                'THUE' => $_POST['THUE'] ?? $ctm['THUE']
            ];

            $this->model->update($id, $data);

            // If item arrays provided, replace details
            if (!empty($_POST['ID_HANGHOA']) && is_array($_POST['ID_HANGHOA'])) {
                $this->ctctModel->deleteByChungTu($id);
                foreach ($_POST['ID_HANGHOA'] as $i => $idHH) {
                    $soluong = $_POST['SOLUONG'][$i] ?? 0;
                    $dongia = $_POST['DONGIA'][$i] ?? ($_POST['GIABAN'][$i] ?? 0);
                    $this->ctctModel->create([
                        'ID_CTMUA' => $id,
                        'ID_HANGHOA' => $idHH,
                        'SOLUONG' => $soluong,
                        'DONGIA' => $dongia
                    ]);
                }
            }

            header('Location: index.php?controller=chungtumua&action=detail&id=' . $id);
            exit;
        }

        include ROOT . '/views/admin/chungtumua/edit.php';
    }

    /**
     * Xóa một chứng từ mua hàng.
     */
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->model->delete($id);
        header('Location: index.php?controller=chungtumua&action=index');
        exit;
    }
}