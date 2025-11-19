<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-4">
    <h3>Chi tiết đơn hàng</h3>

    <?php if (empty($order)): ?>
        <div class="alert alert-warning">Đơn hàng không tồn tại.</div>
    <?php else: ?>
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Mã chứng từ:</strong> <?= htmlspecialchars($order['MASOCT']) ?></p>
                <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($order['NGAYDATHANG']) ?></p>
                <p><strong>Tổng tiền:</strong> <?= number_format($order['TONGCONG'] ?? $order['TONGTIENHANG'] ?? 0) ?> VND</p>
                <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['TRANGTHAI']) ?></p>
            </div>
        </div>

        <h5>Chi tiết mặt hàng</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm (ID)</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php $sum = 0; ?>
                <?php foreach ($items as $it): ?>
                    <tr>
                        <td><?= htmlspecialchars($it['ID_HANGHOA']) ?></td>
                        <td><?= number_format($it['GIABAN'] ?? $it['GIABAN']) ?> VND</td>
                        <td><?= (int)($it['SOLUONG'] ?? 0) ?></td>
                        <td><?= number_format($it['THANHTIEN'] ?? ($it['GIABAN'] * ($it['SOLUONG'] ?? 0))) ?> VND</td>
                    </tr>
                    <?php $sum += ($it['THANHTIEN'] ?? (($it['GIABAN'] ?? 0) * ($it['SOLUONG'] ?? 0))); ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Tổng cộng: <?= number_format($sum) ?> VND</h4>

        <a href="index.php?controller=user&action=orders" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>