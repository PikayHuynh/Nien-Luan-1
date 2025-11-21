<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Danh Sách Khách Hàng</h2>
    <a href="index.php?controller=khachhang&action=create" class="btn btn-sm btn-success rounded-pill d-inline-flex align-items-center" style="gap:.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
        <span class="d-none d-sm-inline">Tạo mới</span>
    </a>
</div>

<table class="table table-bordered">
    <thead>
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
        <?php foreach($data as $kh): ?>
        <tr>
            <td><?= $kh['ID_KHACH_HANG'] ?></td>
            <td><?= $kh['TEN_KH'] ?></td>
            <td><?= $kh['DIACHI'] ?></td>
            <td><?= $kh['SODIENTHOAI'] ?></td>
            <td><?= $kh['SOB'] ?></td>
            <td>
                <?php if(!empty($kh['HINHANH'])): ?>
                    <img src="upload/<?= htmlspecialchars($kh['HINHANH']) ?>" width="50" alt="">
                <?php endif; ?>
            </td>
            <td>
                <a href="index.php?controller=khachhang&action=detail&id=<?= $kh['ID_KHACH_HANG'] ?>" class="btn btn-sm btn-info">Xem</a>
                <a href="index.php?controller=khachhang&action=edit&id=<?= $kh['ID_KHACH_HANG'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                <?php if (empty($kh['IS_ADMIN'])): ?>
                    <a href="index.php?controller=khachhang&action=delete&id=<?= $kh['ID_KHACH_HANG'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if($totalPages > 1): ?>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!-- Prev -->
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="index.php?controller=khachhang&action=index&page=<?= max($page-1,1) ?>" aria-label="Previous">&laquo; Prev</a>
        </li>

        <?php
        $maxPagesToShow = 5;

        if ($totalPages <= $maxPagesToShow) {
            $start = 1;
            $end = $totalPages;
        } else {
            $start = $page - 2;
            $end = $page + 2;

            if ($start < 1) {
                $end += 1 - $start; // đẩy end ra nếu start < 1
                $start = 1;
            }
            if ($end > $totalPages) {
                $start -= $end - $totalPages; // đẩy start về nếu end > tổng trang
                $end = $totalPages;
            }
        }

        for($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?= ($i==$page) ? 'active' : '' ?>">
                <a class="page-link" href="index.php?controller=khachhang&action=index&page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- Next -->
        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="index.php?controller=khachhang&action=index&page=<?= min($page+1,$totalPages) ?>" aria-label="Next">Next &raquo;</a>
        </li>
    </ul>
</nav>
<?php endif; ?>



<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
