<?php
// ======================================================================
// HEADER + NAVBAR (Client)
// ======================================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5" style="max-width: 600px;">

    <!-- =========================================
         TIÊU ĐỀ
    ========================================== -->
    <h3 class="mb-4 text-center fw-bold">Cập nhật thông tin tài khoản</h3>

    <!-- =========================================
         THÔNG BÁO LỖI & THÀNH CÔNG
    ========================================== -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <!-- =========================================
         AVATAR NGƯỜI DÙNG
    ========================================== -->
    <?php if (!empty($user['HINHANH'])): ?>
        <div class="text-center mb-3">
            <img
                src="upload/<?= htmlspecialchars($user['HINHANH']) ?>"
                alt="avatar"
                class="shadow-sm"
                style="max-width:130px; border-radius:10px;">
        </div>
    <?php else: ?>
        <div class="text-center mb-3">
            <img
                src="upload/default.png"
                class="shadow-sm"
                style="max-width:130px; border-radius:10px;">
        </div>
    <?php endif; ?>

    <!-- =========================================
         FORM CẬP NHẬT THÔNG TIN
    ========================================== -->
    <form
        method="POST"
        action="index.php?controller=user&action=editProfile"
        enctype="multipart/form-data"
        class="border rounded p-4 shadow-sm bg-white">

        <!-- Tên người dùng -->
        <div class="mb-3">
            <label class="form-label">Họ và tên / Username</label>
            <input
                type="text"
                class="form-control"
                name="TEN_KH"
                value="<?= htmlspecialchars($user['TEN_KH'] ?? '') ?>"
                required>
        </div>

        <!-- Địa chỉ -->
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input
                type="text"
                class="form-control"
                name="DIACHI"
                value="<?= htmlspecialchars($user['DIACHI'] ?? '') ?>">
        </div>

        <!-- Số điện thoại -->
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input
                type="text"
                class="form-control"
                name="SODIENTHOAI"
                value="<?= htmlspecialchars($user['SODIENTHOAI'] ?? '') ?>">
        </div>

        <!-- Hình ảnh đại diện -->
        <div class="mb-3">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" name="HINHANH">
            <small class="text-muted">Hỗ trợ JPG, PNG — tối đa 5MB</small>
        </div>

        <!-- Nút cập nhật -->
        <button type="submit" class="btn btn-success w-100 py-2">
            <i class="bi bi-save"></i> Cập nhật
        </button>

    </form>

</div>

<?php
// ======================================================================
// FOOTER
// ======================================================================
include ROOT . '/views/client/layouts/footer.php';
?>