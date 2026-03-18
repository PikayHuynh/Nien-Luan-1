<?php
// ===============================
//  HEADER + SIDEBAR ADMIN
// ===============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- Tiêu đề động: Thêm hoặc Sửa -->
    <h2 class="mb-3">
        <?= isset($khachHang) ? "Sửa Khách Hàng" : "Thêm mới Khách Hàng" ?>
    </h2>

    <!-- ===============================
         THÔNG BÁO LỖI (NẾU CÓ)
    =============================== -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- ===============================
         FORM NHẬP LIỆU KHÁCH HÀNG
    =============================== -->
    <form method="POST" enctype="multipart/form-data">

        <!-- Tên khách hàng -->
        <div class="mb-3">
            <label class="form-label">Tên khách hàng</label>
            <input
                type="text"
                class="form-control"
                name="TEN_KH"
                value="<?= htmlspecialchars($khachHang['TEN_KH'] ?? '') ?>"
                required
                <?= (!empty($khachHang['IS_ADMIN']) ? 'disabled' : '') ?>>

            <!-- Thông báo nếu là tài khoản admin -->
            <?php if (!empty($khachHang['IS_ADMIN'])): ?>
                <div class="form-text text-muted">
                    Tài khoản admin không thể đổi tên.
                </div>
            <?php endif; ?>
        </div>

        <!-- Địa chỉ -->
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input
                type="text"
                class="form-control"
                name="DIACHI"
                value="<?= htmlspecialchars($khachHang['DIACHI'] ?? '') ?>">
        </div>

        <!-- Số điện thoại -->
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input
                type="text"
                class="form-control"
                name="SODIENTHOAI"
                value="<?= htmlspecialchars($khachHang['SODIENTHOAI'] ?? '') ?>">
        </div>

        <!-- Số B -->
        <div class="mb-3">
            <label class="form-label">Số B</label>
            <input
                type="text"
                class="form-control"
                name="SOB"
                value="<?= htmlspecialchars($khachHang['SOB'] ?? '') ?>">
        </div>

        <!-- Hình ảnh -->
        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" name="HINHANH">

            <!-- Hiển thị hình hiện tại nếu có -->
            <?php if (!empty($khachHang['HINHANH'])): ?>
                <img
                    src="upload/<?= htmlspecialchars($khachHang['HINHANH']) ?>"
                    width="70"
                    class="mt-2"
                    style="border-radius:4px;">
            <?php endif; ?>
        </div>

        <!-- Nút submit -->
        <button type="submit" class="btn btn-success">Lưu</button>

        <!-- Nút quay về danh sách -->
        <a href="index.php?controller=khachhang&action=index" class="btn btn-secondary">
            Hủy
        </a>

    </form>

</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>