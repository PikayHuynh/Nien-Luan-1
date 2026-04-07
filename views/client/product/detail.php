<?php
// ======================================================================
// HEADER + NAVBAR (Client)
// ======================================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

$soldCount = $product['SOLD_COUNT'] ?? 0;
$isHot = $soldCount > 30;

$ngayTao = $product['NGAYTAO'] ?? '';
$isNew = false;
if ($ngayTao) {
    $diff = (time() - strtotime($ngayTao)) / (60 * 60 * 24);
    if ($diff <= 3)
        $isNew = true;
}

$giaGoc = $product['GIAGOC'] ?? 0;
$donGia = $product['DONGIA'] ?? 0;
$isSale = $giaGoc > $donGia && $giaGoc > 0;
$salePercent = $isSale ? round((($giaGoc - $donGia) / $giaGoc) * 100) : 0;
?>

<div class="container mt-5 pt-3">
    <?php if (!empty($product)): ?>
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?controller=home&action=index" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="index.php?controller=product&action=list" class="text-decoration-none text-muted">Sản phẩm</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page"><?= htmlspecialchars($product['TENHANGHOA']) ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- COLUMN: PRODUCT IMAGE -->
            <div class="col-md-6">
                <div class="product-detail-image-wrapper p-2 bg-glass border border-white-10 rounded-4 overflow-hidden position-relative">
                    <div class="position-absolute top-0 end-0 p-3 z-3">
                        <?php if ($isHot): ?><span class="badge bg-danger mb-1 d-block shadow-sm">HOT</span><?php endif; ?>
                        <?php if ($isNew): ?><span class="badge bg-success mb-1 d-block shadow-sm">NEW</span><?php endif; ?>
                        <?php if ($isSale): ?><span class="badge bg-warning text-dark d-block shadow-sm">-<?= $salePercent ?>%</span><?php endif; ?>
                    </div>
                    <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>" 
                         class="img-fluid w-100 rounded-4 shadow-lg" 
                         style="max-height: 500px; object-fit: cover;"
                         alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>">
                </div>
            </div>

            <!-- COLUMN: PRODUCT INFO -->
            <div class="col-md-6">
                <div class="ps-md-3">
                    <div class="badge bg-primary-soft text-primary mb-2 py-2 px-3 rounded-pill bg-glass border border-primary-20">
                        <?= htmlspecialchars($product['TENPHANLOAI'] ?? 'Sản phẩm') ?>
                    </div>
                    
                    <h1 class="display-5 fw-bold text-white mb-3">
                        <?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>
                    </h1>

                    <div class="d-flex align-items-center mb-4">
                        <div class="text-warning me-2">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <span class="text-muted small">(4.8/5 - <?= rand(50, 200) ?> đánh giá)</span>
                    </div>

                    <div class="price-section mb-4 p-4 rounded-4 bg-glass border border-white-10 shadow-lg">
                        <div class="price-wrapper d-flex align-items-baseline gap-2">
                            <span class="fs-1 fw-bold text-primary"><?= number_format($donGia) ?> <span class="fs-4">đ</span></span>
                            <?php if ($isSale): ?>
                                <span class="text-muted text-decoration-line-through fs-5 opacity-75 ms-2"><?= number_format($giaGoc) ?> đ</span>
                            <?php endif; ?>
                        </div>
                        <div class="text-success small mt-2 d-flex align-items-center"><i class="bi bi-check-circle-fill me-2"></i> Trạng thái: Còn hàng tại hệ thống</div>
                    </div>

                    <div class="product-meta mb-4">
                        <p class="text-muted mb-2">
                            <strong class="text-white">Đơn vị:</strong> <?= htmlspecialchars($product['DONVITINH'] ?? '—') ?>
                        </p>
                        <p class="text-muted">
                            <strong class="text-white">Mô tả:</strong><br>
                            <span class="lh-lg"><?= nl2br(htmlspecialchars($product['MOTA'] ?? 'Chưa có mô tả chi tiết cho sản phẩm này.')) ?></span>
                        </p>
                    </div>

                    <div class="action-buttons d-flex gap-3">
                        <a href="index.php?controller=cart&action=add&id=<?= (int)$product['ID_HANGHOA'] ?>" 
                           class="btn btn-premium-glow btn-lg px-5 py-3 rounded-pill flex-grow-1 shadow-lg">
                            <i class="bi bi-cart-plus me-2 fs-5"></i>Thêm vào giỏ hàng
                        </a>
                        <button class="btn glass-button btn-lg rounded-circle p-3 shadow-sm border-white-10">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="trust-badges mt-5 pt-4 border-top border-white-10 row g-3">
                        <div class="col-4 text-center">
                            <i class="bi bi-shield-check text-primary fs-3 mb-2 d-block"></i>
                            <span class="small text-muted">Bảo hành 12 tháng</span>
                        </div>
                        <div class="col-4 text-center">
                            <i class="bi bi-truck text-primary fs-3 mb-2 d-block"></i>
                            <span class="small text-muted">Giao nội thành 2h</span>
                        </div>
                        <div class="col-4 text-center">
                            <i class="bi bi-arrow-repeat text-primary fs-3 mb-2 d-block"></i>
                            <span class="small text-muted">Đổi trả 7 ngày</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-danger bg-glass border-danger p-5 text-center mt-5 rounded-4">
            <i class="bi bi-exclamation-triangle display-1 d-block mb-3"></i>
            <h3 class="fw-bold">Sản phẩm không tồn tại</h3>
            <p>Sản phẩm bạn đang tìm kiếm có thể đã bị xóa hoặc không còn kinh doanh.</p>
            <a href="index.php?controller=product&action=list" class="btn btn-premium-glow px-5 rounded-pill mt-3">Quay lại cửa hàng</a>
        </div>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>