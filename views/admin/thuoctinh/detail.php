<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<h2>Chi tiết Thuộc tính #<?= htmlspecialchars($thuoctinh['ID_THUOCTINH'] ?? '') ?></h2>

	<p><strong>Tên:</strong> <?= htmlspecialchars($thuoctinh['TEN'] ?? '') ?></p>
	<p><strong>Giá trị:</strong> <?= htmlspecialchars($thuoctinh['GIATRI'] ?? '') ?></p>
	<p><strong>Hàng hóa:</strong> <?= htmlspecialchars($thuoctinh['TENHANGHOA'] ?? '') ?></p>
	<?php if (!empty($thuoctinh['HINHANH'])): ?>
		<p><img src="upload/<?= htmlspecialchars($thuoctinh['HINHANH']) ?>" style="max-width:300px"></p>
	<?php endif; ?>

	<a href="index.php?controller=thuoctinh&action=edit&id=<?= $thuoctinh['ID_THUOCTINH'] ?>" class="btn btn-warning">Edit</a>
	<a href="index.php?controller=thuoctinh&action=index" class="btn btn-secondary">Quay lại</a>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
