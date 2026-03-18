<?php

/**
 * Hàm phân trang dùng chung cho toàn bộ hệ thống.
 *
 * Hàm này thực hiện logic phân trang bằng cách tương tác với một đối tượng model
 * để lấy dữ liệu theo từng trang và tính toán các thông số cần thiết cho thanh điều hướng.
 *
 * @param object $model   Đối tượng model dữ liệu. Model này phải chứa các phương thức được
 *                        chỉ định trong `getMethod` và `countMethod`.
 * @param array  $options Mảng tùy chọn cấu hình cho việc phân trang:
 *                        - `limit`: Số lượng mục trên mỗi trang (mặc định: 10).
 *                        - `pageParam`: Tên tham số trên URL cho số trang (mặc định: 'page').
 *                        - `maxPages`: Số lượng trang tối đa hiển thị trên thanh điều hướng (mặc định: 5).
 *                        - `getMethod`: Tên phương thức trong model để lấy dữ liệu (mặc định: 'getPaging').
 *                        - `countMethod`: Tên phương thức trong model để đếm tổng số mục (mặc định: 'countAll').
 *                        - `getArgs`: Mảng các tham số bổ sung để truyền vào `getMethod`.
 *                        - `countArgs`: Mảng các tham số bổ sung để truyền vào `countMethod`.
 *                        - `offsetFirst`: Cờ xác định thứ tự tham số cho `getMethod`. `true` nếu là `(offset, limit)`, `false` nếu là `(limit, offset)`.
 *
 * @return array Mảng kết quả chứa dữ liệu trang và các thông tin phân trang.
 * @throws Exception Nếu các phương thức `getMethod` hoặc `countMethod` không tồn tại trong model.
 */
function paginate($model, $options = [])
{
    // 1. Khởi tạo và đọc các tham số cấu hình từ mảng options.
    // Thiết lập các giá trị mặc định nếu chúng không được cung cấp.
    $limit       = $options['limit']      ?? 10;
    $pageParam   = $options['pageParam']  ?? 'page';
    $maxPages    = $options['maxPages']   ?? 5;
    $getMethod   = $options['getMethod']  ?? 'getPaging';
    $countMethod = $options['countMethod'] ?? 'countAll';
    $getArgs     = $options['getArgs']    ?? [];
    $countArgs   = $options['countArgs']  ?? [];
    $offsetFirst = !empty($options['offsetFirst']);

    // Lấy số trang hiện tại từ URL, đảm bảo giá trị luôn lớn hơn hoặc bằng 1.
    $page = isset($_GET[$pageParam]) ? (int)$_GET[$pageParam] : 1;
    if ($page < 1) $page = 1;

    // Tính toán vị trí bắt đầu (offset) để lấy dữ liệu từ database.
    $offset = ($page - 1) * $limit;


    // 2. Chuẩn bị và thực thi lời gọi đến phương thức lấy dữ liệu của model.
    // Xác định thứ tự của limit và offset dựa trên cờ $offsetFirst.
    $args = $offsetFirst
        ? array_merge([$offset, $limit], $getArgs)
        : array_merge([$limit, $offset], $getArgs);

    // Kiểm tra sự tồn tại của phương thức trước khi gọi để tránh lỗi nghiêm trọng.
    if (!method_exists($model, $getMethod)) {
        throw new Exception("paginate(): không tìm thấy phương thức $getMethod trên model");
    }

    // Sử dụng call_user_func_array để gọi động phương thức của model với một mảng tham số.
    $items = call_user_func_array([$model, $getMethod], $args);


    // 3. Đếm tổng số bản ghi để tính toán tổng số trang.
    if (!method_exists($model, $countMethod)) {
        throw new Exception("paginate(): không tìm thấy phương thức $countMethod trên model");
    }

    // Gọi phương thức đếm của model, có hoặc không có tham số bổ sung.
    $totalItems = !empty($countArgs)
        ? call_user_func_array([$model, $countMethod], $countArgs)
        : $model->$countMethod();

    $totalItems = (int)$totalItems;
    $totalPages = ($limit > 0 && $totalItems > 0) ? (int)ceil($totalItems / $limit) : 1;


    // 4. Tính toán các thông số cho thanh điều hướng phân trang (pagination bar).
    $currentPage = $page;

    // Tính toán trang bắt đầu của "cửa sổ" trang hiển thị.
    $startPage = max(1, $currentPage - floor($maxPages / 2));

    // Tính toán trang kết thúc của "cửa sổ".
    $endPage = min($totalPages, $startPage + $maxPages - 1);

    // Điều chỉnh lại trang bắt đầu nếu "cửa sổ" không đủ số trang tối đa (thường xảy ra ở cuối danh sách).
    if ($endPage - $startPage + 1 < $maxPages) {
        $startPage = max(1, $endPage - $maxPages + 1);
    }

    /** Mảng các số trang */
    $pages = range($startPage, $endPage);

    // 5. Trả về một mảng kết quả đầy đủ để view có thể sử dụng.
    return [
        'items'       => $items,
        'totalItems'  => $totalItems,
        'totalPages'  => $totalPages,
        'currentPage' => $currentPage,
        'startPage'   => $startPage,
        'endPage'     => $endPage,
        'pages'       => $pages,
        'limit'       => $limit,
        'offset'      => $offset,
    ];
}
