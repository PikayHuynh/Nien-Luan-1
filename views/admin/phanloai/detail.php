<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<h2>Chi tiết Phân loại #<?= htmlspecialchars($phanloai['ID_PHANLOAI'] ?? '') ?></h2>

	<p><strong>Tên:</strong> <?= htmlspecialchars($phanloai['TENPHANLOAI'] ?? '') ?></p>
	<p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($phanloai['MOTA'] ?? '')) ?></p>
	<?php if (!empty($phanloai['HINHANH'])): ?>
		<p><img src="upload/<?= htmlspecialchars($phanloai['HINHANH']) ?>" alt="" style="max-width:300px"></p>
	<?php endif; ?>

	<a href="index.php?controller=phanloai&action=edit&id=<?= $phanloai['ID_PHANLOAI'] ?>" class="btn btn-warning">Edit</a>
	<a href="index.php?controller=phanloai&action=index" class="btn btn-secondary">Quay lại</a>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
