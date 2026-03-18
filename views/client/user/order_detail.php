<?php
// =====================================================
// HEADER + NAVBAR CLIENT
// =====================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

// Kiểm tra và đặt biến $isPurchase nếu chưa tồn tại (giả định là false nếu không có)
$isPurchase = $isPurchase ?? false;
?>

<div class="container mt-4" style="max-width: 900px;">

    <h3 class="mb-4 fw-bold">Chi tiết <?= $isPurchase ? 'Chứng từ Nhập' : 'Đơn hàng' ?></h3>

    <?php if (empty($order)): ?>

        <div class="alert alert-warning">
            <?= $isPurchase ? 'Chứng từ' : 'Đơn hàng' ?> không tồn tại hoặc đã bị xóa.
        </div>

    <?php else: ?>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                Thông tin chung
            </div>

            <div class="card-body">
                <?php
                // Xác định tên cột ngày dựa trên loại chứng từ
                $dateField = $isPurchase ? 'NGAYPHATSINH' : 'NGAYDATHANG';
                ?>

                <p><strong>Mã chứng từ:</strong>
                    <?= htmlspecialchars((string)($order['MASOCT'] ?? 'N/A')) ?>
                </p>

                <p><strong>Ngày <?= $isPurchase ? 'phát sinh' : 'đặt' ?>:</strong>
                    <?= htmlspecialchars((string)($order[$dateField] ?? '')) ?>
                </p>

                <?php if (isset($order['TIENTHUE']) || isset($order['THUE'])): ?>
                    <p><strong>Thuế (<?= (float)($order['THUE'] ?? 0) ?>%):</strong>
                        <?= number_format((float)($order['TIENTHUE'] ?? 0)) ?> VND
                    </p>
                <?php endif; ?>

                <p><strong>Tổng cộng:</strong>
                    <span class="text-danger fw-bold">
                        <?= number_format((float)($order['TONGCONG'] ?? $order['TONGTIENHANG'] ?? 0)) ?> VND
                    </span>
                </p>

                <?php if (!$isPurchase): // Chỉ hiển thị Trạng thái cho Chứng từ Bán (Đơn hàng User) 
                ?>
                    <p><strong>Trạng thái:</strong>
                        <?= htmlspecialchars((string)($order['TRANGTHAI'] ?? 'Chưa xác định')) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                Chi tiết mặt hàng
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th>Sản phẩm (ID)</th>
                            <th>Đơn giá <?= $isPurchase ? 'Mua' : 'Bán' ?></th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sum = 0; ?>
                        <?php foreach ($items as $it): ?>

                            <?php
                            // Xác định cột giá dựa trên loại chứng từ
                            $priceField = $isPurchase ? 'GIAMUA' : 'GIABAN';
                            $unitPrice = (float)($it[$priceField] ?? 0);

                            // Tính thành tiền an toàn
                            $thanhtien = (float)($it['THANHTIEN'] ??
                                ($unitPrice * (float)($it['SOLUONG'] ?? 0)));
                            $sum += $thanhtien;
                            ?>

                            <tr>
                                <td><?= htmlspecialchars((string)($it['ID_HANGHOA'] ?? 'N/A')) ?></td>
                                <td><?= number_format($unitPrice) ?> VND</td>
                                <td><?= (int)($it['SOLUONG'] ?? 0) ?></td>
                                <td class="fw-bold text-danger"><?= number_format($thanhtien) ?> VND</td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-end mb-4">
            <h4 class="fw-bold">
                Tổng tiền hàng + Thuế: <span class="text-danger">
                    <?= number_format((float)($order['TONGCONG'] ?? $order['TONGTIENHANG'] ?? 0)) ?> VND
                </span>
            </h4>
        </div>

        <a href="index.php?controller=user&action=orders" class="btn btn-primary">
            ⟵ Quay lại danh sách <?= $isPurchase ? 'chứng từ' : 'đơn hàng' ?>
        </a>

    <?php endif; ?>

</div>

<?php
// FOOTER
include ROOT . '/views/client/layouts/footer.php';
?>