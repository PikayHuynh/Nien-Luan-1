<?php
// ==============================
// Giao diện Header + Sidebar
// ==============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- ========================================
         TIÊU ĐỀ TRANG
    ========================================== -->
    <h3 class="mb-3">Chi Tiết Chứng Từ Bán</h3>

    <!-- ========================================
         THÔNG TIN CHUNG CỦA CHỨNG TỪ BÁN
    ========================================== -->
    <div class="card mb-4">
        <div class="card-body">

            <!-- ID chứng từ -->
            <p><strong>ID:</strong> <?= $ct['ID_CTBAN'] ?></p>

            <!-- Mã số chứng từ -->
            <p><strong>Mã chứng từ:</strong> <?= $ct['MASOCT'] ?></p>

            <!-- Ngày đặt hàng -->
            <p><strong>Ngày đặt hàng:</strong> <?= $ct['NGAYDATHANG'] ?></p>

            <!-- Tên khách hàng -->
            <p><strong>Khách hàng:</strong> <?= $khachHang['TEN_KH'] ?></p>

            <!-- Tổng tiền hàng (chưa thuế) -->
            <p><strong>Tổng tiền hàng:</strong> <?= number_format($ct['TONGTIENHANG']) ?> VND</p>

            <!-- Thuế suất -->
            <p><strong>Thuế (%):</strong> <?= $ct['THUE'] ?></p>

            <?php
            // Tính tiền thuế & tổng cộng
            $tienThue = $ct['TONGTIENHANG'] * $ct['THUE'] / 100;
            $tongCong = $ct['TONGTIENHANG'] + $tienThue;
            ?>

            <!-- Tiền thuế -->
            <p><strong>Tiền thuế:</strong> <?= number_format($tienThue) ?> VND</p>

            <!-- Tổng cộng -->
            <p><strong>Tổng cộng:</strong> <?= number_format($tongCong) ?> VND</p>

            <!-- Trạng thái đơn hàng -->
            <p><strong>Trạng thái:</strong> <?= $ct['TRANGTHAI'] ?></p>

            <!-- Ghi chú -->
            <p><strong>Ghi chú:</strong> <?= $ct['GHICHU'] ?></p>
        </div>
    </div>

    <!-- ========================================
         BẢNG CHI TIẾT SẢN PHẨM
    ========================================== -->
    <h5 class="mb-3">Chi tiết sản phẩm</h5>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Hàng hóa</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($ctChiTiet as $item): ?>
                <?php
                // Lấy thông tin hàng hóa từ danh sách
                $hh = $hangHoaData[$item['ID_HANGHOA']] ?? [];
                ?>
                <tr>
                    <td><?= $hh['TENHANGHOA'] ?? 'Không tồn tại' ?></td>
                    <td><?= $item['SOLUONG'] ?></td>
                    <td><?= number_format($item['GIABAN'] ?? 0) ?> VND</td>
                    <td><?= number_format($item['THANHTIEN'] ?? 0) ?> VND</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Nút quay lại -->
    <a href="index.php?controller=chungtuban&action=index" class="btn btn-secondary mt-3">
        Quay lại
    </a>

</div>

<?php
// ==============================
// Giao diện Footer
// ==============================
include ROOT . '/views/admin/layouts/footer.php';
?>