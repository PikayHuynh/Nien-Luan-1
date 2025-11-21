<?php 
// views/client/product/list.php
include ROOT . '/views/client/layouts/header.php'; 
include ROOT . '/views/client/layouts/navbar.php'; 
?>

<div class="container mt-4">
    <div class="row">
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Danh mục sản phẩm</h5>
                </div>
                <div class="list-group list-group-flush">
                    <?php 
                    // Build URL that preserves price, feature, search when clicking 'All'
                    $clearCatUrl = "index.php?controller=product&action=list";
                    if (isset($_GET['use_algo']) && $_GET['use_algo'] == '1') {
                        $clearCatUrl .= "&use_algo=1";
                    }
                    if (isset($_GET['price']) && $_GET['price']) {
                        $clearCatUrl .= "&price=" . urlencode($_GET['price']);
                    }
                    if (isset($_GET['feature']) && $_GET['feature']) {
                        $clearCatUrl .= "&feature=" . urlencode($_GET['feature']);
                    }
                    if (isset($_GET['q']) && $_GET['q']) {
                        $clearCatUrl .= "&q=" . urlencode($_GET['q']);
                    }
                    ?>
                    <a href="<?= $clearCatUrl ?>" 
                       class="list-group-item list-group-item-action <?= ($id_phanloai === null) ? 'active' : '' ?>">
                        Tất cả sản phẩm
                    </a>
                    
                    <?php foreach($phanloaiList as $phanloai): ?>
                        <?php
                        // Build URL that preserves price, feature, search when clicking a category
                        $catUrl = "index.php?controller=product&action=list&id_phanloai=" . $phanloai['ID_PHANLOAI'];
                        if (isset($_GET['use_algo']) && $_GET['use_algo'] == '1') {
                            $catUrl .= "&use_algo=1";
                        }
                        if (isset($_GET['price']) && $_GET['price']) {
                            $catUrl .= "&price=" . urlencode($_GET['price']);
                        }
                        if (isset($_GET['feature']) && $_GET['feature']) {
                            $catUrl .= "&feature=" . urlencode($_GET['feature']);
                        }
                        if (isset($_GET['q']) && $_GET['q']) {
                            $catUrl .= "&q=" . urlencode($_GET['q']);
                        }
                        ?>
                        <a href="<?= $catUrl ?>" 
                           class="list-group-item list-group-item-action <?= (isset($id_phanloai) && $id_phanloai == $phanloai['ID_PHANLOAI']) ? 'active' : '' ?>">
                            <?= $phanloai['TENPHANLOAI'] ?> 
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-light">
                    <strong>Mức giá</strong>
                </div>
                <div class="list-group list-group-flush">
                    <?php
                        $ranges = [
                            '0-100000'        => '0 - 100.000',
                            '100000-200000'   => '100.000 - 200.000',
                            '200000-500000'   => '200.000 - 500.000',
                            '500000-1000000'  => '500.000 - 1.000.000',
                            'price_asc'       => 'Giá: Thấp → Cao',
                            'price_desc'      => 'Giá: Cao → Thấp',
                        ];

                        $currentPrice = isset($_GET['price']) ? $_GET['price'] : null;

                        foreach ($ranges as $key => $label):
                            $priceUrl = "index.php?controller=product&action=list&price=$key";
                            if (isset($_GET['use_algo']) && $_GET['use_algo'] == '1') {
                                $priceUrl .= "&use_algo=1";
                            }

                            if (!empty($_GET['id_phanloai'])) {
                                $priceUrl .= "&id_phanloai=" . (int)$_GET['id_phanloai'];
                            }
                            if (!empty($_GET['feature'])) {
                                $priceUrl .= "&feature=" . urlencode($_GET['feature']);
                            }
                            if (!empty($_GET['q'])) {
                                $priceUrl .= "&q=" . urlencode($_GET['q']);
                            }
                        ?>
                            <a href="<?= $priceUrl ?>" 
                            class="list-group-item <?= ($currentPrice === $key ? 'active' : '') ?>">
                                <?= $label ?>
                            </a>
                        <?php endforeach; ?>
                        <?php
                        // Build URL that clears price but preserves category, feature, search
                        $clearPriceUrl = "index.php?controller=product&action=list";
                        if (isset($_GET['use_algo']) && $_GET['use_algo'] == '1') {
                            $clearPriceUrl .= "&use_algo=1";
                        }
                        if (isset($id_phanloai) && $id_phanloai !== null) {
                            $clearPriceUrl .= "&id_phanloai=" . (int)$id_phanloai;
                        }
                        if (isset($_GET['feature']) && $_GET['feature']) {
                            $clearPriceUrl .= "&feature=" . urlencode($_GET['feature']);
                        }
                        if (isset($_GET['q']) && $_GET['q']) {
                            $clearPriceUrl .= "&q=" . urlencode($_GET['q']);
                        }
                    ?>
                    <a href="<?= $clearPriceUrl ?>" class="list-group-item list-group-item-action <?= empty($currentPrice) ? 'active' : '' ?>">Tất cả mức giá</a>
                </div>
            </div>

        </div>

        <div class="col-md-9">
            <?php $currentQ = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>
            <form class="mb-3" method="get" action="index.php">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="list">
                <?php if (isset($id_phanloai) && $id_phanloai !== null): ?>
                    <input type="hidden" name="id_phanloai" value="<?= (int)$id_phanloai ?>">
                <?php endif; ?>
                <?php if (isset($_GET['feature']) && $_GET['feature']): ?>
                    <input type="hidden" name="feature" value="<?= htmlspecialchars($_GET['feature']) ?>">
                <?php endif; ?>
                <?php if (isset($_GET['price']) && $_GET['price']): ?>
                    <input type="hidden" name="price" value="<?= htmlspecialchars($_GET['price']) ?>">
                <?php endif; ?>
                <div class="input-group">
                    <?php if (isset($_GET['use_algo']) && $_GET['use_algo'] == '1'): ?>
                        <input type="hidden" name="use_algo" value="1">
                    <?php endif; ?>
                    <input type="text" name="q" class="form-control" placeholder="Tìm sản phẩm..." value="<?= $currentQ ?>">
                    <button class="btn btn-outline-secondary" type="submit">Tìm</button>
                    <?php if ($currentQ !== ''): ?>
                        <a class="btn btn-link" href="index.php?controller=product&action=list<?php
                            echo (isset($id_phanloai) && $id_phanloai !== null) ? '&id_phanloai=' . (int)$id_phanloai : '';
                            echo (isset($_GET['feature']) && $_GET['feature']) ? '&feature=' . urlencode($_GET['feature']) : '';
                            echo (isset($_GET['price']) && $_GET['price']) ? '&price=' . urlencode($_GET['price']) : '';
                            echo (isset($_GET['use_algo']) && $_GET['use_algo'] == '1') ? '&use_algo=1' : '';
                        ?>">Xóa</a>
                    <?php endif; ?>
                </div>
            </form>
            <h2>Sản phẩm</h2>
            <?php if (!empty($useAlgo) && isset($_SESSION['user_name']) && $_SESSION['user_name'] === 'admin'): ?>
                <?php
                    $parts = [];
                    if ($dbFetchTimeMs !== null) {
                        $parts[] = 'Thời gian truy vấn CSDL: <strong>' . htmlspecialchars(number_format(((float)$dbFetchTimeMs) / 1000, 3)) . ' s</strong>';
                    }
                    if ($algoSearchTimeMs !== null) {
                        $parts[] = 'search: <strong>' . htmlspecialchars(number_format(((float)$algoSearchTimeMs) / 1000, 3)) . ' s</strong>';
                    }
                    if ($algoSortTimeMs !== null) {
                        $parts[] = 'Sort: <strong>' . htmlspecialchars(number_format(((float)$algoSortTimeMs) / 1000, 3)) . ' s</strong>';
                    }
                ?>
                <?php if (!empty($parts)): ?>
                    <div class="alert alert-info py-2">
                        <strong>Algorithm mode:</strong>
                        &nbsp;<?php echo implode('&nbsp;|&nbsp;', $parts); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (!$useAlgo && isset($dbFetchTimeMs) && isset($_SESSION['user_name']) && $_SESSION['user_name'] === 'admin'): ?>
                <?php
                    $dbParts = [];
                    $formattedDbTime = htmlspecialchars(number_format(((float)$dbFetchTimeMs) / 1000, 3));
                    if (!empty($q)) {
                        $dbParts[] = 'Thời gian tìm kiếm : <strong>' . $formattedDbTime . ' s</strong>';
                    }
                    if (!empty($sortPrice) && ($sortPrice === 'price_asc' || $sortPrice === 'price_desc')) {
                        $dbParts[] = 'Thời gian sắp xếp: <strong>' . $formattedDbTime . ' s</strong>';
                    }
                    if (empty($dbParts)) {
                        $dbParts[] = 'Thời gian truy vấn CSDL: <strong>' . $formattedDbTime . ' s</strong>';
                    }
                ?>
                <div class="alert alert-info py-2">
                    <strong>Chế độ DB:</strong>
                    &nbsp;<?php echo implode('&nbsp;|&nbsp;', $dbParts); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_name']) && $_SESSION['user_name'] === 'admin' && !empty($_GET['debug']) && $_GET['debug'] == '1'): ?>
                <div class="alert alert-secondary">
                    <strong>Debug:</strong>
                    <pre style="white-space:pre-wrap;font-size:12px"><?php echo htmlspecialchars(print_r($debugInfo, true)); ?></pre>
                </div>
            <?php endif; ?>
            <?php if (!empty($_GET['feature'])):
                $feature = $_GET['feature'];
                $featureMap = [
                    'new' => 'Sản phẩm mới',
                    'promo' => 'Khuyến mãi'
                ];
                $subtitle = $featureMap[$feature] ?? null;
                if ($subtitle): ?>
                    <p class="text-muted mb-3"><?= htmlspecialchars($subtitle) ?></p>
                <?php endif; endif; ?>
            <?php if(!empty($products)): ?>
            <div class="row">
                <?php foreach($products as $product): ?>
                <div class="col-lg-4 col-md-6 mb-4"> <div class="card h-100">
                        <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'default.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>">
                        <div class="card-body d-flex flex-column">
                            <a class="title-product" href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>"><?= $product['TENHANGHOA'] ?? 'Không tên' ?></a>
                            <p class="card-text text-danger font-weight-bold">
                                <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND
                            </p>
                            <p class="card-text text-muted small"><?= $product['TENPHANLOAI'] ?? '' ?></p>
                            <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" class="btn btn-primary mt-auto">Thêm giỏ hàng</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
            
            <?php if ($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?controller=product&action=list&page=<?= $currentPage - 1 ?><?= $filter_param ?>">« Prev</a>
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
                            <a class="page-link" href="?controller=product&action=list&page=<?= $currentPage + 1 ?><?= $filter_param ?>">Next »</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>