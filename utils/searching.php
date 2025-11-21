<?php
// ======================================================================
//  SEARCHING UTIL — Hỗ trợ tìm kiếm & tìm kiếm nhị phân cho sản phẩm
// ======================================================================


// ======================================================================
// 1) TÌM KIẾM TUẦN TỰ THEO CHUỖI — search_products()
// ======================================================================

if (!function_exists('search_products')) {

    /**
     * Tìm kiếm sản phẩm theo chuỗi nhập vào.
     *
     * - Tìm theo: TENHANGHOA, TENPHANLOAI, MOTA (nếu có).
     * - Không phân biệt hoa/thường.
     * - Nếu chuỗi rỗng → trả về toàn bộ danh sách.
     *
     * @param array       $products  Mảng sản phẩm (mỗi phần tử là 1 associative array)
     * @param string|null $q         Từ khóa tìm kiếm
     * @return array                  Danh sách sản phẩm đã lọc (reset index)
     */
    function search_products(array $products, ?string $q): array
    {
        // Không có từ khóa → trả về nguyên bản
        if ($q === null) {
            return $products;
        }

        // Loại bỏ khoảng trắng đầu/cuối
        $q = trim($q);
        if ($q === '') {
            return $products;
        }

        // Chuyển về dạng thường để tìm kiếm không phân biệt hoa/thường
        $qLower = mb_strtolower($q);
        $out = [];

        // Duyệt từng sản phẩm
        foreach ($products as $p) {

            // Gom các trường được tìm vào một chuỗi (nếu tồn tại)
            $haystack = '';
            if (isset($p['TENHANGHOA'])) {
                $haystack .= ' ' . $p['TENHANGHOA'];
            }
            if (isset($p['TENPHANLOAI'])) {
                $haystack .= ' ' . $p['TENPHANLOAI'];
            }
            if (isset($p['MOTA'])) {
                $haystack .= ' ' . $p['MOTA'];
            }

            // Nếu sản phẩm không có trường nào → bỏ qua
            if ($haystack === '') {
                continue;
            }

            // Kiểm tra xuất hiện chuỗi tìm kiếm (không phân biệt hoa/thường)
            if (mb_stripos(mb_strtolower($haystack), $qLower) !== false) {
                $out[] = $p;
            }
        }

        return array_values($out); // reset index
    }
}



// ======================================================================
// 2) BINARY SEARCH THEO FIELD CHUỖI — binary_search_products_by_field()
// ======================================================================

if (!function_exists('binary_search_products_by_field')) {

    /**
     * Tìm kiếm nhị phân theo trường dữ liệu chuỗi.
     *
     * ❗ Lưu ý:
     * - Mảng **bắt buộc đã được sắp xếp** theo đúng trường `$field`
     *   và theo đúng kiểu so sánh giống trong hàm này.
     *
     * @param array  $products   Mảng sản phẩm đã sắp xếp
     * @param string $field      Tên trường dùng để so sánh (vd: TENHANGHOA)
     * @param string $target     Giá trị cần tìm
     * @param bool   $caseInsensitive  true = không phân biệt hoa/thường
     *
     * @return array|null        Trả về 1 sản phẩm hoặc null nếu không có
     */
    function binary_search_products_by_field(array $products, string $field, string $target, bool $caseInsensitive = true): ?array
    {
        $low = 0;
        $high = count($products) - 1;

        // Chuẩn hóa target theo kiểu so sánh
        $targetKey = $caseInsensitive ? mb_strtolower($target) : $target;

        while ($low <= $high) {
            $mid = intdiv($low + $high, 2);

            // Lấy giá trị tại vị trí giữa
            $val = $products[$mid][$field] ?? '';
            $cmpVal = $caseInsensitive ? mb_strtolower((string)$val) : (string)$val;

            // Trùng khớp → trả về
            if ($cmpVal === $targetKey) {
                return $products[$mid];
            }

            // So sánh chuỗi theo thứ tự từ điển
            if ($cmpVal < $targetKey) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }

        // Không tìm thấy
        return null;
    }
}



// ======================================================================
// 3) BINARY SEARCH SỐ — binary_search_products_by_numeric_field()
// ======================================================================

if (!function_exists('binary_search_products_by_numeric_field')) {

    /**
     * Tìm kiếm nhị phân theo trường dữ liệu số (vd: GIATRI, DONGIA).
     *
     * ❗ Lưu ý:
     * - Mảng **phải được sắp xếp tăng dần** theo trường `$field`.
     * - Dùng so sánh số (float).
     *
     * @param array       $products  Mảng sản phẩm đã sắp xếp
     * @param string      $field     Tên trường số
     * @param float|int   $target    Giá trị cần tìm
     *
     * @return array|null            Trả về 1 sản phẩm hoặc null
     */
    function binary_search_products_by_numeric_field(array $products, string $field, $target): ?array
    {
        $low = 0;
        $high = count($products) - 1;

        // Convert dữ liệu cần tìm thành float
        $targetVal = (float)$target;

        while ($low <= $high) {
            $mid = intdiv($low + $high, 2);

            // Lấy giá trị số từ field (mặc định 0 nếu không tồn tại)
            $val = isset($products[$mid][$field]) ? (float)$products[$mid][$field] : 0.0;

            if ($val === $targetVal) {
                return $products[$mid];
            }

            if ($val < $targetVal) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }

        return null;
    }
}

