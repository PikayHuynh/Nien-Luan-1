<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-4">
    <h3>Đơn hàng của tôi</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã chứng từ</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order): ?>
                <tr>
                    <td><?= $order['MASOCT'] ?></td>
                    <td><?= $order['NGAYDATHANG'] ?></td>
                    <td><?= number_format($order['TONGCONG']) ?> VND</td>
                    <td><?= $order['TRANGTHAI'] ?></td>
                    <td>
                        <a href="index.php?controller=user&action=orderDetail&id=<?= $order['ID_CTBAN'] ?>" class="btn btn-sm btn-info">Xem</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
