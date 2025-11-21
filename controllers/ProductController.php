<?php
require_once ROOT . '/models/HangHoa.php';
require_once ROOT . '/models/PhanLoai.php';
require_once ROOT . '/models/DonGiaBan.php';
// Optional algorithmic helpers (selection sort, binary search, search)
require_once ROOT . '/utils/searching.php';
require_once ROOT . '/utils/sorting.php';

/**
 * Lớp ProductController quản lý các chức năng liên quan đến sản phẩm phía client.
 */
class ProductController {
    private $db;
    private $productModel;
    private $phanLoaiModel;

    /**
     * Khởi tạo controller với kết nối cơ sở dữ liệu và các model liên quan.
     * @param object $db Kết nối cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new HangHoa($db);
        $this->phanLoaiModel = new PhanLoai($db);
    }

    /**
     * Hiển thị danh sách sản phẩm với lọc, sắp xếp và phân trang.
     */
    public function list() {
        // Lấy ID phân loại
        $id_phanloai = isset($_GET['id_phanloai']) ? (int)$_GET['id_phanloai'] : null;

        // Lọc theo tính năng
        $feature = isset($_GET['feature']) ? $_GET['feature'] : null;
        $allowedFeatures = ['new', 'promo'];
        if ($feature === '' || !in_array($feature, $allowedFeatures)) {
            $feature = null;
        }

        // Lọc và sắp xếp theo giá
        $priceParam = isset($_GET['price']) ? $_GET['price'] : null;
        $minPrice = $maxPrice = null;
        $sortPrice = null;

        if ($priceParam) {
            if (strpos($priceParam, '-') !== false) {
                // Lọc khoảng giá
                $parts = explode('-', $priceParam);
                if (count($parts) == 2) {
                    $minPrice = (int)$parts[0];
                    $maxPrice = (int)$parts[1];
                }
            } elseif ($priceParam === 'price_asc' || $priceParam === 'price_desc') {
                // Sắp xếp theo giá
                $sortPrice = $priceParam;
            }
        }

        // Tìm kiếm
        $q = isset($_GET['q']) ? trim($_GET['q']) : null;

        // Danh sách phân loại cho sidebar
        $phanloaiList = $this->phanLoaiModel->getAll();

        // Phân trang: support algorithm mode toggle via `use_algo=1`
        $limit = 9;
        $useAlgo = isset($_GET['use_algo']) && $_GET['use_algo'] == '1';

        // Timing info
        $algoSearchTimeMs = null;
        $algoSortTimeMs = null;
        $dbFetchTimeMs = null;

        if ($useAlgo) {
            // FETCH ALL (NO PAGINATION)
            $bigLimit = 1000000;

            $t0db = microtime(true);
            $all = $this->productModel->getPagingClient(
                $bigLimit,
                0,
                $id_phanloai,
                $feature,
                $minPrice,
                $maxPrice,
                null,
                null // Bỏ search, sẽ search trong PHP
            );
            $t1db = microtime(true);
            $dbFetchTimeMs = round(($t1db - $t0db) * 1000, 3);

            // PHP SEARCH
            if (!empty($q)) {
                $t0 = microtime(true);
                $all = search_products($all, $q);
                $t1 = microtime(true);
                $algoSearchTimeMs = round(($t1 - $t0) * 1000, 3);
            }

            // SELECTION SORT (KHÔNG LƯU FILE)
            if ($sortPrice === 'price_asc' || $sortPrice === 'price_desc') {
                $order = ($sortPrice === 'price_asc') ? 'asc' : 'desc';

                $t0s = microtime(true);
                $all = selection_sort_by_price($all, $order);
                $t1s = microtime(true);
                $algoSortTimeMs = round(($t1s - $t0s) * 1000, 3);
            }

            // PAGINATION thủ công
            $totalItems = count($all);
            $totalPages = ($totalItems === 0) ? 1 : (int)ceil($totalItems / $limit);
            $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
            if ($currentPage > $totalPages) $currentPage = $totalPages;

            $startIndex = ($currentPage - 1) * $limit;
            $products = array_slice($all, $startIndex, $limit);

            // Pagination window
            $maxPages = 5;
            $startPage = max(1, $currentPage - (int)floor($maxPages / 2));
            $endPage = min($totalPages, $startPage + $maxPages - 1);
            if ($endPage - $startPage + 1 < $maxPages) {
                $startPage = max(1, $endPage - $maxPages + 1);
            }

        } else {
            // DEFAULT: DB SIDE PAGINATION
            require_once ROOT . '/utils/pagination.php';

            $t0db = microtime(true);
            $pag = paginate($this->productModel, [
                'limit' => $limit,
                'pageParam' => 'page',
                'maxPages' => 5,
                'getMethod' => 'getPagingClient',
                'countMethod' => 'countAllClient',
                'getArgs' => [$id_phanloai, $feature, $minPrice, $maxPrice, $q, $sortPrice],
                'countArgs' => [$id_phanloai, $minPrice, $maxPrice, $q],
            ]);
            $t1db = microtime(true);
            $dbFetchTimeMs = round(($t1db - $t0db) * 1000, 3);

            $products = $pag['items'];
            $totalPages = $pag['totalPages'];
            $currentPage = $pag['currentPage'];
            $startPage = $pag['startPage'];
            $endPage = $pag['endPage'];
        }

        // DEBUG MODE
        $debugInfo = null;
        if (isset($_GET['debug']) && $_GET['debug'] == '1') {
            if ($sortPrice === 'price_asc') {
                $expectedOrder = 'd.GIATRI ASC';
            } elseif ($sortPrice === 'price_desc') {
                $expectedOrder = 'd.GIATRI DESC';
            } elseif ($feature === 'promo') {
                $expectedOrder = 'd.GIATRI ASC';
            } else {
                $expectedOrder = 'h.ID_HANGHOA DESC';
            }

            $debugInfo = [
                'GET' => $_GET,
                'useAlgo' => $useAlgo,
                'priceParam' => $priceParam,
                'sortPrice' => $sortPrice,
                'expectedOrder' => $expectedOrder,
                'totalItems_sample' => isset($totalItems) ? $totalItems : null,
                'dbFetchTimeMs' => $dbFetchTimeMs,
                'algoSearchTimeMs' => $algoSearchTimeMs,
                'algoSortTimeMs' => $algoSortTimeMs,
            ];

            $logPath = ROOT . '/upload/product_debug.log';
            $logEntry = "[" . date('Y-m-d H:i:s') . "] " .
                json_encode($debugInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) .
                "\n\n";

            @file_put_contents($logPath, $logEntry, FILE_APPEND | LOCK_EX);
        }

        // Giữ tham số lọc khi phân trang
        $filter_param = '';
        if ($id_phanloai) $filter_param .= "&id_phanloai=$id_phanloai";
        if ($feature) $filter_param .= "&feature=" . urlencode($feature);
        if ($priceParam) $filter_param .= "&price=" . urlencode($priceParam);
        if ($q) $filter_param .= "&q=" . urlencode($q);

        include ROOT . '/views/client/product/list.php';
    }

    /**
     * Hiển thị chi tiết một sản phẩm.
     */
    public function detail() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getByIdClient($id);
        include ROOT . '/views/client/product/detail.php';
    }
}