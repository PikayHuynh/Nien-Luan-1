<?php
// ===============================
//  HEADER + SIDEBAR ADMIN
// ===============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <h2 class="mb-3">Chi tiết Khách Hàng</h2>

    <!-- ===============================
         BẢNG HIỂN THỊ THÔNG TIN KHÁCH HÀNG
    ================================ -->
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= htmlspecialchars($khachHang['ID_KHACH_HANG'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Tên khách hàng</th>
            <td><?= htmlspecialchars($khachHang['TEN_KH'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Địa chỉ</th>
            <td><?= htmlspecialchars($khachHang['DIACHI'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Số điện thoại</th>
            <td><?= htmlspecialchars($khachHang['SODIENTHOAI'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Số B (vai trò)</th>
            <td><?= htmlspecialchars($khachHang['SOB'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Hình ảnh</th>
            <td>
                <?php if (!empty($khachHang['HINHANH'])): ?>
                    <img
                        src="upload/<?= htmlspecialchars($khachHang['HINHANH']) ?>"
                        width="120"
                        style="border-radius:6px;">
                <?php else: ?>
                    <span class="text-muted">Không có hình ảnh</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <!-- Nút quay lại -->
    <a href="index.php?controller=khachhang&action=index" class="btn btn-primary">
        Quay lại danh sách
    </a>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>