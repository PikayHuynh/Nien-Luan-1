<?php
// 
//  SEARCHING UTIL — Hỗ trợ tìm kiếm & tìm kiếm nhị phân cho sản phẩm
// 


/* =====================================================================
 * 1) TÌM KIẾM TUẦN TỰ THEO CHUỖI — search_products()
 * =====================================================================*/

if (!function_exists('search_products')) {

    /**
     * Tìm kiếm sản phẩm trong mảng dựa theo chuỗi nhập.
     *
     * - Tìm theo: TENHANGHOA, TENPHANLOAI, MOTA.
     * - Không phân biệt hoa/thường.
     * - Chuỗi rỗng hoặc null → trả về toàn bộ danh sách.
     *
     * @param array       $products   Mảng sản phẩm
     * @param string|null $q          Từ khóa tìm kiếm
     * @return array                   Kết quả tìm (reset index)
     */
    function search_products(array $products, ?string $q): array
    {
        if ($q === null || trim($q) === '') {
            return $products;
        }

        $qLower = mb_strtolower(trim($q));
        $out = [];

        foreach ($products as $p) {

            // Ghép tất cả trường cần tìm kiếm vào 1 chuỗi
            $text = (
                ($p['TENHANGHOA']  ?? '') . ' ' .
                ($p['TENPHANLOAI'] ?? '') . ' ' .
                ($p['MOTA']        ?? '')
            );

            if ($text !== '' && mb_stripos(mb_strtolower($text), $qLower) !== false) {
                $out[] = $p;
            }
        }

        return array_values($out);
    }
}

//Check theo field trung thì đưa vào mảng
function filter_by_field(array $arr, string $field, string $q): array
{
    if (empty($arr) || trim($q) === '') return $arr;
    //mb_strtolower converter sang dạng thường
    $qLower = mb_strtolower($q);
    $results = [];
    foreach ($arr as $item) {
        $val = mb_strtolower($item[$field] ?? '');
        if (str_contains($val, $qLower)) {
            $results[] = $item;
        }
    }
    return $results;
}
