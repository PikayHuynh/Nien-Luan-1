<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5 auth-container" style="max-width: 450px;">
    <h3 class="mb-4 text-center fw-bold">Đăng ký tài khoản</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=user&action=register">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input
                type="text"
                class="form-control"
                name="name"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input
                type="password"
                class="form-control"
                name="password">
        </div>

        <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu</label>
            <input
                type="password"
                class="form-control"
                name="confirm_password">
        </div>

        <button type="submit" class="btn btn-success w-100 py-2">
            Đăng ký
        </button>

        <p class="mt-3 text-center">
            Đã có tài khoản?
            <a href="index.php?controller=user&action=login">Đăng nhập ngay</a>
        </p>
    </form>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>