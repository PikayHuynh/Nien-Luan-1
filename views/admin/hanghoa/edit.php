<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <div class="row">
        <!-- ===============================================================
            FORM CHỈNH SỬA HÀNG HÓA
        ================================================================ -->
        <div class="col-lg-8">

            <h2 class="mb-4">
                Chỉnh sửa Hàng Hóa
                #<?= htmlspecialchars($hanghoa['ID_HANGHOA'] ?? '') ?>
            </h2>

            <!-- ===========================================================
                FORM UPDATE HÀNG HÓA
            ============================================================ -->
            <form method="post" action="" enctype="multipart/form-data">

                <!-- Tên hàng hóa -->
                <div class="mb-3">
                    <label class="form-label">Tên hàng hóa</label>
                    <input type="text" name="TENHANGHOA" class="form-control"
                        value="<?= htmlspecialchars($hanghoa['TENHANGHOA'] ?? '') ?>" required>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="MOTA" class="form-control"
                        rows="4"><?= htmlspecialchars($hanghoa['MOTA'] ?? '') ?></textarea>
                </div>

                <!-- Đơn vị tính -->
                <div class="mb-3">
                    <label class="form-label">Đơn vị tính</label>
                    <input type="text" name="DONVITINH" class="form-control"
                        value="<?= htmlspecialchars($hanghoa['DONVITINH'] ?? '') ?>">
                </div>

                <!-- Phân loại -->
                <div class="mb-3">
                    <label class="form-label">Phân loại</label>
                    <select name="ID_PHANLOAI" class="form-control">
                        <option value="">-- Chọn phân loại --</option>

                        <?php foreach ($phanloaiList as $p): ?>
                            <option value="<?= $p['ID_PHANLOAI'] ?>" <?= ($p['ID_PHANLOAI'] == ($hanghoa['ID_PHANLOAI'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['TENPHANLOAI']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Giá gốc (Dùng để tính Sale) -->
                <div class="mb-3">
                    <label class="form-label">Giá gốc (VND)</label>
                    <input type="number" name="GIAGOC" class="form-control"
                        value="<?= htmlspecialchars($hanghoa['GIAGOC'] ?? 0) ?>"
                        placeholder="Nhập giá gốc để hiển thị nhãn SALE nếu > giá bán">
                </div>

                <!-- Ngày tạo (Dùng để tính nhãn NEW) -->
                <div class="mb-3">
                    <label class="form-label">Ngày tạo</label>
                    <input type="datetime-local" name="NGAYTAO" class="form-control"
                        value="<?= !empty($hanghoa['NGAYTAO']) ? date('Y-m-d\TH:i', strtotime($hanghoa['NGAYTAO'])) : date('Y-m-d\TH:i') ?>">
                    <div class="form-text">Nhãn NEW sẽ hiển thị trong 3 ngày kể từ ngày này.</div>
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>

                    <?php if (!empty($hanghoa['HINHANH'])): ?>
                        <div class="mb-2">
                            <img src="upload/<?= htmlspecialchars($hanghoa['HINHANH']) ?>"
                                style="max-width: 200px; border-radius:6px; border:1px solid #ccc;">
                        </div>
                    <?php endif; ?>

                    <input type="file" name="HINHANH" class="form-control">
                </div>

                <!-- Nút submit -->
                <button class="btn btn-primary">Lưu</button>

                <!-- Quay lại -->
                <a href="index.php?controller=hanghoa&action=index" class="btn btn-secondary">
                    Hủy
                </a>

            </form>
        </div>

        <!-- ===============================================================
            KHUNG HƯỚNG DẪN (nằm bên phải)
        ================================================================ -->
        <div class="col-lg-4 d-none d-lg-block">
            <?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
        </div>
    </div>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>