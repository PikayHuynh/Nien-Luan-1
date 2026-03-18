<?php
// ===============================================================
//  HEADER + SIDEBAR ADMIN
// ===============================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">
    <?php if (isset($_GET['error']) && $_GET['error'] === 'has_hanghoa'): ?>
        <div class="alert alert-danger">
            Không thể xóa phân loại vì vẫn còn hàng hóa thuộc phân loại này.
        </div>
    <?php endif; ?>

    <!-- TIÊU ĐỀ & NÚT THÊM MỚI -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Danh sách Phân Loại</h2>

        <a href="index.php?controller=phanloai&action=create"
            class="btn btn-primary rounded-pill px-3">
            + Thêm mới
        </a>
    </div>

    <!-- Form tìm kiếm -->
    <form method="GET" class="mb-3 adminSearchForm">
        <input type="hidden" name="controller" value="phanloai">
        <input type="hidden" name="action" value="index">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="q" class="form-control adminSearchInput"
                placeholder="Tìm theo tên phân loại..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <!-- BẢNG DANH SÁCH -->
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th width="60">ID</th>
                <th width="200">Tên phân loại</th>
                <th>Mô tả</th>
                <th width="120">Hình ảnh</th>
                <th width="180">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['ID_PHANLOAI']) ?></td>

                    <td><?= htmlspecialchars($item['TENPHANLOAI']) ?></td>

                    <td><?= nl2br(htmlspecialchars($item['MOTA'])) ?></td>

                    <td class="text-center">
                        <?php if (!empty($item['HINHANH'])): ?>
                            <img
                                src="upload/<?= htmlspecialchars($item['HINHANH']) ?>"
                                width="70"
                                style="border-radius:6px;">
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a
                            href="index.php?controller=phanloai&action=detail&id=<?= $item['ID_PHANLOAI'] ?>"
                            class="btn btn-sm btn-info">
                            Xem
                        </a>

                        <a
                            href="index.php?controller=phanloai&action=edit&id=<?= $item['ID_PHANLOAI'] ?>"
                            class="btn btn-sm btn-warning">
                            Sửa
                        </a>

                        <a
                            onclick="return confirm('Bạn có chắc muốn xóa phân loại này?')"
                            href="index.php?controller=phanloai&action=delete&id=<?= $item['ID_PHANLOAI'] ?>"
                            class="btn btn-sm btn-danger">
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PHÂN TRANG -->
    <nav>
        <ul class="pagination justify-content-center mt-3">

            <!-- Nút Prev -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?controller=phanloai&action=index&page=<?= $currentPage - 1 ?>">
                        « Prev
                    </a>
                </li>
            <?php endif; ?>

            <!-- Danh sách trang -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?controller=phanloai&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Nút Next -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?controller=phanloai&action=index&page=<?= $currentPage + 1 ?>">
                        Next »
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

</div>

<?php
// FOOTER
include ROOT . '/views/admin/layouts/footer.php';
?>