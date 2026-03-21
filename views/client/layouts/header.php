<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/resources/client/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="client-theme">

    <!-- Main Navbar -->
    <header class="site-header sticky-top shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.php?controller=home&action=index">Pikay Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarClient" aria-controls="navbarClient" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarClient">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=home&action=index">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=product&action=list">Sản phẩm</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=cart&action=index">Giỏ hàng</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=orders">Đơn hàng đã đặt</a></li>
                        
                        <!-- Thông báo Client -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php
                            global $conn;
                            require_once ROOT . '/models/ThongBao.php';
                            $tbModel = new ThongBao($conn);
                            
                            $isAdminUser = (isset($_SESSION['user_name']) && $_SESSION['user_name'] === 'admin');
                            $unreadCount = $isAdminUser 
                                ? $tbModel->countUnread(null, 'admin') 
                                : $tbModel->countUnread($_SESSION['user_id'], 'client');
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link position-relative" href="#" id="notiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell"></i>
                                    <?php if ($unreadCount > 0): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            <?= $unreadCount ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="notiDropdown" style="width: 320px; max-height: 450px; overflow-y: auto;">
                                    <li class="dropdown-header border-bottom pb-2 mb-2">
                                        <?= $isAdminUser ? 'Thông báo hệ thống' : 'Thông báo mới nhất' ?>
                                    </li>
                                    <?php
                                    $notis = $isAdminUser 
                                        ? $tbModel->getUnreadForAdmin(5) 
                                        : $tbModel->getUnreadForClient($_SESSION['user_id'], 5);

                                    if (empty($notis)):
                                    ?>
                                        <li><a class="dropdown-item text-muted text-center py-3">Không có thông báo mới</a></li>
                                    <?php else: ?>
                                        <?php foreach ($notis as $n): ?>
                                            <li>
                                                <a class="dropdown-item py-2 fw-bold bg-light" href="index.php?controller=user&action=mark_read&id=<?= $n['ID'] ?>">
                                                    <div class="small text-wrap"><?= htmlspecialchars($n['NOIDUNG']) ?></div>
                                                    <div class="text-muted" style="font-size: 0.7rem;"><?= date('d/m/H:i', strtotime($n['NGAYTAO'])) ?></div>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-center text-primary small" href="<?= $isAdminUser ? 'index.php?controller=dashboard&action=notifications' : 'index.php?controller=user&action=notifications' ?>">
                                            Xem tất cả lịch sử
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=profile">
                                    Xin chào, <?= $_SESSION['user_name'] ?? 'Khách' ?>
                                </a></li>
                            <?php if (isset($_SESSION['user_name']) && $_SESSION['user_name'] == 'admin') {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php?controller=dashboard&action=index">Dashboard Admin</a>
                                </li>
                            <?php
                            }
                            ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=logout">Đăng xuất</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=login">Đăng nhập</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=register">Đăng ký</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>