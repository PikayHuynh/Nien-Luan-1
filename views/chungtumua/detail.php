<?php include ROOT . '/views/layouts/header.php'; ?>
<?php include ROOT . '/views/layouts/sidebar.php'; ?>

<h3>Chi tiết Chứng Từ Mua</h3>
<p><strong>Mã số:</strong> <?= $ctm['MASOCT'] ?></p>
<p><strong>Khách hàng:</strong> <?= $ctm['ID_KHACHHANG'] ?></p>
<p><strong>Ngày phát sinh:</strong> <?= $ctm['NGAYPHATSINH'] ?></p>
<p><strong>Tổng tiền hàng:</strong> <?= $ctm['TONGTIENHANG'] ?></p>
<p><strong>Thuế:</strong> <?= $ctm['THUE'] ?></p>
<p><strong>Tổng cộng:</strong> <?= $ctm['TONGCONG'] ?></p>

<h4>Chi tiết hàng hóa</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID_HH</th>
            <th>Giá mua</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($ctmct as $ct): ?>
        <tr>
            <td><?= $ct['ID_HANGHOA'] ?></td>
            <td><?= $ct['GIAMUA'] ?></td>
            <td><?= $ct['SOLUONG'] ?></td>
            <td><?= $ct['THANHTIEN'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php?controller=chungtumua&action=index" class="btn btn-secondary">Quay lại</a>

<?php include ROOT . '/views/layouts/footer.php'; ?>
