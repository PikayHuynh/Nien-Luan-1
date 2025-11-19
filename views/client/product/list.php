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
                    <a href="index.php?controller=product&action=list" 
                       class="list-group-item list-group-item-action <?= ($id_phanloai === null) ? 'active' : '' ?>">
                        Tất cả sản phẩm
                    </a>
                    
                    <?php foreach($phanloaiList as $phanloai): ?>
                        <a href="index.php?controller=product&action=list&id_phanloai=<?= $phanloai['ID_PHANLOAI'] ?>" 
                           class="list-group-item list-group-item-action <?= (isset($id_phanloai) && $id_phanloai == $phanloai['ID_PHANLOAI']) ? 'active' : '' ?>">
                            <?= $phanloai['TENPHANLOAI'] ?> 
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <h2>Sản phẩm</h2>
            <?php if(!empty($products)): ?>
            <div class="row">
                <?php foreach($products as $product): ?>
                <div class="col-lg-4 col-md-6 mb-4"> <div class="card h-100">
                        <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'default.png') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $product['TENHANGHOA'] ?? 'Không tên' ?></h5>
                            <p class="card-text text-danger font-weight-bold">
                                <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND
                            </p>
                            <p class="card-text text-muted small"><?= $product['TENPHANLOAI'] ?? '' ?></p>
                            <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
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