<?php
// ===============================
//  HEADER + SIDEBAR ADMIN
// ===============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
?>

<!-- ============================================================
    TIÊU ĐỀ TRANG + NÚT TẠO MỚI
=============================================================== -->
<div class="d-flex justify-content-between align-items-center mb-3">

    <h2 class="mb-0">Danh Sách Khách Hàng</h2>
    <!-- Nút Tạo Mới -->
    <a href="index.php?controller=khachhang&action=create"
        class="btn btn-sm btn-success rounded-pill d-inline-flex align-items-center mx-5"
        style="gap:.5rem;">
        <!-- Icon dấu + -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </svg>

        <span class="d-none d-sm-inline">Tạo mới</span>
    </a>
</div>

<!-- Form tìm kiếm -->
<form method="GET" class="mb-3 adminSearchForm">
    <input type="hidden" name="controller" value="khachhang">
    <input type="hidden" name="action" value="index">
    <div class="input-group" style="max-width: 400px;">
        <input type="text"
            name="q"
            class="form-control adminSearchInput"
            placeholder="Tìm theo tên khách hàng..."
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button class="btn btn-primary" type="submit">Tìm</button>
    </div>
</form>



<!-- ============================================================
    BẢNG DANH SÁCH KHÁCH HÀNG
=============================================================== -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Tên KH</th>
            <th>Địa chỉ</th>
            <th>SĐT</th>
            <th>Số B</th>
            <th>Hình ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data as $kh): ?>
            <tr>
                <td><?= htmlspecialchars($kh['ID_KHACH_HANG']) ?></td>
                <td><?= htmlspecialchars($kh['TEN_KH']) ?></td>
                <td><?= htmlspecialchars($kh['DIACHI']) ?></td>
                <td><?= htmlspecialchars($kh['SODIENTHOAI']) ?></td>
                <td><?= htmlspecialchars($kh['SOB']) ?></td>

                <!-- Hình ảnh -->
                <td>
                    <?php if (!empty($kh['HINHANH'])): ?>
                        <img src="upload/<?= htmlspecialchars($kh['HINHANH']) ?>"
                            width="50"
                            style="border-radius:4px;">
                    <?php else: ?>
                        <span class="text-muted">Không có</span>
                    <?php endif; ?>
                </td>

                <!-- Hành động -->
                <td>
                    <a class="btn btn-sm btn-info"
                        href="index.php?controller=khachhang&action=detail&id=<?= $kh['ID_KHACH_HANG'] ?>">
                        Xem
                    </a>

                    <a class="btn btn-sm btn-warning"
                        href="index.php?controller=khachhang&action=edit&id=<?= $kh['ID_KHACH_HANG'] ?>">
                        Sửa
                    </a>

                    <?php if (empty($kh['IS_ADMIN'])): ?>
                        <a class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc muốn xóa?')"
                            href="index.php?controller=khachhang&action=delete&id=<?= $kh['ID_KHACH_HANG'] ?>">
                            Xóa
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- ============================================================
     PHÂN TRANG (hiển thị nếu có nhiều trang)
=============================================================== -->
<?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">

            <!-- Nút Prev -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="index.php?controller=khachhang&action=index&page=<?= max($page - 1, 1) ?>">
                    &laquo; Prev
                </a>
            </li>

            <?php
            // Giới hạn số trang hiển thị
            $maxPagesToShow = 5;

            if ($totalPages <= $maxPagesToShow) {
                $start = 1;
                $end   = $totalPages;
            } else {
                $start = $page - 2;
                $end   = $page + 2;

                if ($start < 1) {
                    $end += 1 - $start;
                    $start = 1;
                }
                if ($end > $totalPages) {
                    $start -= $end - $totalPages;
                    $end = $totalPages;
                }
            }
            ?>

            <!-- Danh sách trang -->
            <?php for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="index.php?controller=khachhang&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Nút Next -->
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link"
                    href="index.php?controller=khachhang&action=index&page=<?= min($page + 1, $totalPages) ?>">
                    Next &raquo;
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>