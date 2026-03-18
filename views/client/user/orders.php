<?php
// =====================================================
// HEADER + NAVBAR
// =====================================================
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-4" style="max-width: 900px;">

    <h3 class="mb-4 fw-bold">
        <?= $isPurchase ? 'Danh sách Chứng từ Nhập hàng' : 'Đơn hàng của tôi' ?>
    </h3>

    <?php if (empty($orders)): ?>

        <div class="alert alert-info text-center py-4">
            <?= $isPurchase ? 'Không có chứng từ nhập hàng nào.' : 'Bạn chưa có đơn hàng nào.' ?>
        </div>

    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>Mã chứng từ</th>
                        <th>Ngày
                            <?= $isPurchase ? ' Phát sinh' : ' Đặt hàng' ?>
                        </th>
                        <th class="text-end">Tổng cộng</th>
                        <?php if (!$isPurchase): ?>
                            <th>Trạng thái</th>
                        <?php endif; ?>
                        <th style="width: 90px;">Chi tiết</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars((string)$order['MASOCT']) ?></td>
                            <td>
                                <?php
                                $dateField = $isPurchase ? 'NGAYPHATSINH' : 'NGAYDATHANG';
                                echo htmlspecialchars((string)($order[$dateField] ?? ''));
                                ?>
                            </td>

                            <td class="text-end text-danger fw-bold">
                                <?= number_format((float)($order['TONGCONG'] ?? 0)) ?> VND
                            </td>

                            <?php if (!$isPurchase): ?>
                                <td><?= htmlspecialchars((string)($order['TRANGTHAI'] ?? '')) ?></td>
                            <?php endif; ?>

                            <td class="text-center">
                                <?php
                                // Xác định ID và loại chứng từ để xây dựng link chi tiết
                                $idKey = $isPurchase ? 'ID_CTMUA' : 'ID_CTBAN';
                                $typeParam = $isPurchase ? 'mua' : 'ban';
                                $idParam = urlencode((string)($order[$idKey] ?? ''));
                                ?>

                                <a
                                    href="index.php?controller=user&action=orderDetail&id=<?= $idParam ?>&type=<?= $typeParam ?>"
                                    class="btn btn-sm btn-info">
                                    Xem
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    <?php endif; ?>

</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>