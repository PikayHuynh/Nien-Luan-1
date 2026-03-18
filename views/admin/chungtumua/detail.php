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
    <h3>Chi tiết Chứng Từ Mua</h3>

    <!-- ===============================
         THÔNG TIN CHỨNG TỪ
    ================================== -->
    <div class="card mb-4">
        <div class="card-body">

            <p><strong>Mã chứng từ:</strong>
                <?= htmlspecialchars($ctm['MASOCT'] ?? 'Không có dữ liệu') ?>
            </p>

            <p><strong>Khách hàng:</strong>
                <?= htmlspecialchars($ctm['TEN_KH'] ?? $ctm['ID_KHACHHANG'] ?? 'Không rõ') ?>
            </p>

            <p><strong>Ngày phát sinh:</strong>
                <?= htmlspecialchars($ctm['NGAYPHATSINH'] ?? '') ?>
            </p>

            <p><strong>Tổng tiền hàng:</strong>
                <?= number_format($ctm['TONGTIENHANG'] ?? 0) ?> VND
            </p>

            <p><strong>Thuế (%):</strong>
                <?= htmlspecialchars($ctm['THUE'] ?? 0) ?>
            </p>

            <?php
            $tienThue = ($ctm['TONGTIENHANG'] ?? 0) * ($ctm['THUE'] ?? 0) / 100;
            $tongCong = ($ctm['TONGTIENHANG'] ?? 0) + $tienThue;
            ?>

            <p><strong>Tiền thuế:</strong>
                <?= number_format($tienThue) ?> VND
            </p>

            <p><strong>Tổng cộng:</strong>
                <?= number_format($tongCong) ?> VND
            </p>

        </div>
    </div>

    <!-- ===============================
         BẢNG CHI TIẾT HÀNG HÓA
    ================================== -->
    <h4>Chi tiết hàng hóa</h4>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Hàng hóa</th>
                <th>Giá mua</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($ctmct)): ?>
                <?php foreach ($ctmct as $ct): ?>
                    <tr>
                        <td><?= htmlspecialchars($ct['ID_HANGHOA'] ?? '') ?></td>
                        <td><?= number_format($ct['GIAMUA'] ?? 0) ?> VND</td>
                        <td><?= htmlspecialchars($ct['SOLUONG'] ?? 0) ?></td>
                        <td><?= number_format($ct['THANHTIEN'] ?? 0) ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Không có dữ liệu chi tiết hàng hóa
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>

    <!-- Nút quay lại -->
    <a href="index.php?controller=chungtumua&action=index" class="btn btn-secondary mt-3">
        Quay lại
    </a>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>