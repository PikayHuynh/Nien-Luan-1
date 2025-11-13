<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<h1>Chi tiết Khách Hàng</h1>
<table class="table table-bordered">
  <tr><th>ID</th><td><?= $khachHang['ID_KHACH_HANG'] ?></td></tr>
  <tr><th>Tên KH</th><td><?= $khachHang['TEN_KH'] ?></td></tr>
  <tr><th>Địa chỉ</th><td><?= $khachHang['DIACHI'] ?></td></tr>
  <tr><th>SĐT</th><td><?= $khachHang['SODIENTHOAI'] ?></td></tr>
  <tr><th>Số B</th><td><?= $khachHang['SOB'] ?></td></tr>
  <tr><th>Hình ảnh</th>
    <td>
      <?php if($khachHang['HINHANH']): ?>
        <img src="uploads/<?= $khachHang['HINHANH'] ?>" width="100">
      <?php endif; ?>
    </td>
  </tr>
</table>
<a href="index.php?controller=khachhang&action=index" class="btn btn-primary">Quay lại</a>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
