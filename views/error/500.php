<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5 home-page">

    <!-- ============================================================
         500 INTERNAL SERVER ERROR - HERO
    ============================================================ -->
    <section class="home-hero position-relative text-center rounded-4 mb-5 glass-card shadow-lg border-0 overflow-hidden" style="background: rgba(30, 41, 59, 0.5);">
        <!-- Decorative subtle glow blobs -->
        <div class="bg-blur-blob" style="top: -100px; left: 50%; transform: translateX(-50%); opacity: 0.15; width: 500px; height: 500px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(236, 72, 153, 0.1) 100%);"></div>

        <div class="hero-content py-5 position-relative z-1">

            <h1 class="display-1 mb-2 fw-800 text-gradient-premium" style="font-size: 8rem; letter-spacing: -5px; --lp-gradient-premium: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);">
                500
            </h1>

            <h2 class="mb-3 text-white fw-bold">
                Lỗi Hệ Thống
            </h2>

            <p class="lead mb-4 text-muted mx-auto" style="max-width: 600px; font-size: 1.1rem; line-height: 1.8;">
                Máy chủ đang gặp sự cố ngoài ý muốn. Đội ngũ kỹ thuật của chúng tôi đã được thông báo và đang nỗ lực khắc phục. Quý khách vui lòng quay lại sau ít phút.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm transition-all"
                    href="index.php">
                    <i class="bi bi-house-door me-2"></i> Về trang chủ
                </a>

                <a class="btn btn-outline-primary btn-lg rounded-pill px-5 transition-all"
                    href="javascript:history.back()">
                    <i class="bi bi-arrow-clockwise me-2"></i> Thử tải lại trang
                </a>
            </div>

        </div>
    </section>

</div>

<style>
    .fw-800 {
        font-weight: 800;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .transition-all:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);
    }
</style>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>