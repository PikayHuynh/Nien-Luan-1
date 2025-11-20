<?php include ROOT . '/views/client/layouts/header.php'; ?>
<?php include ROOT . '/views/client/layouts/navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h1 class="mb-4">Xác nhận thanh toán</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi:</strong> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php $cart = $_SESSION['cart'] ?? []; $total = $_SESSION['cart_total'] ?? 0; ?>
            <?php if (empty($cart)): ?>
                <div class="card border-0 shadow-sm text-center p-5">
                    <h5 class="text-muted mb-3">Giỏ hàng trống</h5>
                    <p class="text-muted mb-4">Không có sản phẩm để thanh toán.</p>
                    <a href="index.php?controller=product&action=list" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <!-- Order summary -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Chi tiết đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead style="background: rgba(176, 139, 255, 0.06);">
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-end">Số lượng</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $it): ?>
                                        <tr>
                                            <td>
                                                <strong><?= htmlspecialchars($it['name']) ?></strong>
                                            </td>
                                            <td class="text-end"><?= (int)$it['quantity'] ?></td>
                                            <td class="text-end"><?= number_format($it['price']) ?> VND</td>
                                            <td class="text-end fw-bold"><?= number_format($it['subtotal'] ?? ($it['price'] * $it['quantity'])) ?> VND</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Total summary -->
                <div class="card border-0 shadow-sm p-4 mb-4" style="background: linear-gradient(135deg, rgba(176, 139, 255, 0.1), rgba(111, 86, 183, 0.06));">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-0">Tổng cộng</h5>
                        </div>
                        <div class="col-md-4 text-end">
                            <h3 class="mb-0" style="color: var(--lp-primary-700);">₫ <?= number_format($total) ?></h3>
                        </div>
                    </div>
                </div>

                <!-- Confirmation info -->
                <div class="alert alert-info border-0" role="alert">
                    <strong>Lưu ý:</strong> Vui lòng kiểm tra lại thông tin đơn hàng trước khi xác nhận thanh toán.
                </div>

                <!-- Action buttons -->
                <form method="post" action="index.php?controller=cart&action=checkout" class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-success btn-lg">Xác nhận thanh toán</button>
                    <a href="index.php?controller=cart&action=index" class="btn btn-outline-secondary btn-lg">Quay lại giỏ hàng</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
