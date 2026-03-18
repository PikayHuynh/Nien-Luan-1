<?php

/**
 * View: Trang danh sách sản phẩm phía client.
 *
 * Hiển thị sidebar bộ lọc và lưới sản phẩm có phân trang.
 *
 * @var array $phanloaiList Danh sách các phân loại.
 * @var array $products     Danh sách sản phẩm của trang hiện tại.
 * @var int   $id_phanloai  ID của phân loại đang được lọc.
 * @var int   $totalPages   Tổng số trang.
 * @var int   $currentPage  Trang hiện tại.
 * @var int   $startPage    Trang bắt đầu của thanh phân trang.
 * @var int   $endPage      Trang kết thúc của thanh phân trang.
 * @var string $filter_param Chuỗi query string chứa các bộ lọc hiện tại.
 */

include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

/**
 * Hàm trợ giúp xây dựng URL bộ lọc.
 * Tự động giữ lại các tham số lọc hiện có trên URL.
 */
function build_filter_url(array $new_params = []): string
{
    $current_params = $_GET;
    unset($current_params['page']); // Loại bỏ tham số trang để luôn bắt đầu từ trang 1 khi có bộ lọc mới
    $merged_params = array_merge($current_params, $new_params);
    return "index.php?" . http_build_query($merged_params);
}
?>

