<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
    <h2>Danh sách Đơn Giá Bán</h2>
    <a href="index.php?controller=dongiaban&action=create" class="btn btn-primary mb-3">Thêm mới</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Hàng hóa</th>
                <th>Giá trị</th>
                <th>Ngày bắt đầu</th>
                <th>Áp dụng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data as $item): ?>
            <tr>
                <td><?= $item['ID_DONGIA'] ?></td>
                <td><?= $item['TENHANGHOA'] ?></td>
                <td><?= number_format($item['GIATRI'], 0, ',', '.') ?> VND</td>
                <td><?= $item['NGAYBATDAU'] ?></td>
                <td><?= $item['APDUNG'] ? 'Có' : 'Không' ?></td>
                <td>
                    <a href="index.php?controller=dongiaban&action=edit&id=<?= $item['ID_DONGIA'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="index.php?controller=dongiaban&action=delete&id=<?= $item['ID_DONGIA'] ?>" 
                       class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Delete</a>
                    <a href="index.php?controller=dongiaban&action=detail&id=<?= $item['ID_DONGIA'] ?>" 
                       class="btn btn-sm btn-info">Detail</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
