<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-4 home-page">

    <!-- ============================================================
         404 METHOD NOT FOUND - HERO
    ============================================================ -->
    <section class="home-hero position-relative text-center rounded mb-5 bg-light">
        <div class="hero-content py-5">

            <h1 class="display-4 mb-3 fw-bold text-warning">
                404
            </h1>

            <h2 class="mb-3">
                Method Not Found
            </h2>

            <p class="lead mb-4 text-muted">
                Chức năng bạn yêu cầu không tồn tại hoặc đã bị gỡ bỏ.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary px-4"
                    href="index.php">
                    Về trang chủ
                </a>

                <a class="btn btn-outline-secondary px-4"
                    href="javascript:history.back()">
                    Quay lại
                </a>
            </div>

        </div>
    </section>

    <!-- ============================================================
         GỢI Ý
    ============================================================ -->
    <section class="row g-4 mb-5">

        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h5>Đường dẫn sai</h5>
                <p class="mb-0 small text-muted">
                    Action bạn gọi không được hệ thống hỗ trợ.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h5>Kiểm tra URL</h5>
                <p class="mb-0 small text-muted">
                    Hãy kiểm tra lại controller và action trên thanh địa chỉ.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h5>Tiếp tục</h5>
                <p class="mb-0 small text-muted">
                    Bạn vẫn có thể tiếp tục mua sắm hoặc sử dụng hệ thống.
                </p>
            </div>
        </div>

    </section>

</div>
<?php include ROOT . '/views/client/layouts/footer.php'; ?>