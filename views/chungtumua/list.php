<?php include ROOT . '/views/layouts/header.php'; ?>
<?php include ROOT . '/views/layouts/sidebar.php'; ?>

<h3>Danh sách Chứng Từ Mua</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã số</th>
            <th>Khách hàng</th>
            <th>Ngày phát sinh</th>
            <th>Tổng tiền</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $ctm): ?>
        <tr>
            <td><?= $ctm['ID_CTMUA'] ?></td>
            <td><?= $ctm['MASOCT'] ?></td>
            <td><?= $ctm['ID_KHACHHANG'] ?></td>
            <td><?= $ctm['NGAYPHATSINH'] ?></td>
            <td><?= $ctm['TONGCONG'] ?></td>
            <td>
                <a href="index.php?controller=chungtumua&action=detail&id=<?= $ctm['ID_CTMUA'] ?>" class="btn btn-info btn-sm">Xem</a>
                <a href="index.php?controller=chungtumua&action=delete&id=<?= $ctm['ID_CTMUA'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include ROOT . '/views/layouts/footer.php'; ?>
