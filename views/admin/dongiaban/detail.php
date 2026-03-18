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
        Chi tiết Đơn Giá #<?= htmlspecialchars($dongia['ID_DONGIA'] ?? '') ?>
    </h2>

    <!-- ===============================================================
         THÔNG TIN CHI TIẾT ĐƠN GIÁ
    ================================================================ -->
    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Tên hàng hóa -->
            <p>
                <strong>Hàng hóa:</strong>
                <?= htmlspecialchars($dongia['TENHANGHOA'] ?? 'Không xác định') ?>
            </p>

            <!-- Giá trị -->
            <p>
                <strong>Giá trị:</strong>
                <?= number_format($dongia['GIATRI'] ?? 0, 0, ',', '.') ?> VND
            </p>

            <!-- Ngày bắt đầu -->
            <p>
                <strong>Ngày bắt đầu:</strong>
                <?= htmlspecialchars($dongia['NGAYBATDAU'] ?? '') ?>
            </p>

            <!-- Trạng thái áp dụng -->
            <p>
                <strong>Áp dụng:</strong>
                <?= !empty($dongia['APDUNG']) ? '<span class="text-success">Có</span>' : '<span class="text-danger">Không</span>' ?>
            </p>

        </div>
    </div>

    <!-- ===============================================================
        NÚT THAO TÁC
    ================================================================ -->
    <div class="mt-3">
        <a
            href="index.php?controller=dongiaban&action=edit&id=<?= $dongia['ID_DONGIA'] ?>"
            class="btn btn-warning">
            Sửa
        </a>

        <a
            href="index.php?controller=dongiaban&action=index"
            class="btn btn-secondary">
            Quay lại
        </a>
    </div>

</div>

<?php
// ======================================================================
//  FOOTER ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>