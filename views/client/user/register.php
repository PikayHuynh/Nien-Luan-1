<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-5 auth-container">
    <h3 class="mb-4 text-center">Đăng ký tài khoản</h3>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="index.php?controller=user&action=register">
        <div class="mb-3">
            <label for="name" class="form-label">Username</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Đăng ký</button>
    </form>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
