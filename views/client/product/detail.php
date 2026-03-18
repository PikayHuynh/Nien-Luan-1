<?php
// ======================================================================
// HEADER + NAVBAR (Client)
// ======================================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-4">

    <?php if (!empty($product)): ?>

        <div class="row">
            <!-- ===============================
                CỘT HÌNH ẢNH SẢN PHẨM
            ================================== -->
            <div class="col-md-5 mb-3 text-center">
                <div class="d-inline-block position-relative">
                    <?php
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
                    $isSale = $giaGoc > $donGia;
                    $salePercent = 0;
                    if ($isSale && $giaGoc > 0) {
                        $salePercent = round((($giaGoc - $donGia) / $giaGoc) * 100);
                    }
                    ?>
                    <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                        <?php if ($isHot): ?><span class="badge bg-danger mb-1 d-block">HOT</span><?php endif; ?>
                        <?php if ($isNew): ?><span class="badge bg-success mb-1 d-block">NEW</span><?php endif; ?>
                        <?php if ($isSale): ?><span
                                class="badge bg-warning text-dark d-block">-<?= $salePercent ?>%</span><?php endif; ?>
                    </div>
                    <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>"
                        style="width: 300px; height: 300px; object-fit: cover;" class="img-fluid rounded"
                        alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- ===============================
                CỘT THÔNG TIN SẢN PHẨM
            ================================== -->
        <div class="col-md-7">

            <!-- Tên sản phẩm -->
            <h2 class="fw-bold mb-3" style="color: #6610f2;">
                <?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>
            </h2>

            <!-- Phân loại -->
            <p class="text-muted mb-2">
                <strong>Phân loại:</strong>
                <?= htmlspecialchars($product['TENPHANLOAI'] ?? 'Không xác định') ?>
            </p>

            <!-- Mô tả -->
            <p class="mb-3">
                <?= nl2br(htmlspecialchars($product['MOTA'] ?? '')) ?>
            </p>

            <!-- Đơn vị -->
            <p class="mb-2">
                <strong>Đơn vị:</strong>
                <?= htmlspecialchars($product['DONVITINH'] ?? '—') ?>
            </p>

            <!-- Giá -->
            <p class="fs-4 fw-bold mb-4" style="color: #b02a37;">
                <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND
            </p>

            <!-- Nút thêm vào giỏ -->
            <a href="index.php?controller=cart&action=add&id=<?= (int) $product['ID_HANGHOA'] ?>"
                class="btn px-4 py-2 text-white shadow-sm" style="background-color: #6610f2; border-radius: 6px;">
                <i class="bi bi-cart-plus mb-1"></i> Thêm vào giỏ
            </a>
        </div>
    </div>

<?php else: ?>

    <!-- ===============================
            SẢN PHẨM KHÔNG TỒN TẠI
        ================================== -->
    <div class="alert alert-danger mt-4">
        <strong>Lỗi:</strong> Sản phẩm không tồn tại hoặc đã bị xóa.
    </div>

<?php endif; ?>

</div>

<?php
// FOOTER CLIENT
include ROOT . '/views/client/layouts/footer.php';
?>