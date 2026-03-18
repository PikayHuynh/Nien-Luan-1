<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5" style="max-width: 600px;">
    <h3 class="mb-4 text-center fw-bold">Thông tin tài khoản</h3>

    <?php
    $avatar = !empty($user['HINHANH'])
        ? 'upload/' . htmlspecialchars($user['HINHANH'])
        : 'assets/img/default-avatar.png';
    ?>

    <div class="text-center mb-4">
        <img src="<?= $avatar ?>" alt="avatar" class="shadow-sm" style="max-width:130px; border-radius:10px;">
    </div>

    <?php if (!empty($isVip)): ?>
        <div class="text-center mb-3">
            <span class="badge bg-warning text-dark fs-6 px-3 py-2 border border-dark">
                ★ VIP MEMBER (Giảm 20%)
            </span>
        </div>
    <?php endif; ?>

    <table class="table table-bordered align-middle">
        <tr>
            <th style="width: 160px;">Username</th>
            <td><?= htmlspecialchars($user['TEN_KH'] ?? '') ?></td>
        </tr>
        <tr>
            <th>Địa chỉ</th>
            <td><?= htmlspecialchars($user['DIACHI'] ?? '') ?></td>
        </tr>
        <tr>
            <th>Số điện thoại</th>
            <td><?= htmlspecialchars($user['SODIENTHOAI'] ?? '') ?></td>
        </tr>
        <tr>
            <th>Quyền</th>
            <td><?= htmlspecialchars($user['SOB'] ?? '') ?></td>
        </tr>
    </table>

    <div class="text-center mt-4">
        <a href="index.php?controller=user&action=editProfile" class="btn btn-primary px-4">
            Chỉnh sửa thông tin
        </a>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>