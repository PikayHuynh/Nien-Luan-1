<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <h2 class="mb-3">Lịch Sử Nhập Xuất Kho</h2>

    <!-- BẢNG DANH SÁCH -->
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-light">
            <tr>
                <th>ID_KH0</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Phân loại</th>
                <th>Mã số chứng từ tương ứng</th>
                <th>Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr><td colspan="6" class="text-center">Chưa có giao dịch kho nào.</td></tr>
            <?php else: ?>
                <?php foreach ($data as $item): 
                    $isMua = $item['LOAI_CHUNG_TU'] === 'MUA';
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ID_KHO']) ?></td>
                        <td>
                            <b><?= htmlspecialchars($item['TENHANGHOA'] ?? 'Không xác định') ?></b><br>
                            <small class="text-muted">ID: <?= htmlspecialchars($item['ID_HANGHOA']) ?></small>
                        </td>
                        <td>
                            <span class="badge <?= $isMua ? 'bg-success' : 'bg-danger' ?> fs-6">
                                <?= $isMua ? '+' : '-' ?><?= htmlspecialchars($item['SOLUONG']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($isMua): ?>
                                <span class="badge bg-primary">Nhập kho</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Xuất kho</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($isMua): ?>
                                CT Mua ID: <?= htmlspecialchars($item['ID_CTMUA']) ?>
                            <?php else: ?>
                                CT Bán ID: <?= htmlspecialchars($item['ID_CTBAN']) ?>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($item['NGAY_TAO']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- PHÂN TRANG -->
    <?php if (!empty($data) && $totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?controller=kho&action=index&page=<?= $currentPage - 1 ?>">« Prev</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?= ($i == $currentPage ? 'active' : '') ?>">
                        <a class="page-link" href="?controller=kho&action=index&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?controller=kho&action=index&page=<?= $currentPage + 1 ?>">Next »</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>
