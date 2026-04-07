<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5 mb-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <div class="d-inline-block p-3 rounded-circle bg-glass border border-white-10 mb-3 shadow-lg">
                    <i class="bi bi-person-lock text-primary display-4"></i>
                </div>
                <h2 class="fw-bold text-white mb-2">Chào mừng trở lại</h2>
                <p class="text-muted small">Đăng nhập để trải nghiệm thế giới công nghệ của Pikay Shop</p>
            </div>

            <!-- HIỂN THỊ LỖI -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger bg-glass border-white-10 text-danger rounded-4 mb-4 shadow-sm">
                    <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- FORM ĐĂNG NHẬP -->
            <div class="card bg-glass border-white-10 p-4 rounded-4 shadow-2xl">
                <form method="POST" action="index.php?controller=user&action=login">
                    
                    <div class="mb-4">
                        <label class="form-label text-white small fw-bold text-uppercase opacity-75">Tên đăng nhập</label>
                        <div class="input-group bg-dark rounded-3 border border-white-10 overflow-hidden">
                            <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control bg-transparent border-0 text-white py-2" name="TEN_KH" placeholder="Username của bạn" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white small fw-bold text-uppercase opacity-75">Mật khẩu</label>
                        <div class="input-group bg-dark rounded-3 border border-white-10 overflow-hidden">
                            <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control bg-transparent border-0 text-white py-2" name="MATKHAU" placeholder="••••••••" required>
                        </div>
                        <div class="text-end mt-2">
                            <a href="#" class="text-primary small text-decoration-none">Quên mật khẩu?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-lg mb-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập ngay
                    </button>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Chưa có tài khoản?</p>
                        <a href="index.php?controller=user&action=register" class="text-primary fw-bold text-decoration-none">Đăng ký thành viên mới</a>
                    </div>
                </form>
            </div>

            <div class="mt-5 text-center">
                <a href="index.php?controller=home&action=index" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại trang chủ
                </a>
            </div>

        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>