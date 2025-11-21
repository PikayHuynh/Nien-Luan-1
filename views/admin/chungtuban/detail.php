<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
    <h3>Chi Tiết Chứng Từ Bán</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>ID:</strong> <?= $ct['ID_CTBAN'] ?></p>
            <p><strong>Mã chứng từ:</strong> <?= $ct['MASOCT'] ?></p>
            <p><strong>Ngày đặt hàng:</strong> <?= $ct['NGAYDATHANG'] ?></p>
            <p><strong>Khách hàng:</strong> <?= $khachHang['TEN_KH'] ?></p>
            <p><strong>Tổng tiền hàng:</strong> <?= number_format($ct['TONGTIENHANG']) ?> VND</p>
            <p><strong>Thuế (%):</strong> <?= $ct['THUE'] ?></p>
            <?php 
                $tienThue = $ct['TONGTIENHANG'] * $ct['THUE'] / 100;
                $tongCong = $ct['TONGTIENHANG'] + $tienThue;
            ?>
            <p><strong>Tiền thuế:</strong> <?= number_format($tienThue) ?> VND</p>
            <p><strong>Tổng cộng:</strong> <?= number_format($tongCong) ?> VND</p>
            <p><strong>Trạng thái:</strong> <?= $ct['TRANGTHAI'] ?></p>
            <p><strong>Ghi chú:</strong> <?= $ct['GHICHU'] ?></p>
        </div>
    </div>

    <h5>Chi tiết sản phẩm</h5>
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
            <?php foreach($ctChiTiet as $item): ?>
                <?php $hh = $hangHoaData[$item['ID_HANGHOA']] ?? []; ?>
                <tr>
                    <td><?= $hh['TENHANGHOA'] ?? 'Không tồn tại' ?></td>
                    <td><?= $item['SOLUONG'] ?></td>
                    <td><?= number_format($item['GIABAN'] ?? 0) ?> VND</td>
                    <td><?= number_format($item['THANHTIEN'] ?? 0) ?> VND</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php?controller=chungtuban&action=index" class="btn btn-secondary mt-3">Quay lại</a>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
