<?php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/PhanLoai.php';
require_once ROOT . '/models/DonGiaBan.php';

// Thuật toán tìm kiếm, sắp xếp (chỉ dùng khi use_algo = 1)
require_once ROOT . '/utils/searching.php';
require_once ROOT . '/utils/sorting.php';

/**
 * Controller quản lý việc hiển thị sản phẩm phía client.
 *
 * Chịu trách nhiệm xử lý các logic phức tạp bao gồm:
 * - Lọc sản phẩm theo danh mục, tính năng (mới, khuyến mãi).
 * - Lọc theo khoảng giá.
 * - Sắp xếp theo giá.
 * - Tìm kiếm theo tên và mô tả.
 * - Phân trang kết quả.
 * - Hỗ trợ hai chế độ hoạt động: truy vấn CSDL (mặc định) và xử lý bằng thuật toán PHP.
 */
class ProductController
{

    private $db;
    private $productModel;  // Model HangHoa
    private $phanLoaiModel; // Model PhanLoai

    /**
     * Khởi tạo controller, nhận kết nối DB và nạp các model cần thiết.
     * @param PDO $db Đối tượng kết nối cơ sở dữ liệu.
     */
    public function __construct($db)
    {
        $this->db             = $db;
        $this->productModel   = new HangHoa($db);
        $this->phanLoaiModel  = new PhanLoai($db);
    }

    /**
     * Hiển thị danh sách sản phẩm với đầy đủ tính năng lọc, tìm kiếm, sắp xếp và phân trang.
     */
    public function list()
    {

        // 1. Lọc theo phân loại
        $id_phanloai = isset($_GET['id_phanloai']) ? (int)$_GET['id_phanloai'] : null;

        // 2. Lọc theo tính năng
        $feature = isset($_GET['feature']) ? $_GET['feature'] : null;
        $allowedFeatures = ['new', 'promo']; // 2 loại filter đang hỗ trợ

        if ($feature === '' || !in_array($feature, $allowedFeatures)) {
            $feature = null;
        }

        // 3. Xử lý tham số lọc và sắp xếp giá
        $priceParam = $_GET['price'] ?? null;

        // Khởi tạo các biến lọc giá
        $minPrice  = null;
        $maxPrice  = null;
        $sortPrice = null;

        if ($priceParam) {

            // Lọc theo khoảng giá: 100-300
            if (str_contains($priceParam, '-')) {

                $parts = explode('-', $priceParam);
                if (count($parts) == 2) {
                    $minPrice = (int)$parts[0];
                    $maxPrice = (int)$parts[1];
                }

                // Sắp xếp theo giá: price_asc / price_desc
            } elseif ($priceParam === 'price_asc' || $priceParam === 'price_desc') {
                $sortPrice = $priceParam;
            }
        }

        // 4. Tìm kiếm theo tên sản phẩm
        $q = isset($_GET['q']) ? trim($_GET['q']) : null;

        // 5. Lấy danh mục cho sidebar
        $phanloaiList = $this->phanLoaiModel->getAll();

        // 6. Thiết lập các chế độ hoạt động
        $limit   = 9;

        // Xác định xem có sử dụng chế độ thuật toán PHP hay không, dựa vào tham số trên URL.
        $useAlgo = isset($_GET['use_algo']) && $_GET['use_algo'] == '1';

        // ---
        // Luồng 1: Chế độ thuật toán (xử lý bằng PHP)
        // ---
        if ($useAlgo) {

            /*
             * Luồng xử lý bằng thuật toán PHP:
             * 1. Tải toàn bộ dữ liệu từ DB (bỏ qua phân trang của DB).
             * 2. Áp dụng tìm kiếm và sắp xếp bằng các hàm trong PHP.
             * 3. Thực hiện phân trang trên mảng kết quả bằng PHP.
             */
            $bigLimit = 1000000; // load toàn bộ

            $all = $this->productModel->getPagingClient(
                $bigLimit,
                0,
                $id_phanloai,
                $feature,
                $minPrice,
                $maxPrice,
                null,
                null // search chuối bỏ qua để tìm bằng PHP
            );

            // Áp dụng tìm kiếm tuần tự bằng PHP nếu có từ khóa
            if (!empty($q)) {
                $all = search_products($all, $q);
            }

            // Áp dụng sắp xếp lựa chọn (selection sort) bằng PHP nếu có yêu cầu
            if ($sortPrice === 'price_asc' || $sortPrice === 'price_desc') {
                $order = ($sortPrice === 'price_asc') ? 'asc' : 'desc';
                $all = selection_sort_by_price($all, $order);
            }

            // Thực hiện phân trang trên mảng dữ liệu đã được xử lý
            $totalItems  = count($all);
            $totalPages  = ($totalItems == 0) ? 1 : ceil($totalItems / $limit);

            $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
            $currentPage = min($currentPage, $totalPages); // Đảm bảo trang hiện tại hợp lệ

            $startIndex = ($currentPage - 1) * $limit;
            $products   = array_slice($all, $startIndex, $limit);

            // Tính toán các thông số cho thanh phân trang
            $maxPages  = 5;
            $startPage = max(1, $currentPage - floor($maxPages / 2));
            $endPage   = min($totalPages, $startPage + $maxPages - 1);

            if ($endPage - $startPage + 1 < $maxPages) {
                $startPage = max(1, $endPage - $maxPages + 1);
            }
        }
        // ---
        // Luồng 2: Chế độ mặc định (ủy thác cho Database)
        // ---
        else {

            /*
             * Luồng xử lý mặc định:
             * Ủy thác toàn bộ việc lọc, tìm kiếm, sắp xếp và phân trang cho CSDL.
             * Sử dụng hàm `paginate()` để điều phối.
             */
            require_once ROOT . '/utils/pagination.php';

            $page = paginate($this->productModel, [
                'limit'       => $limit,
                'pageParam'   => 'page',
                'maxPages'    => 5,
                'getMethod'   => 'getPagingClient',
                'countMethod' => 'countAllClient',

                // Tham số truyền vào Model
                'getArgs'   => [$id_phanloai, $feature, $minPrice, $maxPrice, $q, $sortPrice],
                'countArgs' => [$id_phanloai, $minPrice, $maxPrice, $q],
            ]);

            // Kết quả phân trang
            $products     = $page['items'];
            $totalPages   = $page['totalPages'];
            $currentPage  = $page['currentPage'];
            $startPage    = $page['startPage'];
            $endPage      = $page['endPage'];
        }

        // 8. Xây dựng chuỗi query để giữ lại bộ lọc khi phân trang
        $filter_param = '';
        if ($id_phanloai) $filter_param .= "&id_phanloai=$id_phanloai";
        if ($feature)     $filter_param .= "&feature=" . urlencode($feature);
        if ($priceParam)  $filter_param .= "&price=" . urlencode($priceParam);
        if ($q)           $filter_param .= "&q=" . urlencode($q);

        include ROOT . '/views/client/product/list.php';
    }

    /**
     * Hiển thị trang chi tiết của một sản phẩm.
     */
    public function detail()
    {
        $id      = $_GET['id'] ?? 0;
        $product = $this->productModel->getByIdClient($id);

        include ROOT . '/views/client/product/detail.php';
    }
}