<div class="container mt-4">
    <div class="row">
        <!-- =================================================================
             SIDEBAR - BỘ LỌC SẢN PHẨM
        ================================================================== -->
        <div class="col-lg-3 mb-4">
            <!-- Lọc theo danh mục -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Danh mục sản phẩm</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= build_filter_url(['id_phanloai' => null]) ?>"
                        class="list-group-item list-group-item-action <?= ($id_phanloai === null) ? 'active' : '' ?>">
                        Tất cả sản phẩm
                    </a>

                    <?php foreach ($phanloaiList as $phanloai): ?>
                        <a href="<?= build_filter_url(['id_phanloai' => $phanloai['ID_PHANLOAI']]) ?>"
                            class="list-group-item list-group-item-action <?= (isset($id_phanloai) && $id_phanloai == $phanloai['ID_PHANLOAI']) ? 'active' : '' ?>">
                            <?= $phanloai['TENPHANLOAI'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Lọc theo giá -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <strong>Mức giá</strong>
                </div>
                <div class="list-group list-group-flush">
                    <?php
                    $ranges = [
                        '0-1000000' => '0 - 1.000.000',
                        '1000000-2000000' => '1.000.000 - 2.000.000',
                        '2000000-5000000' => '2.000.000 - 5.000.000',
                        '5000000-10000000' => '5.000.000 - 10.000.000',
                        '10000000-20000000' => '10.000.000 - 20.000.000',
                        'price_asc' => 'Giá: Thấp → Cao',
                        'price_desc' => 'Giá: Cao → Thấp',
                    ];

                    $currentPrice = isset($_GET['price']) ? $_GET['price'] : null;

                    foreach ($ranges as $key => $label):
                    ?>
                        <a href="<?= build_filter_url(['price' => $key]) ?>"
                            class="list-group-item <?= ($currentPrice === $key ? 'active' : '') ?>">
                            <?= $label ?>
                        </a>
                    <?php endforeach; ?>
                    <a href="<?= build_filter_url(['price' => null]) ?>"
                        class="list-group-item list-group-item-action <?= empty($currentPrice) ? 'active' : '' ?>">Tất
                        cả mức giá</a>
                </div>
            </div>

        </div>

        <!-- =================================================================
             MAIN CONTENT - KHUNG TÌM KIẾM VÀ LƯỚI SẢN PHẨM
        ================================================================== -->
        <div class="col-lg-9">
            <!-- Form tìm kiếm -->
            <?php $currentQ = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>
            <form class="mb-3" method="get" action="index.php" id="searchForm">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="list">
                <?php if (isset($id_phanloai) && $id_phanloai !== null): ?>
                    <input type="hidden" name="id_phanloai" value="<?= (int) $id_phanloai ?>">
                <?php endif; ?>
                <?php if (isset($_GET['feature']) && $_GET['feature']): ?>
                    <input type="hidden" name="feature" value="<?= htmlspecialchars($_GET['feature']) ?>">
                <?php endif; ?>
                <?php if (isset($_GET['price']) && $_GET['price']): ?>
                    <input type="hidden" name="price" value="<?= htmlspecialchars($_GET['price']) ?>">
                <?php endif; ?>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" id="searchInput" placeholder="Tìm sản phẩm..."
                        value="<?= $currentQ ?>">
                    <button class="btn btn-outline-secondary" type="submit">Tìm</button>
                    <?php if ($currentQ !== ''): ?>
                        <a class="btn btn-link" href="<?= build_filter_url(['q' => null]) ?>">Xóa</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Tiêu đề và thông tin phụ -->
            <h2>Sản phẩm</h2>
            <?php if (!empty($_GET['feature'])):
                $feature = $_GET['feature'];
                $featureMap = [
                    'new' => 'Sản phẩm mới',
                    'promo' => 'Khuyến mãi'
                ];
                $subtitle = $featureMap[$feature] ?? null;
                if ($subtitle): ?>
                    <p class="text-muted mb-3"><?= htmlspecialchars($subtitle) ?></p><?php endif;
                                                                                endif; ?>

            <!-- =================================================================
                 PRODUCT GRID - LƯỚI SẢN PHẨM
            ================================================================== -->
            <?php if (!empty($products)): ?>
                <div class="row">
                    <?php foreach ($products as $product):
                        $soldCount = $product['SOLD_COUNT'] ?? 0;
                        $isHot = $soldCount > 30;

                        $ngayTao = $product['NGAYTAO'] ?? '';
                        $isNew = false;
                        if ($ngayTao) {
                            $diff = (time() - strtotime($ngayTao)) / (60 * 60 * 24);
                            if ($diff <= 3)
                                $isNew = true;
                        }

                        $giaGoc = $product['GIAGOC'] ?? 0;
                        $donGia = $product['DONGIA'] ?? 0;
                        $isSale = $giaGoc > $donGia;
                        $salePercent = 0;
                        if ($isSale && $giaGoc > 0) {
                            $salePercent = round((($giaGoc - $donGia) / $giaGoc) * 100);
                        }
                    ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 position-relative">
                                <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                                    <?php if ($isHot): ?><span class="badge bg-danger mb-1 d-block">HOT</span><?php endif; ?>
                                    <?php if ($isNew): ?><span class="badge bg-success mb-1 d-block">NEW</span><?php endif; ?>
                                    <?php if ($isSale): ?><span
                                            class="badge bg-warning text-dark d-block">-<?= $salePercent ?>%</span><?php endif; ?>
                                </div>
                                <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>"
                                    class="card-img-top" alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>">
                                <div class="card-body d-flex flex-column">
                                    <a class="title-product"
                                        href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>"><?= $product['TENHANGHOA'] ?? 'Không tên' ?></a>
                                    <p class="card-text text-danger font-weight-bold">
                                        <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND
                                    </p>
                                    <p class="card-text text-muted small"><?= $product['TENPHANLOAI'] ?? '' ?></p>
                                    <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>"
                                        class="btn btn-primary mt-auto">Thêm giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>

            <!-- =================================================================
                 PAGINATION - THANH PHÂN TRANG
            ================================================================== -->
            <?php if ($totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?controller=product&action=list&page=<?= $currentPage - 1 ?><?= $filter_param ?>">«
                                    Prev</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                <a class="page-link" href="?controller=product&action=list&page=<?= $i ?><?= $filter_param ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?controller=product&action=list&page=<?= $currentPage + 1 ?><?= $filter_param ?>">Next
                                    »</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>