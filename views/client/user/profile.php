<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

$avatar = !empty($user['HINHANH'])
    ? 'upload/' . htmlspecialchars($user['HINHANH'])
    : 'upload/default.png';
?>

<div class="container mt-5 mb-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="profile-header text-center mb-5">
                <div class="position-relative d-inline-block">
                    <div class="avatar-wrapper p-1 rounded-circle bg-glass border border-white-10 shadow-lg mb-3">
                        <img src="<?= $avatar ?>" alt="avatar" class="rounded-circle" style="width:150px; height:150px; object-fit: cover;">
                    </div>
                    <?php if (!empty($isVip)): ?>
                        <span class="position-absolute bottom-0 end-0 badge bg-warning text-dark rounded-pill px-3 py-2 border border-white-20 shadow-sm" style="transform: translate(-10%, -20%);">
                            <i class="bi bi-star-fill me-1"></i> VIP Member
                        </span>
                    <?php endif; ?>
                </div>
                <h2 class="fw-bold text-white mt-3 mb-1"><?= htmlspecialchars($user['TEN_KH'] ?? 'Người dùng') ?></h2>
                <p class="text-muted small">Thành viên từ <?= date('M Y') ?></p>
            </div>

            <div class="row g-4">
                <!-- Sidebar Navigation -->
                <div class="col-md-4">
                    <div class="card bg-glass border-white-10 rounded-4 overflow-hidden shadow-lg mb-4">
                        <div class="list-group list-group-flush bg-transparent">
                            <a href="index.php?controller=user&action=profile" class="list-group-item list-group-item-action active bg-primary border-0 py-3">
                                <i class="bi bi-person-badge me-2"></i> Hồ sơ cá nhân
                            </a>
                            <a href="index.php?controller=user&action=orders" class="list-group-item list-group-item-action bg-transparent text-white border-white-10 py-3">
                                <i class="bi bi-bag-check me-2 text-primary"></i> Đơn hàng của tôi
                            </a>
                            <a href="index.php?controller=user&action=notifications" class="list-group-item list-group-item-action bg-transparent text-white border-white-10 py-3">
                                <i class="bi bi-bell me-2 text-primary"></i> Thông báo
                            </a>
                            <a href="index.php?controller=user&action=logout" class="list-group-item list-group-item-action bg-transparent text-danger border-white-10 py-3">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-8">
                    <div class="card bg-glass border-white-10 rounded-4 p-4 shadow-lg mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold text-white mb-0">Thông tin cơ bản</h4>
                            <a href="index.php?controller=user&action=editProfile" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                            </a>
                        </div>

                        <div class="info-grid overflow-hidden">
                            <div class="row g-0 border-bottom border-white-10 py-3">
                                <div class="col-4 text-muted small text-uppercase fw-bold">Username</div>
                                <div class="col-8 text-white"><?= htmlspecialchars($user['TEN_KH'] ?? '') ?></div>
                            </div>
                            <div class="row g-0 border-bottom border-white-10 py-3">
                                <div class="col-4 text-muted small text-uppercase fw-bold">Địa chỉ</div>
                                <div class="col-8 text-white"><?= htmlspecialchars($user['DIACHI'] ?? 'Chưa cập nhật') ?></div>
                            </div>
                            <div class="row g-0 border-bottom border-white-10 py-3">
                                <div class="col-4 text-muted small text-uppercase fw-bold">Số điện thoại</div>
                                <div class="col-8 text-white"><?= htmlspecialchars($user['SODIENTHOAI'] ?? 'Chưa cập nhật') ?></div>
                            </div>
                            <div class="row g-0 py-3">
                                <div class="col-4 text-muted small text-uppercase fw-bold">Xếp hạng</div>
                                <div class="col-8">
                                    <span class="badge <?= !empty($isVip) ? 'bg-warning text-dark' : 'bg-secondary' ?> rounded-pill">
                                        <?= htmlspecialchars($user['SOB'] ?? 'Thành viên') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($isVip)): ?>
                        <div class="alert alert-warning bg-glass border-warning-20 text-warning-40 rounded-4 shadow-sm" role="alert">
                            <div class="d-flex">
                                <i class="bi bi-lightning-charge-fill fs-4 me-3 text-warning"></i>
                                <div>
                                    <strong class="text-white d-block mb-1 fs-5"><i class="bi bi-star-fill me-2 text-warning"></i>Đặc quyền VIP đang kích hoạt!</strong>
                                    <p class="mb-0 text-white-50">Bạn đang được hưởng ưu đãi <span class="text-warning fw-bold">giảm giá 20%</span> cho tất cả đơn hàng. Cảm ơn bạn đã đồng hành cùng Pikay Shop.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>