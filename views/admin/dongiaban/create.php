<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- ===============================================================
        TIÊU ĐỀ TRANG
    ================================================================ -->
    <h2 class="mb-3">Thêm Đơn Giá Bán</h2>

    <!-- ===============================================================
        FORM THÊM ĐƠN GIÁ BÁN
        - Chọn hàng hóa
        - Nhập giá bán
        - Chọn ngày bắt đầu áp dụng
        - Chọn trạng thái áp dụng (checkbox)
    ================================================================ -->
    <form method="post" action="">

        <!-- CHỌN HÀNG HÓA -->
        <div class="mb-3">
            <label class="form-label">Hàng hóa</label>
            <select name="ID_HANGHOA" class="form-control" required>
                <option value="">-- Chọn hàng hóa --</option>

                <?php foreach ($hanghoas as $hh): ?>
                    <option value="<?= $hh['ID_HANGHOA'] ?>">
                        <?= htmlspecialchars($hh['TENHANGHOA']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- GIÁ TRỊ -->
        <div class="mb-3">
            <label class="form-label">Giá trị (VND)</label>
            <input
                type="number"
                name="GIATRI"
                class="form-control"
                min="0"
                required>
        </div>

        <!-- NGÀY BẮT ĐẦU -->
        <div class="mb-3">
            <label class="form-label">Ngày bắt đầu</label>
            <input
                type="datetime-local"
                name="NGAYBATDAU"
                class="form-control"
                value="<?= date('Y-m-d\TH:i') ?>"
                required>
        </div>

        <!-- TRẠNG THÁI ÁP DỤNG -->
        <div class="mb-3 form-check">
            <input
                type="checkbox"
                name="APDUNG"
                value="1"
                class="form-check-input"
                checked>
            <label class="form-check-label">Áp dụng</label>
        </div>

        <!-- NÚT SUBMIT -->
        <button class="btn btn-primary">Lưu</button>
        <a
            href="index.php?controller=dongiaban&action=index"
            class="btn btn-secondary">
            Hủy
        </a>

    </form>
</div>

<?php
// ======================================================================
//  FOOTER ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>