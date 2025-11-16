<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-5" style="max-width: 600px;">
    <h3 class="mb-4 text-center">Cập nhật thông tin tài khoản</h3>

    <?php if(isset($error) && $error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?php if(isset($success) && $success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=user&action=editProfile">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="TEN_KH" value="<?= htmlspecialchars($user['TEN_KH']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="DIACHI" value="<?= htmlspecialchars($user['DIACHI']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="SODIENTHOAI" value="<?= htmlspecialchars($user['SODIENTHOAI']) ?>">
        </div>
        <button type="submit" class="btn btn-success w-100">Cập nhật</button>
    </form>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
