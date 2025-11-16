<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-4">
    <?php if(!empty($product)): ?>
    <div class="row">
        <div class="col-md-5">
            <img src="uploads/<?= $product['HINHANH'] ?? 'default.png' ?>" class="img-fluid" alt="<?= $product['TENHANGHOA'] ?>">
        </div>
        <div class="col-md-7">
            <h2><?= $product['TENHANGHOA'] ?></h2>
            <p class="text-muted">Phân loại: <?= $product['TENPHANLOAI'] ?? '' ?></p>
            <p><?= $product['MOTA'] ?></p>
            <p>Đơn vị: <?= $product['DONVITINH'] ?></p>
            <p>Giá: <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND</p>
            <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" class="btn btn-success">Thêm vào giỏ</a>
        </div>
    </div>
    <?php else: ?>
    <p>Sản phẩm không tồn tại.</p>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
