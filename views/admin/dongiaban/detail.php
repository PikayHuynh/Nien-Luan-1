<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<h2>Chi tiết Đơn Giá #<?= htmlspecialchars($dongia['ID_DONGIA'] ?? '') ?></h2>

	<p><strong>Hàng hóa:</strong> <?= htmlspecialchars($dongia['TENHANGHOA'] ?? '') ?></p>
	<p><strong>Giá trị:</strong> <?= number_format($dongia['GIATRI'] ?? 0) ?> VND</p>
	<p><strong>Ngày bắt đầu:</strong> <?= htmlspecialchars($dongia['NGAYBATDAU'] ?? '') ?></p>
	<p><strong>Áp dụng:</strong> <?= !empty($dongia['APDUNG']) ? 'Có' : 'Không' ?></p>

	<a href="index.php?controller=dongiaban&action=edit&id=<?= $dongia['ID_DONGIA'] ?>" class="btn btn-warning">Edit</a>
	<a href="index.php?controller=dongiaban&action=index" class="btn btn-secondary">Quay lại</a>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
