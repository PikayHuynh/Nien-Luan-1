<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-4 home-page">

    <!-- ============================================================
         ACCESS DENIED - HERO
    ============================================================ -->
    <section class="home-hero position-relative text-center rounded mb-5 bg-light">
        <div class="hero-content py-5">

            <h1 class="display-4 mb-3 fw-bold text-danger">
                403
            </h1>

            <h2 class="mb-3">
                Access Denied
            </h2>

            <p class="lead mb-4 text-muted">
                Bạn không có quyền truy cập vào chức năng này.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary px-4"
                    href="index.php">
                    Về trang chủ
                </a>

                <a class="btn btn-outline-secondary px-4"
                    href="index.php?controller=user&action=login">
                    Đăng nhập tài khoản khác
                </a>
            </div>

        </div>
    </section>

    <!-- ============================================================
         GỢI Ý / CTA
    ============================================================ -->
    <section class="row g-4 mb-5">

        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h5>Quyền truy cập</h5>
                <p class="mb-0 small text-muted">
                    Chức năng này chỉ dành cho quản trị viên hệ thống.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h5>Cần hỗ trợ?</h5>
                <p class="mb-0 small text-muted">
                    Liên hệ quản trị viên để được cấp quyền.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h5>Quay lại</h5>
                <p class="mb-0 small text-muted">
                    Bạn vẫn có thể tiếp tục mua sắm bình thường.
                </p>
            </div>
        </div>

    </section>

</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>