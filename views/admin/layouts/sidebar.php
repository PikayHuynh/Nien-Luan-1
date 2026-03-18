<!-- =====================================================
     SIDEBAR ADMIN — MENU QUẢN TRỊ HỆ THỐNG
     Giữ layout theo Bootstrap, thêm style để dễ nhìn hơn
===================================================== -->

<div class="d-flex">

    <!-- ===================== SIDEBAR ===================== -->
    <nav class="sidebar col-md-2 d-none d-md-flex flex-column p-3">

        <!-- Tiêu đề sidebar -->
        <h4 class="text-white text-center mb-4 fw-bold">QUẢN TRỊ</h4>

        <!-- Danh sách menu -->
        <ul class="nav flex-column">

            <!-- Trang chủ -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php">
                    <i class="bi bi-house-door me-2"></i>Trang chủ
                </a>
            </li>

            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=dashboard&action=index">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>

            <!-- Khách hàng -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=khachhang&action=index">
                    <i class="bi bi-people me-2"></i>Khách Hàng
                </a>
            </li>

            <!-- Hàng hóa -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=hanghoa&action=index">
                    <i class="bi bi-box-seam me-2"></i>Hàng Hóa
                </a>
            </li>

            <!-- Kho -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=kho&action=index">
                    <i class="bi bi-box-fill me-2"></i>Quản Lý Kho
                </a>
            </li>

            <!-- Phân loại -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=phanloai&action=index">
                    <i class="bi bi-tags me-2"></i>Phân Loại
                </a>
            </li>

            <!-- Thuộc tính -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=thuoctinh&action=index">
                    <i class="bi bi-sliders me-2"></i>Thuộc Tính
                </a>
            </li>

            <!-- Đơn giá bán -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=dongiaban&action=index">
                    <i class="bi bi-cash-coin me-2"></i>Đơn Giá Bán
                </a>
            </li>

            <!-- Chứng từ mua -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=chungtumua&action=index">
                    <i class="bi bi-bag-plus me-2"></i>Chứng Từ Mua
                </a>
            </li>

            <!-- Chứng từ bán -->
            <li class="nav-item mb-2">
                <a class="nav-link" href="index.php?controller=chungtuban&action=index">
                    <i class="bi bi-receipt-cutoff me-2"></i>Chứng Từ Bán
                </a>
            </li>

        </ul>

        <!-- Footer sidebar -->
        <div class="mt-auto text-center text-white small opacity-75 pt-3">
            &copy; <?= date("Y") ?> Pikay
        </div>
    </nav>

    <!-- ================ MAIN CONTENT ================ -->
    <main class="col-md-10 ms-sm-auto px-4 py-3">