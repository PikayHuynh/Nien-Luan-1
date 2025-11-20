<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Trang chủ' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="views/resources/client/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="client-theme">

<!-- Main Navbar -->
<header class="site-header sticky-top shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-light">
        <div class="container">
            <a class="navbar-brand" href="index.php?controller=home&action=index">My Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarClient" aria-controls="navbarClient" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarClient">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=home&action=index">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=product&action=list">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=cart&action=index">Giỏ hàng</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=orders">Đơn hàng đã đặt</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=user&action=profile">
                            Xin chào, <?= $_SESSION['user_name'] ?>
                        </a></li>
                        <?php if($_SESSION['user_name'] == 'admin') {
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