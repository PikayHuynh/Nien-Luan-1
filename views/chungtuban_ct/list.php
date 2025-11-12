<?php include ROOT . '/views/layouts/header.php'; ?>
<?php include ROOT . '/views/layouts/sidebar.php'; ?>

<div class="container mt-4">
    <h3>Chi Tiết Sản Phẩm - Chứng Từ <?= $idCtb ?? '' ?></h3>
    <a href="index.php?controller=chungtubanct&action=create&idCtb=<?= $idCtb ?>" class="btn btn-primary mb-3">Thêm sản phẩm</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Hàng hóa</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $item): ?>
                <?php $hh = $hangHoaData[$item['ID_HANGHOA']] ?? []; ?>
                <tr>
                    <td><?= $item['ID_CTBAN_CT'] ?></td>
                    <td><?= $hh['TEN_HANGHOA'] ?? 'Không tồn tại' ?></td>
                    <td><?= $item['SOLUONG'] ?></td>
                    <td><?= number_format($item['DONGIA']) ?> VND</td>
                    <td><?= number_format($item['SOLUONG'] * $item['DONGIA']) ?> VND</td>
                    <td>
                        <a href="index.php?controller=chungtubanct&action=edit&id=<?= $item['ID_CTBAN_CT'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?controller=chungtubanct&action=delete&id=<?= $item['ID_CTBAN_CT'] ?>&id_ctban=<?= $idCtb ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php?controller=chungtuban&action=detail&id=<?= $idCtb ?>" class="btn btn-secondary mt-3">Quay lại chứng từ</a>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>
