<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <h2 class="mb-3">Danh sách Hàng Hóa</h2>

    <!-- Form tìm kiếm -->
    <form method="GET" class="mb-3 adminSearchForm">
        <input type="hidden" name="controller" value="hanghoa">
        <input type="hidden" name="action" value="index">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="q" class="form-control adminSearchInput" placeholder="Tìm theo tên hàng hóa..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <!-- Nút thêm mới -->
    <a href="index.php?controller=hanghoa&action=create" class="btn btn-primary mb-3">
        Thêm mới
    </a>

    <!-- ===============================================================
        BẢNG DANH SÁCH HÀNG HOÁ
    ================================================================ -->
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tên hàng hóa</th>
                <th>Đơn vị tính</th>
                <th>Hình ảnh</th>
                <th>Phân loại</th>
                <th>Số lượng</th>
                <th>Giá bán</th>
                <th style="width: 180px;">Hành động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data as $item): ?>

                <tr>
                    <!-- ID -->
                    <td><?= htmlspecialchars($item['ID_HANGHOA']) ?></td>

                    <!-- Tên HH -->
                    <td>
                        <?= htmlspecialchars($item['TENHANGHOA']) ?>
                        <div class="mt-1">
                            <?php
                            // Logic nhãn (giống client nhưng cho admin xem)
                            $isHot = (($item['SOLD_COUNT'] ?? 0) > 30);
                            $isNew = (!empty($item['NGAYTAO']) && strtotime($item['NGAYTAO']) >= strtotime('-3 days'));
                            $isSale = (!empty($item['GIAGOC']) && $item['GIAGOC'] > ($item['DONGIA'] ?? 0));
                            $percent = 0;
                            if ($isSale && $item['GIAGOC'] > 0) {
                                $percent = round((($item['GIAGOC'] - $item['DONGIA']) / $item['GIAGOC']) * 100);
                            }
                            ?>
                            <?php if ($isHot): ?>
                                <span class="badge bg-danger">HOT</span>
                            <?php endif; ?>
                            <?php if ($isNew): ?>
                                <span class="badge bg-success">NEW</span>
                            <?php endif; ?>
                            <?php if ($isSale): ?>
                                <span class="badge bg-warning text-dark">-<?= $percent ?>%</span>
                            <?php endif; ?>
                        </div>
                    </td>

                    <!-- Đơn vị -->
                    <td><?= htmlspecialchars($item['DONVITINH']) ?></td>

                    <!-- Hình ảnh -->
                    <td>
                        <?php if (!empty($item['HINHANH'])): ?>
                            <img src="upload/<?= htmlspecialchars($item['HINHANH']) ?>" width="60"
                                style="border-radius: 6px; border: 1px solid #ddd;">
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </td>

                    <!-- Phân loại -->
                    <td><?= htmlspecialchars($item['TENPHANLOAI']) ?></td>

                    <!-- Số lượng -->
                    <td><?= htmlspecialchars($item['SOLUONG'] ?? 0) ?></td>

                    <!-- Giá bán -->
                    <td class="text-danger fw-bold">
                        <?= number_format($item['DONGIA'] ?? 0) ?> VND
                    </td>

                    <!-- Hành động -->
                    <td>
                        <!-- Sửa -->
                        <a href="index.php?controller=hanghoa&action=edit&id=<?= $item['ID_HANGHOA'] ?>"
                            class="btn btn-sm btn-warning mb-2">
                            Edit
                        </a>

                        <!-- Xóa -->
                        <a href="index.php?controller=hanghoa&action=delete&id=<?= $item['ID_HANGHOA'] ?>"
                            class="btn btn-sm btn-danger mb-2" onclick="return confirm('Bạn có chắc muốn xóa?')">
                            Delete
                        </a>

                        <!-- Chi tiết -->
                        <a href="index.php?controller=hanghoa&action=detail&id=<?= $item['ID_HANGHOA'] ?>"
                            class="btn btn-sm btn-info mb-2">
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

            <!-- Trang trước -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?controller=hanghoa&action=index&page=<?= $currentPage - 1 ?>">
                        « Prev
                    </a>
                </li>
            <?php endif; ?>

            <!-- Các trang -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage ? 'active' : '') ?>">
                    <a class="page-link" href="?controller=hanghoa&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Trang kế -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?controller=hanghoa&action=index&page=<?= $currentPage + 1 ?>">
                        Next »
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>