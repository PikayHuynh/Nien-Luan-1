<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5 home-page">

    <!-- ============================================================
         404 METHOD NOT FOUND - HERO
    ============================================================ -->
    <section class="home-hero position-relative text-center rounded-4 mb-5 glass-card shadow-lg border-0 overflow-hidden" style="background: rgba(30, 41, 59, 0.5);">
        <!-- Decorative subtle glow blobs -->
        <div class="bg-blur-blob" style="top: -100px; left: 50%; transform: translateX(-50%); opacity: 0.15; width: 500px; height: 500px;"></div>

        <div class="hero-content py-5 position-relative z-1">

            <h1 class="display-1 mb-2 fw-800 text-gradient-premium" style="font-size: 8rem; letter-spacing: -5px;">
                404
            </h1>

            <h2 class="mb-3 text-white fw-bold">
                Trang Không Tồn Tại
            </h2>

            <p class="lead mb-4 text-muted mx-auto" style="max-width: 600px; font-size: 1.1rem;">
                Có vẻ như bạn đã đi lạc vào một vùng không gian không có dữ liệu.
                Đường dẫn bạn yêu cầu có thể đã bị thay đổi hoặc không còn tồn tại trên hệ thống.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm transition-all"
                    href="index.php">
                    <i class="bi bi-house-door me-2"></i> Về trang chủ
                </a>

                <a class="btn btn-outline-primary btn-lg rounded-pill px-5 transition-all"
                    href="javascript:history.back()">
                    <i class="bi bi-arrow-left me-2"></i> Quay lại
                </a>
            </div>

        </div>
    </section>

    <!-- ============================================================
         GỢI Ý / HỖ TRỢ
    ============================================================ -->
    <section class="row g-4 mb-5">

        <div class="col-12 col-md-4">
            <div class="card glass-card p-4 text-center h-100 feature-card border-0">
                <div class="feature-icon mb-3"><i class="bi bi-link-45deg fs-1 text-primary"></i></div>
                <h5 class="text-white fw-bold">Đường dẫn sai</h5>
                <p class="mb-0 text-muted small">
                    Vui lòng kiểm tra lại địa chỉ URL của bạn để đảm bảo không có lỗi chính tả.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card glass-card p-4 text-center h-100 feature-card border-0">
                <div class="feature-icon mb-3"><i class="bi bi-search fs-1 text-primary"></i></div>
                <h5 class="text-white fw-bold">Tìm sản phẩm</h5>
                <p class="mb-0 text-muted small">
                    Bạn có thể quay lại trang sản phẩm để tìm kiếm những món đồ ưng ý nhất.
                </p>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card glass-card p-4 text-center h-100 feature-card border-0">
                <div class="feature-icon mb-3"><i class="bi bi-headset fs-1 text-primary"></i></div>
                <h5 class="text-white fw-bold">Hỗ trợ 24/7</h5>
                <p class="mb-0 text-muted small">
                    Nếu bạn tin đây là lỗi hệ thống, hãy liên hệ với chúng tôi để được trợ giúp.
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