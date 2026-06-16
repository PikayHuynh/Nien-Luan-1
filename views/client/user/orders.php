<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5 mb-5 pt-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            
            <div class="d-flex align-items-center mb-5">
                <a href="index.php?controller=user&action=profile" class="btn btn-outline-light rounded-circle me-3 border-white-10 p-2">
                    <i class="bi bi-person"></i>
                </a>
                <h2 class="fw-bold mb-0 text-white">
                    <?= $isPurchase ? 'Lịch sử nhập hàng' : 'Đơn hàng của tôi' ?>
                </h2>
            </div>

            <?php if (empty($orders)): ?>
                <div class="card bg-glass border-white-10 text-center p-5 rounded-4 shadow-lg">
                    <div class="mb-4">
                        <i class="bi bi-bag-x display-1 text-muted"></i>
                    </div>
                    <h3 class="text-white fw-bold mb-3">Chưa có dữ liệu</h3>
                    <p class="text-muted mb-4 fs-5">
                        <?= $isPurchase ? 'Không có chứng từ nhập hàng nào trong hệ thống.' : 'Bạn chưa thực hiện đơn hàng nào với chúng tôi.' ?>
                    </p>
                    <a href="index.php?controller=product&action=list" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">
                        <i class="bi bi-shop me-2"></i> Khám phá sản phẩm
                    </a>
                </div>
            <?php else: ?>

                <div class="card bg-glass border-white-10 rounded-4 shadow-lg overflow-hidden mb-4">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0" style="--bs-table-bg: transparent;">
                            <thead class="text-muted small text-uppercase">
                                <tr class="border-bottom border-white-10">
                                    <th class="ps-4 py-3">Mã chứng từ</th>
                                    <th class="py-3 text-center">Ngày <?= $isPurchase ? 'nhập' : 'đặt' ?></th>
                                    <th class="text-end py-3">Tổng cộng</th>
                                    <?php if (!$isPurchase): ?>
                                        <th class="text-center py-3">Trạng thái</th>
                                    <?php endif; ?>
                                    <th class="text-center pe-4 py-3">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): 
                                    $idKey = $isPurchase ? 'ID_CTMUA' : 'ID_CTBAN';
                                    $typeParam = $isPurchase ? 'mua' : 'ban';
                                    $idParam = urlencode((string)($order[$idKey] ?? ''));
                                    
                                    // Status styling
                                    $status = (string)($order['TRANGTHAI'] ?? '');
                                    $statusClass = 'bg-secondary';
                                    if(mb_stripos($status, 'Hoàn thành') !== false) $statusClass = 'bg-success';
                                    if(mb_stripos($status, 'Đã hủy') !== false) $statusClass = 'bg-danger';
                                    if(mb_stripos($status, 'Đang') !== false) $statusClass = 'bg-primary';
                                ?>
                                    <tr class="border-bottom border-white-5 align-middle">
                                        <td class="ps-4 py-3">
                                            <span class="fw-bold text-white"><?= htmlspecialchars((string)$order['MASOCT']) ?></span>
                                        </td>
                                        <td class="text-center text-muted">
                                            <?php
                                            $dateField = $isPurchase ? 'NGAYPHATSINH' : 'NGAYDATHANG';
                                            echo htmlspecialchars((string)($order[$dateField] ?? ''));
                                            ?>
                                        </td>
                                        <td class="text-end fw-bold text-primary">
                                            <?= number_format((float)($order['TONGCONG'] ?? 0)) ?> đ
                                        </td>
                                        <?php if (!$isPurchase): ?>
                                            <td class="text-center">
                                                <span class="badge <?= $statusClass ?> rounded-pill px-3 py-2"><?= htmlspecialchars($status) ?></span>
                                            </td>
                                        <?php endif; ?>
                                        <td class="text-center pe-4">
                                            <a href="index.php?controller=user&action=orderDetail&id=<?= $idParam ?>&type=<?= $typeParam ?>" 
                                               class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="bi bi-eye me-1"></i> Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PAGINATION -->
                <?php if ($totalPages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center gap-2 border-0">
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link rounded-circle border-white-10 bg-glass" href="?controller=user&action=orders&page=<?= $currentPage - 1 ?>">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= ($i == $currentPage ? 'active' : '') ?>">
                                    <a class="page-link rounded-circle border-white-10 bg-glass" href="?controller=user&action=orders&page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link rounded-circle border-white-10 bg-glass" href="?controller=user&action=orders&page=<?= $currentPage + 1 ?>">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>