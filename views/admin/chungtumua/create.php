<?php
// ===============================
//  HEADER + SIDEBAR ADMIN
// ===============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- ===============================
         TIÊU ĐỀ TRANG
    ================================== -->
    <h3>Tạo Chứng Từ Mua</h3>

    <!-- ===============================
         FORM TẠO CHỨNG TỪ MUA
         - Nhập mã số chứng từ
         - Ngày phát sinh
         - Khách hàng
         - Tổng tiền hàng
         - Thuế
    ================================== -->
    <form method="post" action="">

        <!-- Mã số chứng từ -->
        <div class="mb-3">
            <label class="form-label">Mã số chứng từ</label>
            <input type="text" name="MASOCT" class="form-control" value="<?= 'CTM-' . time() ?>">
        </div>

        <!-- Ngày phát sinh -->
        <div class="mb-3">
            <label class="form-label">Ngày phát sinh</label>
            <input type="datetime-local" name="NGAYPHATSINH" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
        </div>

        <!-- Khách hàng -->
        <div class="mb-3">
            <label class="form-label">Khách hàng</label>
            <select name="ID_KHACHHANG" class="form-control">
                <option value="">-- Chọn khách hàng --</option>

                <?php foreach ($khachHangList as $k): ?>
                    <option value="<?= htmlspecialchars($k['ID_KHACHHANG'] ?? $k['ID_KHACH_HANG']) ?>">
                        <!-- Tên khách hàng: ưu tiên TEN_KH, fallback TENKH hoặc TENPHU -->
                        <?= htmlspecialchars($k['TEN_KH'] ?? $k['TENKH'] ?? $k['TENPHU'] ?? 'Không rõ tên') ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- Tổng tiền hàng -->
        <div class="mb-3">
            <label class="form-label">Tổng tiền hàng</label>
            <input type="number" name="TONGTIENHANG" class="form-control" value="0">
        </div>

        <!-- Thuế -->
        <div class="mb-3">
            <label class="form-label">Thuế (%)</label>
            <input type="number" name="THUE" class="form-control" value="0">
        </div>

        <!-- Nút thao tác -->
        <button class="btn btn-primary">Tạo mới</button>
        <a href="index.php?controller=chungtumua&action=index" class="btn btn-secondary">
            Hủy
        </a>

    </form>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>