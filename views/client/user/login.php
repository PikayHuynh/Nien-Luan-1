<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-5" style="max-width: 400px;">
    <h3 class="mb-4 text-center">Đăng nhập</h3>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="index.php?controller=user&action=login">
        <div class="mb-3">
            <label for="text" class="form-label">Username</label>
            <input type="text" class="form-control" name="TEN_KH" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="MATKHAU" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        <p class="mt-2 text-center">Chưa có tài khoản? <a href="index.php?controller=user&action=register">Đăng ký</a></p>
    </form>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
