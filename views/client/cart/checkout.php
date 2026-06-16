<?php
// ======================================================================
//  GIAO DIỆN HEADER + NAVBAR CLIENT
// ======================================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

// Lấy dữ liệu từ session
$cart  = $_SESSION['cart'] ?? [];
$total = $_SESSION['cart_total'] ?? 0;
?>

<div class="container mt-5 mb-5 pt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            <!-- PAGE TITLE -->
            <div class="d-flex align-items-center mb-5">
                <a href="index.php?controller=cart&action=index" class="btn btn-outline-light rounded-circle me-3 border-white-10 p-2">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1 class="fw-bold mb-0 text-white">Xác nhận đơn hàng</h1>
            </div>

            <!-- ERROR NOTIFICATION -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger bg-glass border-white-10 alert-dismissible fade show mb-4 rounded-4 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Lỗi:</strong> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-toggle="alert"></button>
                </div>
            <?php endif; ?>


            <?php if (empty($cart)): ?>
                <div class="card bg-glass border-white-10 text-center p-5 rounded-4 shadow-lg">
                    <div class="mb-4">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                    </div>
                    <h3 class="text-white fw-bold mb-3">Giỏ hàng trống</h3>
                    <p class="text-muted mb-4 fs-5">Không có sản phẩm để thanh toán.</p>
                    <a href="index.php?controller=product&action=list" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">
                        <i class="bi bi-shop me-2"></i> Tiếp tục mua sắm
                    </a>
                </div>

            <?php else: ?>

                <!-- ORDER SUMMARY TABLE -->
                <div class="card bg-glass border-white-10 mb-4 rounded-4 shadow-lg overflow-hidden">
                    <div class="card-header border-bottom border-white-10 bg-white-5 py-3">
                        <h5 class="mb-0 fw-bold text-white"><i class="bi bi-list-check me-2 text-primary"></i>Chi tiết đơn hàng</h5>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0" style="--bs-table-bg: transparent;">
                                <thead class="text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4 py-3 border-white-10">Sản phẩm</th>
                                        <th class="text-center py-3 border-white-10">Số lượng</th>
                                        <th class="text-end py-3 border-white-10">Đơn giá</th>
                                        <th class="text-end pe-4 py-3 border-white-10">Thành tiền</th>
                                    </tr>
                                </thead>

                                <tbody class="border-top-0">
                                    <?php foreach ($cart as $it): 
                                        $itSubtotal = $it['subtotal'] ?? ($it['price'] * $it['quantity']);
                                    ?>
                                        <tr>
                                            <td class="ps-4 py-3 border-white-10">
                                                <div class="fw-bold text-white"><?= htmlspecialchars($it['name']) ?></div>
                                                <small class="text-muted">Mã: <?= htmlspecialchars($it['id']) ?></small>
                                            </td>

                                            <td class="text-center py-3 border-white-10 align-middle">
                                                <span class="badge bg-dark border border-white-10 rounded-pill px-3 py-2"><?= (int)$it['quantity'] ?></span>
                                            </td>

                                            <td class="text-end py-3 border-white-10 align-middle">
                                                <?= number_format($it['price']) ?> đ
                                            </td>

                                            <td class="text-end pe-4 py-3 border-white-10 align-middle fw-bold text-primary">
                                                <?= number_format($itSubtotal) ?> đ
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TOTAL CALCULATION -->
                <div class="card bg-glass border-white-10 p-4 mb-4 rounded-4 shadow-lg">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h5 class="mb-1 fw-bold text-white">Tổng cộng thanh toán</h5>
                            <p class="text-muted small mb-0">Đã bao gồm các loại thuế và phí vận chuyển cơ bản.</p>
                        </div>

                        <div class="col-md-5 text-end">
                            <div class="text-primary display-5 fw-bold">
                                <?= number_format($total) ?> <span class="fs-4">đ</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IMPORTANT NOTES -->
                <div class="alert alert-primary bg-glass border-primary-20 text-primary-20 p-3 rounded-4 mb-5 border-white-10" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong class="text-white d-block mb-1">Kiểm tra thông tin</strong>
                            <p class="mb-0 small text-muted">Bằng việc nhấn "Xác nhận", bạn đồng ý với các điều khoản mua hàng và chính sách bảo mật của Pikay Shop. Vui lòng đảm bảo các thông tin sản phẩm và số lượng là chính xác.</p>
                        </div>
                    </div>
                </div>

                <!-- ACTIONS -->
                <form method="post" action="index.php?controller=cart&action=checkout">
                    <div class="d-grid gap-3 d-md-flex justify-content-md-between">
                        <a href="index.php?controller=cart&action=index" class="btn btn-outline-light btn-lg px-4 rounded-pill border-white-10">
                            <i class="bi bi-arrow-left me-2"></i> Quay lại giỏ hàng
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg py-3">
                            <i class="bi bi-shield-lock-fill me-2"></i> Xác nhận thanh toán
                        </button>
                    </div>
                </form>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>