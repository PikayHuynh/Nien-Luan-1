<?php
// utils/sorting.php
// Bộ hàm lọc & sắp xếp sản phẩm dùng ở phía client.

/**
 * Hàm lọc & sắp xếp danh sách sản phẩm theo:
 *  - khoảng giá (VD: "100000-200000")
 *  - tính năng (new, promo)
 *  - thứ tự giá (price_asc, price_desc)
 *
 * @param array       $products   Danh sách sản phẩm
 * @param string|null $priceKey   Khoảng giá hoặc từ khoá sắp xếp
 * @param string|null $feature    Lọc theo tính năng: "new" hoặc "promo"
 * @param string|null $sortKey    Từ khoá sắp xếp: "price_asc" hoặc "price_desc"
 * @return array       Danh sách đã lọc & sắp xếp
 */
if (!function_exists('filter_and_sort_products')) {

    function filter_and_sort_products(array $products, ?string $priceKey = null, ?string $feature = null, ?string $sortKey = null): array
    {
        $result = $products;

        // ------------------------------------------------------------
        // 1) LỌC THEO KHOẢNG GIÁ: dạng "min-max"
        // ------------------------------------------------------------
        if (!empty($priceKey) && preg_match('/^(\d+)-(\d+)$/', $priceKey, $m)) {
            $min = (int)$m[1];
            $max = (int)$m[2];

            $result = array_filter($result, function ($p) use ($min, $max) {
                $price = isset($p['DONGIA']) ? (int)$p['DONGIA'] : 0;
                return $price >= $min && $price <= $max;
            });
        }

        // ------------------------------------------------------------
        // 2) LỌC THEO TÍNH NĂNG: sản phẩm mới / khuyến mãi
        // ------------------------------------------------------------
        if (!empty($feature)) {

            // --- Sản phẩm mới ---
            if ($feature === 'new') {
                $result = array_filter($result, function ($p) {

                    // Nếu có cờ IS_NEW thì dùng trực tiếp
                    if (isset($p['IS_NEW'])) {
                        return (bool)$p['IS_NEW'];
                    }

                    // Nếu có ngày nhập, dùng logic 30 ngày gần nhất
                    if (isset($p['NGAYNHAP'])) {
                        $ts = strtotime($p['NGAYNHAP']);
                        return ($ts !== false) && ((time() - $ts) <= 30 * 24 * 3600);
                    }

                    return false;
                });

            // --- Sản phẩm khuyến mãi ---
            } elseif (in_array($feature, ['promo', 'khuyenmai'])) {

                $result = array_filter($result, function ($p) {

                    if (isset($p['IS_PROMO'])) return (bool)$p['IS_PROMO'];
                    if (isset($p['GIAKM']))     return (float)$p['GIAKM'] > 0;

                    // Nếu có GIACU và DONGIA, so sánh trực tiếp
                    if (isset($p['GIACU'], $p['DONGIA'])) {
                        return (float)$p['DONGIA'] < (float)$p['GIACU'];
                    }

                    return false;
                });
            }
        }

        // ------------------------------------------------------------
        // 3) XÁC ĐỊNH KIỂU SẮP XẾP GIÁ
        //    sortKey ưu tiên hơn priceKey
        // ------------------------------------------------------------
        $sort = $sortKey ?: $priceKey;

        if ($sort === 'price_asc') {
            usort($result, function ($a, $b) {
                return ((float)($a['DONGIA'] ?? 0)) <=> ((float)($b['DONGIA'] ?? 0));
            });

        } elseif ($sort === 'price_desc') {
            usort($result, function ($a, $b) {
                return ((float)($b['DONGIA'] ?? 0)) <=> ((float)($a['DONGIA'] ?? 0));
            });
        }

        return array_values($result);
    }
}

# =====================================================================
#  SELECTION SORT — Minh hoạ thuật toán O(n^2)
# =====================================================================

/**
 * Selection Sort theo trường DONGIA.
 * Dùng để minh hoạ thuật toán (không tối ưu cho dữ liệu lớn).
 *
 * @param array  $products Danh sách sản phẩm
 * @param string $order    'asc' | 'desc'
 * @return array
 */
if (!function_exists('selection_sort_by_price')) {

    function selection_sort_by_price(array $products, string $order = 'asc'): array
    {
        $n = count($products);

        for ($i = 0; $i < $n - 1; $i++) {
            $sel = $i;

            // Tìm phần tử nhỏ nhất / lớn nhất
            for ($j = $i + 1; $j < $n; $j++) {
                $a = (float)($products[$j]['DONGIA'] ?? 0);
                $b = (float)($products[$sel]['DONGIA'] ?? 0);

                if ($order === 'asc') {
                    if ($a < $b) $sel = $j;
                } else {
                    if ($a > $b) $sel = $j;
                }
            }

            // Đổi vị trí
            if ($sel !== $i) {
                $tmp = $products[$i];
                $products[$i] = $products[$sel];
                $products[$sel] = $tmp;
            }
        }

        return array_values($products);
    }
}