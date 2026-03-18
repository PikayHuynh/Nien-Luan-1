<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-4 home-page">

    <!-- ============================================================
         500 INTERNAL SERVER ERROR - HERO
    ============================================================ -->
    <section class="home-hero position-relative text-center rounded mb-5 bg-light">
        <div class="hero-content py-5">

            <h1 class="display-4 mb-3 fw-bold text-danger">
                500
            </h1>

            <h2 class="mb-3">
                Internal Server Error
            </h2>

            <p class="lead mb-4 text-muted">
                Máy chủ đang gặp sự cố. Quý khách vui lòng thử lại sau.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary px-4" href="index.php">
                    Về trang chủ
                </a>

                <a class="btn btn-outline-secondary px-4" href="javascript:history.back()">
                    Quay lại
                </a>
            </div>

        </div>
    </section>

</div>
<?php include ROOT . '/views/client/layouts/footer.php'; ?>
