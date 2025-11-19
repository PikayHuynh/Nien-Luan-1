<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-5" style="max-width: 600px;">
    <h3 class="mb-4 text-center">Thông tin tài khoản</h3>

    <div class="text-center mb-3">
        <img src="upload/<?= htmlspecialchars($user['HINHANH']) ?>" alt="avatar" style="max-width:120px; border-radius:6px;">
    </div>
    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <td><?= htmlspecialchars($user['TEN_KH']) ?></td>
        </tr>
        <tr>
            <th>Địa chỉ</th>
            <td><?= htmlspecialchars($user['DIACHI']) ?></td>
        </tr>
        <tr>
            <th>Số điện thoại</th>
            <td><?= htmlspecialchars($user['SODIENTHOAI']) ?></td>
        </tr>
        <tr>
            <th>Quyền</th>
            <td><?= htmlspecialchars($user['SOB']) ?></td>
        </tr>
    </table>
    <div class="text-center mt-4">
        <a href="index.php?controller=user&action=editProfile" class="btn btn-primary">Chỉnh sửa thông tin</a>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
