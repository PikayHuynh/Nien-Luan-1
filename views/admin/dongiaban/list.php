<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- ===============================================================
         TIÊU ĐỀ + NÚT THÊM MỚI
    ================================================================ -->
    <h2 class="mb-3">Danh sách Đơn Giá Bán</h2>

    <!-- Form tìm kiếm -->
    <form method="GET" class="mb-3 adminSearchForm">
        <input type="hidden" name="controller" value="dongiaban">
        <input type="hidden" name="action" value="index">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="q" class="form-control adminSearchInput"
                placeholder="Tìm theo tên hàng hóa..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <a
        href="index.php?controller=dongiaban&action=create"
        class="btn btn-primary mb-3">
        Thêm mới
    </a>

    <!-- ===============================================================
         BẢNG DANH SÁCH ĐƠN GIÁ BÁN
    ================================================================ -->
    <table class="table table-bordered table-striped">

        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Hàng hóa</th>
                <th>Giá trị</th>
                <th>Ngày bắt đầu</th>
                <th>Áp dụng</th>
                <th width="200">Hành động</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($data as $item): ?>

                <tr>
                    <!-- ID -->
                    <td><?= htmlspecialchars($item['ID_DONGIA']) ?></td>

                    <!-- Tên hàng hóa -->
                    <td><?= htmlspecialchars($item['TENHANGHOA']) ?></td>

                    <!-- Giá trị -->
                    <td><?= number_format($item['GIATRI'], 0, ',', '.') ?> VND</td>

                    <!-- Ngày bắt đầu -->
                    <td><?= htmlspecialchars($item['NGAYBATDAU']) ?></td>

                    <!-- Trạng thái áp dụng -->
                    <td><?= !empty($item['APDUNG']) ? 'Có' : 'Không' ?></td>

                    <!-- Các nút thao tác -->
                    <td>
                        <!-- Sửa -->
                        <a
                            href="index.php?controller=dongiaban&action=edit&id=<?= $item['ID_DONGIA'] ?>"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <!-- Xóa -->
                        <a
                            href="index.php?controller=dongiaban&action=delete&id=<?= $item['ID_DONGIA'] ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc muốn xóa?')">
                            Delete
                        </a>

                        <!-- Chi tiết -->
                        <a
                            href="index.php?controller=dongiaban&action=detail&id=<?= $item['ID_DONGIA'] ?>"
                            class="btn btn-sm btn-info">
                            Detail
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

            <!-- Prev -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="?controller=dongiaban&action=index&page=<?= $currentPage - 1 ?>">
                        « Prev
                    </a>
                </li>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a
                        class="page-link"
                        href="?controller=dongiaban&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="?controller=dongiaban&action=index&page=<?= $currentPage + 1 ?>">
                        Next »
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

</div>

<?php
// ======================================================================
//  FOOTER ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>