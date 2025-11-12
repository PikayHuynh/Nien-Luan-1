<?php include ROOT . '/views/layouts/header.php'; ?>
<?php include ROOT . '/views/layouts/sidebar.php'; ?>

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
                    <?php if($item['HINHANH']): ?>
                        <img src="uploads/<?= $item['HINHANH'] ?>" alt="" width="60">
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
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>
