<?php include ROOT . '../views/layouts/header.php'; ?>
<?php include ROOT . '../views/layouts/sidebar.php'; ?>

<h1><?= isset($khachHang) ? "Sửa" : "Thêm mới" ?> Khách Hàng</h1>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label>Tên KH</label>
    <input type="text" class="form-control" name="TEN_KH" value="<?= $khachHang['TEN_KH'] ?? '' ?>" required>
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
      <img src="uploads/<?= $khachHang['HINHANH'] ?>" width="50" class="mt-2">
    <?php endif; ?>
  </div>
  <button type="submit" class="btn btn-success">Lưu</button>
  <a href="index.php?controller=khachhang&action=index" class="btn btn-secondary">Hủy</a>
</form>

<?php include ROOT . '../views/layouts/footer.php'; ?>
