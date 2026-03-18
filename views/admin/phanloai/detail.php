<?php
// ===============================================================
//  HEADER + SIDEBAR ADMIN
// ===============================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <h2 class="mb-3">
        Chi tiết Phân Loại #<?= htmlspecialchars($phanloai['ID_PHANLOAI'] ?? '') ?>
    </h2>

    <!-- ==========================================================
		 THÔNG TIN PHÂN LOẠI
	========================================================== -->
    <div class="mb-3">
        <p><strong>Tên phân loại:</strong> <?= htmlspecialchars($phanloai['TENPHANLOAI'] ?? '') ?></p>

        <p><strong>Mô tả:</strong><br>
            <?= nl2br(htmlspecialchars($phanloai['MOTA'] ?? '')) ?>
        </p>

        <!-- Hình ảnh -->
        <?php if (!empty($phanloai['HINHANH'])): ?>
            <div class="mb-3">
                <strong>Hình ảnh:</strong><br>
                <img
                    src="upload/<?= htmlspecialchars($phanloai['HINHANH']) ?>"
                    alt="Hình phân loại"
                    style="max-width:300px; border-radius:6px;">
            </div>
        <?php else: ?>
            <p><strong>Hình ảnh:</strong> <span class="text-muted">Không có</span></p>
        <?php endif; ?>
    </div>

    <!-- ==========================================================
		NÚT THAO TÁC
	========================================================== -->
    <a
        href="index.php?controller=phanloai&action=edit&id=<?= $phanloai['ID_PHANLOAI'] ?>"
        class="btn btn-warning">
        Sửa
    </a>

    <a
        href="index.php?controller=phanloai&action=index"
        class="btn btn-secondary">
        Quay lại
    </a>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>