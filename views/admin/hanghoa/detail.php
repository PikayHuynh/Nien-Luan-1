<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
    <h2>Chi tiết Hàng Hóa #<?= htmlspecialchars($hanghoa['ID_HANGHOA'] ?? '') ?></h2>

    <table class="table table-bordered">
        <tr><th>ID</th><td><?= htmlspecialchars($hanghoa['ID_HANGHOA'] ?? '') ?></td></tr>
        <tr><th>Tên</th><td><?= htmlspecialchars($hanghoa['TENHANGHOA'] ?? '') ?></td></tr>
        <tr><th>Mô tả</th><td><?= nl2br(htmlspecialchars($hanghoa['MOTA'] ?? '')) ?></td></tr>
        <tr><th>Đơn vị</th><td><?= htmlspecialchars($hanghoa['DONVITINH'] ?? '') ?></td></tr>
        <tr><th>Phân loại</th><td><?= htmlspecialchars($hanghoa['TENPHANLOAI'] ?? '') ?></td></tr>
        <tr><th>Hình ảnh</th><td><?php if (!empty($hanghoa['HINHANH'])): ?><img src="upload/<?= htmlspecialchars($hanghoa['HINHANH']) ?>" style="max-width:200px"><?php endif; ?></td></tr>
    </table>

    <a href="index.php?controller=hanghoa&action=edit&id=<?= $hanghoa['ID_HANGHOA'] ?>" class="btn btn-primary">Sửa</a>
    <a href="index.php?controller=hanghoa&action=index" class="btn btn-secondary">Quay lại</a>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
