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
    <h2 class="mb-4">
        Chỉnh sửa Đơn Giá Bán #<?= htmlspecialchars($dongia['ID_DONGIA'] ?? '') ?>
    </h2>

    <!-- ===============================================================
        FORM CHỈNH SỬA ĐƠN GIÁ BÁN
        - Dữ liệu được nạp từ $dongia
        - Khi submit sẽ gửi POST về cùng action
    ================================================================ -->
    <form method="post" action="" class="card p-4 shadow-sm">

        <!-- Hàng hóa -->
        <div class="mb-3">
            <label class="form-label fw-bold">Hàng hóa</label>
            <select name="ID_HANGHOA" class="form-control" required>
                <option value="">-- Chọn hàng hóa --</option>

                <?php foreach ($hanghoas as $hh): ?>
                    <option
                        value="<?= $hh['ID_HANGHOA'] ?>"
                        <?= ($hh['ID_HANGHOA'] == ($dongia['ID_HANGHOA'] ?? '')) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($hh['TENHANGHOA']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- Giá trị -->
        <div class="mb-3">
            <label class="form-label fw-bold">Giá trị (VND)</label>
            <input
                type="number"
                name="GIATRI"
                class="form-control"
                value="<?= htmlspecialchars($dongia['GIATRI'] ?? '') ?>"
                required>
        </div>

        <!-- Ngày bắt đầu -->
        <div class="mb-3">
            <label class="form-label fw-bold">Ngày bắt đầu</label>
            <input
                type="datetime-local"
                name="NGAYBATDAU"
                class="form-control"
                value="<?= date('Y-m-d\TH:i', strtotime($dongia['NGAYBATDAU'] ?? date('Y-m-d H:i'))) ?>">
        </div>

        <!-- Trạng thái áp dụng -->
        <div class="mb-3 form-check">
            <input
                type="checkbox"
                name="APDUNG"
                value="1"
                class="form-check-input"
                <?= !empty($dongia['APDUNG']) ? 'checked' : '' ?>>
            <label class="form-check-label">Áp dụng</label>
        </div>

        <!-- Nút thao tác -->
        <div class="mt-3">
            <button class="btn btn-primary">Lưu</button>
            <a
                href="index.php?controller=dongiaban&action=index"
                class="btn btn-secondary">
                Hủy
            </a>
        </div>

    </form>

</div>

<?php
// ======================================================================
//  FOOTER ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>