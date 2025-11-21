<?php
/**
 * Trợ giúp phân trang đơn giản.
 * Cách sử dụng:
 *   $result = paginate($model, [
 *       'limit' => 10,
 *       'pageParam' => 'page',
 *       'maxPages' => 5,
 *       'getMethod' => 'getPaging', // phương thức trên model để lấy các mục
 *       'countMethod' => 'countAll', // phương thức trên model để đếm tổng số
 *       'getArgs' => [], // các đối số bổ sung thêm sau limit/offset
 *       'offsetFirst' => false // true nếu model mong đợi (offset, limit)
 *   ]);
 * Trả về mảng với các khóa: items, totalItems, totalPages, currentPage, startPage, endPage, pages, limit, offset
 */
function paginate($model, $options = []) {
    // Thiết lập giới hạn số lượng mục trên mỗi trang, mặc định là 10 nếu không được chỉ định
    $limit = isset($options['limit']) ? (int)$options['limit'] : 10;
    // Thiết lập tên tham số trang trong URL (ví dụ: ?page=2), mặc định là 'page'
    $pageParam = $options['pageParam'] ?? 'page';
    // Số lượng trang tối đa hiển thị trong phân trang (ví dụ: hiển thị 5 trang xung quanh trang hiện tại)
    $maxPages = isset($options['maxPages']) ? (int)$options['maxPages'] : 5;
    // Phương thức trên model để lấy dữ liệu phân trang, mặc định 'getPaging'
    $getMethod = $options['getMethod'] ?? 'getPaging';
    // Phương thức trên model để đếm tổng số mục, mặc định 'countAll'
    $countMethod = $options['countMethod'] ?? 'countAll';
    // Các đối số bổ sung cho phương thức lấy dữ liệu
    $getArgs = $options['getArgs'] ?? [];
    // Các đối số bổ sung cho phương thức đếm (nếu có)
    $countArgs = $options['countArgs'] ?? [];
    // Xác định thứ tự đối số cho phương thức lấy dữ liệu: offset trước limit hay không
    $offsetFirst = !empty($options['offsetFirst']);

    // Lấy số trang hiện tại từ URL, mặc định là 1 nếu không có hoặc nhỏ hơn 1
    $page = isset($_GET[$pageParam]) ? (int)$_GET[$pageParam] : 1;
    if ($page < 1) $page = 1;
    // Tính toán offset (vị trí bắt đầu) dựa trên trang hiện tại và limit
    $offset = ($page - 1) * $limit;

    // Chuẩn bị đối số cho phương thức lấy dữ liệu
    if ($offsetFirst) {
        // Nếu offset trước limit, thêm offset, limit rồi các đối số khác
        $args = array_merge([$offset, $limit], $getArgs);
    } else {
        // Nếu limit trước offset, thêm limit, offset rồi các đối số khác
        $args = array_merge([$limit, $offset], $getArgs);
    }

    // Kiểm tra xem phương thức lấy dữ liệu có tồn tại trên model không
    if (!method_exists($model, $getMethod)) {
        throw new Exception("Phân trang: phương thức $getMethod không tồn tại trên model");
    }

    // Gọi phương thức lấy dữ liệu trên model với các đối số đã chuẩn bị
    $items = call_user_func_array([$model, $getMethod], $args);

    // Kiểm tra xem phương thức đếm tổng số có tồn tại trên model không
    if (!method_exists($model, $countMethod)) {
        throw new Exception("Phân trang: phương thức $countMethod không tồn tại trên model");
    }
    // Gọi phương thức đếm tổng số mục, hỗ trợ truyền đối số nếu có
    if (!empty($countArgs)) {
        $totalItems = (int) call_user_func_array([$model, $countMethod], $countArgs);
    } else {
        $totalItems = (int) $model->{$countMethod}();
    }
    // Tính tổng số trang dựa trên tổng mục và limit
    $totalPages = $limit > 0 ? (int) ceil($totalItems / $limit) : 1;

    // Thiết lập trang hiện tại
    $currentPage = $page;
    // Tính trang bắt đầu hiển thị trong phân trang (giữ ở giữa maxPages)
    $startPage = max(1, $currentPage - (int) floor($maxPages / 2));
    // Tính trang kết thúc hiển thị
    $endPage = min($totalPages, $startPage + $maxPages - 1);
    // Điều chỉnh startPage nếu khoảng cách nhỏ hơn maxPages
    if ($endPage - $startPage + 1 < $maxPages) {
        $startPage = max(1, $endPage - $maxPages + 1);
    }

    // Tạo mảng các trang để hiển thị
    $pages = [];
    for ($i = $startPage; $i <= $endPage; $i++) $pages[] = $i;

    // Trả về kết quả dưới dạng mảng
    return [
        'items' => $items,          // Danh sách mục trên trang hiện tại
        'totalItems' => $totalItems, // Tổng số mục
        'totalPages' => $totalPages, // Tổng số trang
        'currentPage' => $currentPage, // Trang hiện tại
        'startPage' => $startPage,  // Trang bắt đầu hiển thị
        'endPage' => $endPage,      // Trang kết thúc hiển thị
        'pages' => $pages,          // Mảng các trang hiển thị
        'limit' => $limit,          // Giới hạn mỗi trang
        'offset' => $offset,        // Offset hiện tại
    ];
}