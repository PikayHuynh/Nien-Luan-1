<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
    <h2>Danh sách Chứng Từ Bán</h2>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Mã CT</th>
                <th>Ngày Đặt</th>
                <th>Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Thuế</th>
                <th>Tổng Cộng</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $ct): ?>
            <tr>
                <td><?= $ct['ID_CTBAN'] ?></td>
                <td><?= $ct['MASOCT'] ?></td>
                <td><?= $ct['NGAYDATHANG'] ?></td>
                <td>
                    <?php 
                    $kh = $khModel->getById($ct['ID_KHACHHANG'] ?? 0);
                    echo $kh['TEN_KH'] ?? '';
                    ?>
                </td>
                <td><?= number_format($ct['TONGTIENHANG'], 0, ',', '.') ?> VND</td>
                <td><?= number_format($ct['THUE'], 0, ',', '.') ?>%</td>
                <td><?= number_format($ct['TONGCONG'], 0, ',', '.') ?> VND</td>
                <td><?= $ct['TRANGTHAI'] ?></td>
                <td>
                    <a href="index.php?controller=chungtuban&action=detail&id=<?= $ct['ID_CTBAN'] ?>" class="btn btn-sm btn-info">Xem chi tiết</a>
                    <a href="index.php?controller=chungtuban&action=edit&id=<?= $ct['ID_CTBAN'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="index.php?controller=chungtuban&action=delete&id=<?= $ct['ID_CTBAN'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <!-- Prev -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?controller=chungtuban&action=index&page=<?= $currentPage - 1 ?>">« Prev</a>
                </li>
            <?php endif; ?>

            <!-- Pages -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="?controller=chungtuban&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?controller=chungtuban&action=index&page=<?= $currentPage + 1 ?>">Next »</a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
