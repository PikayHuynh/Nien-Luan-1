<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- TIÊU ĐỀ -->
    <h2 class="mb-3">
        Chỉnh sửa Thuộc Tính #<?= htmlspecialchars($thuoctinh['ID_THUOCTINH'] ?? '') ?>
    </h2>

    <!-- ===============================================================
         FORM CHỈNH SỬA THUỘC TÍNH
    ================================================================ -->
    <form method="post" action="" enctype="multipart/form-data">

        <!-- Tên thuộc tính -->
        <div class="mb-3">
            <label class="form-label">Tên thuộc tính</label>
            <input
                type="text"
                name="TEN"
                class="form-control"
                value="<?= htmlspecialchars($thuoctinh['TEN'] ?? '') ?>"
                required>
        </div>

        <!-- Giá trị thuộc tính -->
        <div class="mb-3">
            <label class="form-label">Giá trị</label>
            <input
                type="text"
                name="GIATRI"
                class="form-control"
                value="<?= htmlspecialchars($thuoctinh['GIATRI'] ?? '') ?>">
        </div>

        <!-- Chọn hàng hóa -->
        <div class="mb-3">
            <label class="form-label">Hàng hóa</label>

            <select name="ID_HANGHOA" class="form-control">
                <option value="">-- Chọn hàng hóa --</option>

                <?php foreach ($hanghoas as $hh): ?>
                    <option
                        value="<?= $hh['ID_HANGHOA'] ?>"
                        <?= ($hh['ID_HANGHOA'] == ($thuoctinh['ID_HANGHOA'] ?? '')) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($hh['TENHANGHOA']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- Hình ảnh -->
        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>

            <?php if (!empty($thuoctinh['HINHANH'])): ?>
                <div class="mb-2">
                    <img
                        src="upload/<?= htmlspecialchars($thuoctinh['HINHANH']) ?>"
                        style="max-width:200px; border-radius:6px;">
                </div>
            <?php endif; ?>

            <input type="file" name="HINHANH" class="form-control">
        </div>

        <!-- Nút Lưu + Hủy -->
        <button class="btn btn-primary">Lưu</button>
        <a href="index.php?controller=thuoctinh&action=index" class="btn btn-secondary">Hủy</a>

    </form>
</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>