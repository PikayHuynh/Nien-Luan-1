<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-4">
    <h2>Sản phẩm</h2>
    <?php if(!empty($products)): ?>
    <div class="row">
        <?php foreach($products as $product): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="uploads/<?= $product['HINHANH'] ?? 'default.png' ?>" class="card-img-top" alt="<?= $product['TENHANGHOA'] ?? '' ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= $product['TENHANGHOA'] ?? 'Không tên' ?></h5>
                    <p class="card-text"><?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND</p>
                    <p class="card-text text-muted"><?= $product['TENPHANLOAI'] ?? '' ?></p>
                    <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="btn btn-primary mt-auto">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p>Không có sản phẩm nào.</p>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
