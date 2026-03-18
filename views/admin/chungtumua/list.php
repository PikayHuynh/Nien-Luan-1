<?php
// ===============================
//  HEADER + SIDEBAR ADMIN
// ===============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <h3>Danh sách Chứng Từ Mua</h3>
    <!-- Form tìm kiếm -->
    <form method="GET" class="mb-3 adminSearchForm">
        <input type="hidden" name="controller" value="chungtumua">
        <input type="hidden" name="action" value="index">
        <div class="input-group" style="max-width: 400px;">
            <input type="text"
                name="q"
                class="form-control adminSearchInput"
                placeholder="Tìm ngày... (vd: 2025-11 hoặc 2025-11-27)"
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>


    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Mã số</th>
                <th>Khách hàng</th>
                <th>Ngày phát sinh</th>
                <th>Tổng cộng</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data as $ctm): ?>

                <?php
                // An toàn lấy tên khách:
                // - Nếu controller truyền $khModel (tốt) dùng model lấy tên.
                // - Nếu không có $khModel, hiển thị fallback '#ID'.
                $khTen = '#' . ($ctm['ID_KHACHHANG'] ?? '');
                if (isset($khModel) && is_object($khModel) && method_exists($khModel, 'getById')) {
                    $khRow = $khModel->getById($ctm['ID_KHACHHANG'] ?? 0);
                    if (!empty($khRow) && !empty($khRow['TEN_KH'])) {
                        $khTen = $khRow['TEN_KH'];
                    }
                }
                ?>

                <tr>
                    <td><?= htmlspecialchars($ctm['ID_CTMUA'] ?? '') ?></td>
                    <td><?= htmlspecialchars($ctm['MASOCT'] ?? '') ?></td>
                    <td><?= htmlspecialchars($khTen) ?></td>
                    <td><?= htmlspecialchars($ctm['NGAYPHATSINH'] ?? '') ?></td>
                    <td><?= number_format((float)($ctm['TONGCONG'] ?? 0), 0, ',', '.') ?> VND</td>
                    <td>
                        <a href="index.php?controller=chungtumua&action=detail&id=<?= urlencode($ctm['ID_CTMUA']) ?>" class="btn btn-info btn-sm">Xem</a>
                        <a href="index.php?controller=chungtumua&action=edit&id=<?= urlencode($ctm['ID_CTMUA']) ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="index.php?controller=chungtumua&action=delete&id=<?= urlencode($ctm['ID_CTMUA']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PHÂN TRANG -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if (!empty($currentPage) && $currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?controller=chungtumua&action=index&page=<?= $currentPage - 1 ?>">« Prev</a>
                </li>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="?controller=chungtumua&action=index&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if (!empty($currentPage) && $currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?controller=chungtumua&action=index&page=<?= $currentPage + 1 ?>">Next »</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

</div>

<?php
// FOOTER
include ROOT . '/views/admin/layouts/footer.php';
?>