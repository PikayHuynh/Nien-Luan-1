<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<h2>Chỉnh sửa phân loại #<?= htmlspecialchars($phanloai['ID_PHANLOAI'] ?? '') ?></h2>

	<form method="post" action="" enctype="multipart/form-data">
		<div class="mb-3">
			<label class="form-label">Tên phân loại</label>
			<input type="text" name="TENPHANLOAI" class="form-control" value="<?= htmlspecialchars($phanloai['TENPHANLOAI'] ?? '') ?>" required>
		</div>

		<div class="mb-3">
			<label class="form-label">Mô tả</label>
			<textarea name="MOTA" class="form-control" rows="4"><?= htmlspecialchars($phanloai['MOTA'] ?? '') ?></textarea>
		</div>

		<div class="mb-3">
			<label class="form-label">Hình ảnh</label>
			<?php if (!empty($phanloai['HINHANH'])): ?>
				<div><img src="upload/<?= htmlspecialchars($phanloai['HINHANH']) ?>" alt="" style="max-width:200px"></div>
			<?php endif; ?>
			<input type="file" name="HINHANH" class="form-control">
		</div>

		<button class="btn btn-primary">Lưu</button>
		<a href="index.php?controller=phanloai&action=index" class="btn btn-secondary">Hủy</a>
	</form>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
