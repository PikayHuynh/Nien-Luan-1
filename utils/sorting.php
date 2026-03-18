<?php
// utils/sorting.php
// Bộ hàm lọc & sắp xếp sản phẩm phía client.

/* 
 * 2) SELECTION SORT (Minh họa thuật toán O(n^2))
*/

if (!function_exists('selection_sort_by_price')) {

    /**
     * Selection sort theo giá — chỉ dùng minh họa thuật toán.
     *
     * @param array  $products
     * @param string $order  asc | desc
     * @return array
     */
    function selection_sort_by_price(array $products, string $order = 'asc'): array
    {
        $n = count($products);

        for ($i = 0; $i < $n - 1; $i++) {
            $sel = $i;

            // Tìm giá nhỏ nhất / lớn nhất
            for ($j = $i + 1; $j < $n; $j++) {

                $a = (float)($products[$j]['DONGIA'] ?? 0);
                $b = (float)($products[$sel]['DONGIA'] ?? 0);

                if ($order === 'asc') {
                    if ($a < $b) $sel = $j;
                } else {
                    if ($a > $b) $sel = $j;
                }
            }

            // Hoán đổi
            if ($sel !== $i) {
                $tmp = $products[$i];
                $products[$i] = $products[$sel];
                $products[$sel] = $tmp;
            }
        }

        return array_values($products);
    }
}
