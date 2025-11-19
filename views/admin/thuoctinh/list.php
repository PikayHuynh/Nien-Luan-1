<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
    <h2>Danh sách Thuộc Tính</h2>
    <a href="index.php?controller=thuoctinh&action=create" class="btn btn-primary mb-3">Thêm mới</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá trị</th>
                <th>Hình ảnh</th>
                <th>Hàng hóa</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data as $item): ?>
            <tr>
                <td><?= $item['ID_THUOCTINH'] ?></td>
                <td><?= $item['TEN'] ?></td>
                <td><?= $item['GIATRI'] ?></td>
                <td>
                    <?php if(!empty($item['HINHANH'])): ?>
                        <img src="upload/<?= htmlspecialchars($item['HINHANH']) ?>" alt="" width="60">
                    <?php endif; ?>
                </td>
                <td><?= $item['TENHANGHOA'] ?></td>
                <td>
                    <a href="index.php?controller=thuoctinh&action=edit&id=<?= $item['ID_THUOCTINH'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="index.php?controller=thuoctinh&action=delete&id=<?= $item['ID_THUOCTINH'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Delete</a>
                    <a href="index.php?controller=thuoctinh&action=detail&id=<?= $item['ID_THUOCTINH'] ?>" class="btn btn-sm btn-info">Detail</a>
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
                    <a class="page-link" href="?controller=thuoctinh&action=index&page=<?= $currentPage - 1 ?>">« Prev</a>
                </li>
            <?php endif; ?>

            <!-- Pages -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="?controller=thuoctinh&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?controller=thuoctinh&action=index&page=<?= $currentPage + 1 ?>">Next »</a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
