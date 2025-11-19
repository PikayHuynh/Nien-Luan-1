<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-4">
    <h2>Thanh toán</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <p>Kiểm tra lại giỏ hàng trước khi xác nhận.</p>

    <?php $cart = $_SESSION['cart'] ?? []; $total = $_SESSION['cart_total'] ?? 0; ?>
    <?php if (empty($cart)): ?>
        <p>Giỏ hàng trống.</p>
        <a href="index.php?controller=product&action=list" class="btn btn-primary">Tiếp tục mua sắm</a>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $it): ?>
                    <tr>
                        <td><?= htmlspecialchars($it['name']) ?></td>
                        <td><?= (int)$it['quantity'] ?></td>
                        <td><?= number_format($it['price']) ?> VND</td>
                        <td><?= number_format($it['subtotal'] ?? ($it['price'] * $it['quantity'])) ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Tổng: <?= number_format($total) ?> VND</h4>

        <form method="post" action="index.php?controller=cart&action=checkout">
            <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
            <a href="index.php?controller=cart&action=index" class="btn btn-secondary">Quay lại giỏ hàng</a>
        </form>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
