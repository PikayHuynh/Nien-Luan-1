<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

$isPurchase = $isPurchase ?? false;
$dateField = $isPurchase ? 'NGAYPHATSINH' : 'NGAYDATHANG';
?>

<div class="container mt-5 mb-5 pt-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            <div class="d-flex align-items-center mb-5">
                <a href="index.php?controller=user&action=orders" class="btn btn-outline-light rounded-circle me-3 border-white-10 p-2">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0 text-white">Chi tiết <?= $isPurchase ? 'chứng từ nhập' : 'đơn hàng' ?></h2>
            </div>

            <?php if (empty($order)): ?>
                <div class="alert alert-warning bg-glass border-white-10 text-warning rounded-4 p-4 shadow-sm">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= $isPurchase ? 'Chứng từ' : 'Đơn hàng' ?> không tồn tại hoặc đã bị xóa.
                </div>
            <?php else: ?>

                <div class="row g-4 mb-4">
                    <!-- Order Info Card -->
                    <div class="col-md-6">
                        <div class="card bg-glass border-white-10 rounded-4 p-4 h-100 shadow-lg">
                            <h5 class="fw-bold text-white mb-4"><i class="bi bi-info-circle me-2 text-primary"></i>Thông tin chung</h5>
                            
                            <div class="mb-3 d-flex justify-content-between">
                                <span class="text-muted">Mã chứng từ:</span>
                                <span class="text-white fw-bold"><?= htmlspecialchars((string)($order['MASOCT'] ?? 'N/A')) ?></span>
                            </div>
                            
                            <div class="mb-3 d-flex justify-content-between">
                                <span class="text-muted">Ngày <?= $isPurchase ? 'phát sinh' : 'đặt' ?>:</span>
                                <span class="text-white"><?= htmlspecialchars((string)($order[$dateField] ?? '')) ?></span>
                            </div>

                            <?php if (isset($order['TIENTHUE']) || isset($order['THUE'])): ?>
                                <div class="mb-3 d-flex justify-content-between">
                                    <span class="text-muted">Thuế (<?= (float)($order['THUE'] ?? 0) ?>%):</span>
                                    <span class="text-white"><?= number_format((float)($order['TIENTHUE'] ?? 0)) ?> đ</span>
                                </div>
                            <?php endif; ?>

                            <hr class="border-white-10 my-3">

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Tổng thanh toán:</span>
                                <span class="text-primary fs-3 fw-bold">
                                    <?= number_format((float)($order['TONGCONG'] ?? $order['TONGTIENHANG'] ?? 0)) ?> đ
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Status / Extra Info Card -->
                    <div class="col-md-6">
                        <div class="card bg-glass border-white-10 rounded-4 p-4 h-100 shadow-lg">
                            <h5 class="fw-bold text-white mb-4"><i class="bi bi-truck me-2 text-primary"></i>Trạng thái & Vận chuyển</h5>
                            
                            <?php if (!$isPurchase): ?>
                                <div class="mb-4">
                                    <label class="text-muted small text-uppercase fw-bold d-block mb-2">Trạng thái hiện tại</label>
                                    <span class="badge bg-primary rounded-pill px-4 py-2 fs-6">
                                        <?= htmlspecialchars((string)($order['TRANGTHAI'] ?? 'Đang xử lý')) ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <div class="p-3 rounded-3 bg-dark-soft border border-white-5">
                                <div class="d-flex mb-2">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    <span class="text-white small"><?= htmlspecialchars($user['DIACHI'] ?? 'Địa chỉ mặc định') ?></span>
                                </div>
                                <div class="d-flex">
                                    <i class="bi bi-telephone text-primary me-2"></i>
                                    <span class="text-white small"><?= htmlspecialchars($user['SODIENTHOAI'] ?? 'SĐT mặc định') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="card bg-glass border-white-10 rounded-4 shadow-lg overflow-hidden mb-5">
                    <div class="card-header border-bottom border-white-10 bg-white-5 py-3 px-4">
                        <h5 class="mb-0 fw-bold text-white">Danh sách mặt hàng</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0" style="--bs-table-bg: transparent;">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Sản phẩm (ID)</th>
                                    <th class="text-end py-3">Đơn giá <?= $isPurchase ? 'mua' : 'bán' ?></th>
                                    <th class="text-center py-3">Số lượng</th>
                                    <th class="text-end pe-4 py-3">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $it): 
                                    $priceField = $isPurchase ? 'GIAMUA' : 'GIABAN';
                                    $unitPrice = (float)($it[$priceField] ?? 0);
                                    $thanhtien = (float)($it['THANHTIEN'] ?? ($unitPrice * (float)($it['SOLUONG'] ?? 0)));
                                ?>
                                    <tr class="border-bottom border-white-5 align-middle">
                                        <td class="ps-4 py-3">
                                            <span class="text-white fw-bold">#<?= htmlspecialchars((string)($it['ID_HANGHOA'] ?? 'N/A')) ?></span>
                                        </td>
                                        <td class="text-end py-3"><?= number_format($unitPrice) ?> đ</td>
                                        <td class="text-center py-3">
                                            <span class="badge bg-dark border border-white-10 rounded-pill px-3"><?= (int)($it['SOLUONG'] ?? 0) ?></span>
                                        </td>
                                        <td class="text-end pe-4 py-3 fw-bold text-primary"><?= number_format($thanhtien) ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center">
                    <a href="index.php?controller=user&action=orders" class="btn btn-outline-light rounded-pill px-5 border-white-10">
                        <i class="bi bi-arrow-left me-2"></i> Quay lại danh sách
                    </a>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>