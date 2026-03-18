<?php
// =======================================================
// HEADER + NAVBAR CLIENT
// =======================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5" style="max-width: 420px;">

    <!-- TIÊU ĐỀ -->
    <h3 class="mb-4 text-center fw-bold">Đăng nhập tài khoản</h3>

    <!-- HIỂN THỊ LỖI -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- FORM ĐĂNG NHẬP -->
    <form
        method="POST"
        action="index.php?controller=user&action=login"
        class="border rounded p-4 shadow-sm bg-white">

        <!-- Username -->
        <div class="mb-3">
            <label class="form-label">Tên đăng nhập</label>
            <input
                type="text"
                class="form-control"
                name="TEN_KH"
                placeholder="Nhập username...">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input
                type="password"
                class="form-control"
                id="password"
                name="MATKHAU"
                placeholder="Nhập mật khẩu...">
        </div>

        <!-- Nút đăng nhập -->
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
        </button>

        <!-- Link đăng ký -->
        <p class="mt-3 text-center">
            Chưa có tài khoản?
            <a href="index.php?controller=user&action=register">Đăng ký ngay</a>
        </p>

    </form>

</div>

<?php
// FOOTER
include ROOT . '/views/client/layouts/footer.php';
?>