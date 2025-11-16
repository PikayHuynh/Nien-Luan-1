<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-4">
    <h2>Giỏ hàng của bạn</h2>

    <?php if(empty($cart) || count($cart) == 0): ?>
        <p>Giỏ hàng trống.</p>
        <a href="index.php?controller=product&action=list" class="btn btn-primary">Xem sản phẩm</a>
    <?php else: ?>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach($cart as $item): ?>
                    <?php $subtotal = $item['quantity'] * $item['price']; ?>
                    <?php $total += $subtotal; ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price']) ?> VND</td>
                        <td><?= number_format($subtotal) ?> VND</td>
                        <td>
                            <a href="index.php?controller=cart&action=remove&id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Tổng cộng: <?= number_format($total) ?> VND</h4>
        <a href="index.php?controller=cart&action=checkout" class="btn btn-success mt-3">Thanh toán</a>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
