<?php
// ======================================================================
//  GIAO DIỆN HEADER + NAVBAR CLIENT
// ======================================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

// Lấy dữ liệu giỏ hàng
$cart  = $cart ?? ($_SESSION['cart'] ?? []);
$total = $total ?? ($_SESSION['cart_total'] ?? 0);
?>

<div class="container mt-5 mb-5 pt-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">

            <div class="d-flex align-items-center mb-4">
                <h1 class="fw-bold mb-0 text-white">Giỏ hàng của bạn</h1>
                <span class="badge bg-primary ms-3 rounded-pill"><?= count($cart) ?> sản phẩm</span>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible bg-glass border-white-10 fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible bg-glass border-white-10 fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>


            <?php if (empty($cart)): ?>
                <div class="card bg-glass border-white-10 text-center p-5 rounded-4 shadow-lg">
                    <div class="mb-4">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                    </div>
                    <h3 class="text-white fw-bold mb-3">Giỏ hàng trống</h3>
                    <p class="text-muted mb-4 fs-5">
                        Bạn chưa có sản phẩm nào trong giỏ hàng.<br>
                        Hãy bắt đầu khám phá các sản phẩm tuyệt vời của chúng tôi!
                    </p>
                    <a href="index.php?controller=product&action=list" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">
                        <i class="bi bi-shop me-2"></i> Đi mua sắm ngay
                    </a>
                </div>
            <?php else: ?>

                <div class="row g-4">
                    <!-- LEFT COLUMN: CART ITEMS -->
                    <div class="col-lg-8">
                        <div class="cart-items">
                            <?php foreach ($cart as $item): 
                                $subtotal = $item['subtotal'] ?? ($item['quantity'] * $item['price']);
                            ?>
                                <div class="card bg-glass border-white-10 mb-3 p-3 rounded-4 shadow-sm">
                                    <div class="row align-items-center g-3">
                                        <!-- Product Info -->
                                        <div class="col-md-6 col-sm-12">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="rounded-3 p-1" style="width: 70px; height: 70px; background: rgba(255,255,255,0.05); border: 1px solid var(--lp-border);">
                                                        <img src="upload/<?= htmlspecialchars($item['image'] ?? 'item-default.png') ?>" 
                                                             class="w-100 h-100 rounded-2" 
                                                             style="object-fit: cover;"
                                                             alt="<?= htmlspecialchars($item['name']) ?>">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold text-white fs-5">
                                                        <?= htmlspecialchars($item['name']) ?>
                                                    </h6>
                                                    <small class="text-muted d-block mb-1">Mã: <?= htmlspecialchars($item['id']) ?></small>
                                                    <small class="text-primary fw-bold"><?= number_format($item['price']) ?> đ</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quantity -->
                                        <div class="col-md-3 col-6 text-center text-md-start">
                                            <form method="post" action="index.php?controller=cart&action=update" class="d-inline-block">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                                                <div class="input-group input-group-sm bg-dark rounded-pill border-white-10 overflow-hidden" style="width: 110px;">
                                                    <input type="number" name="quantity" min="1" class="form-control bg-transparent border-0 text-white text-center fw-bold" value="<?= (int)$item['quantity'] ?>">
                                                    <button type="submit" class="btn btn-primary border-0 px-3">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Total & Action -->
                                        <div class="col-md-3 col-6 text-end">
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Thành tiền</small>
                                                <strong class="text-primary fs-5"><?= number_format($subtotal) ?> đ</strong>
                                            </div>
                                            <a href="index.php?controller=cart&action=remove&id=<?= htmlspecialchars($item['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" title="Xóa">
                                                <i class="bi bi-trash fs-5"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: TOTALS -->
                    <div class="col-lg-4">
                        <div class="card bg-glass border-white-10 p-4 rounded-4 shadow-lg sticky-top" style="top: 100px; z-index: 100;">
                            <h4 class="fw-bold text-white mb-4">Tổng đơn hàng</h4>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Tổng sản phẩm</span>
                                <span class="text-white"><?= count($cart) ?></span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Tạm tính</span>
                                <span class="text-white"><?= number_format($total) ?> đ</span>
                            </div>

                            <hr class="border-white-10 my-4">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fs-5 fw-bold text-white">Tổng cộng</span>
                                <span class="fs-3 fw-bold text-primary"><?= number_format($total) ?> đ</span>
                            </div>

                            <div class="d-grid gap-3">
                                <a href="index.php?controller=cart&action=checkout" class="btn btn-primary btn-lg rounded-pill py-3 shadow-lg">
                                    Tiếp tục thanh toán <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                                <a href="index.php?controller=product&action=list" class="btn btn-outline-light rounded-pill py-3 border-white-10">
                                    Tiếp tục mua sắm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>