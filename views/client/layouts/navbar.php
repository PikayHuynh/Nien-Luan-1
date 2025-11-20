<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
</nav> -->