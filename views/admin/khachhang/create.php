<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<h2>Thêm mới Khách Hàng</h2>
<?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Tên khách hàng</label>
        <input type="text" name="TEN_KH" class="form-control" value="<?= htmlspecialchars($_POST['TEN_KH'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label>Địa chỉ</label>
        <input type="text" name="DIACHI" class="form-control">
    </div>
    <div class="mb-3">
        <label>Điện thoại</label>
        <input type="text" name="SODIENTHOAI" class="form-control">
    </div>
    <div class="mb-3">
        <label>Số B</label>
        <input type="text" name="SOB" class="form-control">
    </div>
    <div class="mb-3">
        <label>Hình ảnh</label>
        <input type="file" name="HINHANH" class="form-control">
    </div>
    <button class="btn btn-success">Lưu</button>
</form>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
