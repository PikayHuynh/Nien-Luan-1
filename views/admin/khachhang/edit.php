<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<h1><?= isset($khachHang) ? "Sửa" : "Thêm mới" ?> Khách Hàng</h1>

<form method="POST" enctype="multipart/form-data">
  <?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <div class="mb-3">
    <label>Tên KH</label>
    <input type="text" class="form-control" name="TEN_KH" value="<?= $khachHang['TEN_KH'] ?? '' ?>" required <?= (!empty($khachHang['IS_ADMIN']) ? 'disabled' : '') ?> >
    <?php if(!empty($khachHang['IS_ADMIN'])): ?>
      <div class="form-text">Tài khoản admin không thể đổi tên.</div>
    <?php endif; ?>
  </div>
  <div class="mb-3">
    <label>Địa chỉ</label>
    <input type="text" class="form-control" name="DIACHI" value="<?= $khachHang['DIACHI'] ?? '' ?>">
  </div>
  <div class="mb-3">
    <label>Số điện thoại</label>
    <input type="text" class="form-control" name="SODIENTHOAI" value="<?= $khachHang['SODIENTHOAI'] ?? '' ?>">
  </div>
  <div class="mb-3">
    <label>Số B</label>
    <input type="text" class="form-control" name="SOB" value="<?= $khachHang['SOB'] ?? '' ?>">
  </div>
  <div class="mb-3">
    <label>Hình ảnh</label>
    <input type="file" class="form-control" name="HINHANH">
    <?php if(!empty($khachHang['HINHANH'])): ?>
      <img src="upload/<?= htmlspecialchars($khachHang['HINHANH']) ?>" width="50" class="mt-2">
    <?php endif; ?>
  </div>
  <button type="submit" class="btn btn-success">Lưu</button>
  <a href="index.php?controller=khachhang&action=index" class="btn btn-secondary">Hủy</a>
</form>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
