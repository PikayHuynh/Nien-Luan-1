<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5 home-page">

    <!-- ============================================================
         403 ACCESS DENIED - HERO
    ============================================================ -->
    <section class="home-hero position-relative text-center rounded-4 mb-5 glass-card shadow-lg border-0 overflow-hidden" style="background: rgba(30, 41, 59, 0.5);">
        <!-- Decorative subtle glow blobs -->
        <div class="bg-blur-blob" style="top: -100px; left: 50%; transform: translateX(-50%); opacity: 0.15; width: 500px; height: 500px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.3) 0%, rgba(236, 72, 153, 0.2) 100%);"></div>

        <div class="hero-content py-5 position-relative z-1">

            <h1 class="display-1 mb-2 fw-800 text-gradient-premium" style="font-size: 8rem; letter-spacing: -5px; --lp-gradient-premium: linear-gradient(135deg, #f87171 0%, #ef4444 50%, #b91c1c 100%);">
                403
            </h1>

            <h2 class="mb-3 text-white fw-bold">
                Truy Cập Bị Từ Chối
            </h2>

            <p class="lead mb-4 text-muted mx-auto" style="max-width: 600px; font-size: 1.1rem;">
                Bạn không có đủ quyền hạn để truy cập vào khu vực này.
                Vui lòng đảm bảo bạn đã đăng nhập đúng tài khoản hoặc liên hệ quản trị viên.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm transition-all"
                    href="index.php">
                    <i class="bi bi-house-door me-2"></i> Về trang chủ
                </a>

                <a class="btn btn-outline-primary btn-lg rounded-pill px-5 transition-all"
                    href="index.php?controller=user&action=login">
                    <i class="bi bi-person-lock me-2"></i> Đăng nhập tài khoản khác
                </a>
            </div>

        </div>
    </section>

    <!-- ============================================================
         QUYỀN HẠN
    ============================================================ -->
    <section class="row g-4 mb-5">

        <div class="col-12 col-md-4">
            <div class="card glass-card p-4 text-center h-100 feature-card border-0">
                <div class="feature-icon mb-3"><i class="bi bi-shield-lock-fill fs-1 text-danger"></i></div>
                <h5 class="text-white fw-bold">Quyền truy cập</h5>
                <p class="mb-0 text-muted small">
                    Chức năng này chỉ dành cho những thành viên có cấp bậc quản trị viên hệ thống.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card glass-card p-4 text-center h-100 feature-card border-0">
                <div class="feature-icon mb-3"><i class="bi bi-envelope-at fs-1 text-primary"></i></div>
                <h5 class="text-white fw-bold">Cần hỗ trợ?</h5>
                <p class="mb-0 text-muted small">
                    Gửi yêu cầu tới ban quản trị nếu bạn tin rằng mình cần quyền truy cập khu vực này.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card glass-card p-4 text-center h-100 feature-card border-0">
                <div class="feature-icon mb-3"><i class="bi bi-arrow-return-left fs-1 text-primary"></i></div>
                <h5 class="text-white fw-bold">Quay lại</h5>
                <p class="mb-0 text-muted small">
                    Bạn vẫn có thể khám phá hàng ngàn sản phẩm khác tại cửa hàng của chúng tôi.
                </p>
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
        box-shadow: 0 10px 20px rgba(139, 92, 246, 0.2);
    }
</style>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>