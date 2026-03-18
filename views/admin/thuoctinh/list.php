<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- TIÊU ĐỀ + NÚT TẠO MỚI -->
    <h2>Danh sách Thuộc Tính</h2>

    <!-- Form tìm kiếm -->
    <form method="GET" class="mb-3 adminSearchForm">
        <input type="hidden" name="controller" value="thuoctinh">
        <input type="hidden" name="action" value="index">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="q" class="form-control adminSearchInput"
                placeholder="Tìm theo tên thuộc tính..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <a
        href="index.php?controller=thuoctinh&action=create"
        class="btn btn-primary mb-3">
        Thêm mới
    </a>

    <!-- ===============================================================
         BẢNG DANH SÁCH THUỘC TÍNH
    ================================================================ -->
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá trị</th>
                <th>Hình ảnh</th>
                <th>Hàng hóa</th>
                <th width="180">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <!-- ID -->
                    <td><?= htmlspecialchars($item['ID_THUOCTINH']) ?></td>

                    <!-- Tên thuộc tính -->
                    <td><?= htmlspecialchars($item['TEN']) ?></td>

                    <!-- Giá trị -->
                    <td><?= htmlspecialchars($item['GIATRI']) ?></td>

                    <!-- Hình ảnh -->
                    <td>
                        <?php if (!empty($item['HINHANH'])): ?>
                            <img
                                src="upload/<?= htmlspecialchars($item['HINHANH']) ?>"
                                alt="Ảnh thuộc tính"
                                width="60"
                                style="border-radius:5px;">
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </td>

                    <!-- Tên hàng hóa -->
                    <td><?= htmlspecialchars($item['TENHANGHOA']) ?></td>

                    <!-- Các nút hành động -->
                    <td>
                        <a
                            href="index.php?controller=thuoctinh&action=detail&id=<?= $item['ID_THUOCTINH'] ?>"
                            class="btn btn-sm btn-info">
                            Detail
                        </a>

                        <a
                            href="index.php?controller=thuoctinh&action=edit&id=<?= $item['ID_THUOCTINH'] ?>"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <a
                            onclick="return confirm('Bạn có chắc muốn xóa?')"
                            href="index.php?controller=thuoctinh&action=delete&id=<?= $item['ID_THUOCTINH'] ?>"
                            class="btn btn-sm btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ===============================================================
         PHÂN TRANG
    ================================================================ -->
    <nav>
        <ul class="pagination justify-content-center">

            <!-- Trang trước -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="?controller=thuoctinh&action=index&page=<?= $currentPage - 1 ?>">
                        « Prev
                    </a>
                </li>
            <?php endif; ?>

            <!-- Danh sách số trang -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a
                        class="page-link"
                        href="?controller=thuoctinh&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Trang kế -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="?controller=thuoctinh&action=index&page=<?= $currentPage + 1 ?>">
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