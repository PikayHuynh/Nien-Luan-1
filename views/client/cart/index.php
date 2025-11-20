<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="mb-4">Giỏ hàng của bạn</h1>

            <?php if(empty($cart) || count($cart) == 0): ?>
                <div class="card border-0 shadow-sm text-center p-5">
                    <h5 class="text-muted mb-3">Giỏ hàng trống</h5>
                    <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy bắt đầu mua sắm ngay!</p>
                    <a href="index.php?controller=product&action=list" class="btn btn-primary btn-lg">Xem sản phẩm</a>
                </div>
            <?php else: ?>
                <!-- Cart items cards -->
                <div class="cart-items mb-4">
                    <?php $total = $total ?? ($_SESSION['cart_total'] ?? 0); ?>
                    <?php foreach($cart as $item): ?>
                        <?php $subtotal = $item['subtotal'] ?? ($item['quantity'] * $item['price']); ?>
                        <div class="card border-0 shadow-sm mb-3 p-3">
                            <div class="row align-items-center g-3">
                                <div class="col-md-5">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold"><?= htmlspecialchars($item['name']) ?></h6>
                                            <small class="text-muted">Mã: <?= $item['id'] ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block mb-1">Đơn giá</small>
                                    <strong><?= number_format($item['price']) ?> VND</strong>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block mb-1">Số lượng</small>
                                    <form method="post" action="index.php?controller=cart&action=update" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <div class="input-group input-group-sm" style="width: 90px;">
                                            <input type="number" name="quantity" value="<?= (int)$item['quantity'] ?>" min="1" class="form-control">
                                            <button type="submit" class="btn btn-outline-secondary">✓</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted d-block mb-1">Thành tiền</small>
                                    <strong class="text-danger"><?= number_format($subtotal) ?> VND</strong>
                                </div>
                                <div class="col-md-1 text-end">
                                    <a href="index.php?controller=cart&action=remove&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" title="Xóa">✕</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Summary card -->
                <div class="card border-0 shadow-sm p-4 mb-4" style="background: linear-gradient(135deg, rgba(176, 139, 255, 0.06), rgba(111, 86, 183, 0.04));">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Tổng số sản phẩm:</span>
                        <strong><?= count($cart) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Tổng cộng:</span>
                        <h4 class="mb-0" style="color: var(--lp-primary-700);">₫ <?= number_format($total) ?></h4>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="d-grid gap-2 d-md-flex">
                    <a href="index.php?controller=cart&action=checkout" class="btn btn-primary btn-lg">Thanh toán</a>
                    <a href="index.php?controller=product&action=list" class="btn btn-outline-secondary btn-lg">Tiếp tục mua sắm</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
