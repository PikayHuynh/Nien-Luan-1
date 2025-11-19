<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<h2>Chỉnh sửa Thuộc tính #<?= htmlspecialchars($thuoctinh['ID_THUOCTINH'] ?? '') ?></h2>

	<form method="post" action="" enctype="multipart/form-data">
		<div class="mb-3">
			<label class="form-label">Tên thuộc tính</label>
			<input type="text" name="TEN" class="form-control" value="<?= htmlspecialchars($thuoctinh['TEN'] ?? '') ?>" required>
		</div>

		<div class="mb-3">
			<label class="form-label">Giá trị</label>
			<input type="text" name="GIATRI" class="form-control" value="<?= htmlspecialchars($thuoctinh['GIATRI'] ?? '') ?>">
		</div>

		<div class="mb-3">
			<label class="form-label">Hàng hóa</label>
			<select name="ID_HANGHOA" class="form-control">
				<option value="">-- Chọn hàng hóa --</option>
				<?php foreach ($hanghoas as $hh): ?>
					<option value="<?= $hh['ID_HANGHOA'] ?>" <?= (($hh['ID_HANGHOA'] ?? '') == ($thuoctinh['ID_HANGHOA'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($hh['TENHANGHOA']) ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label">Hình ảnh</label>
			<?php if (!empty($thuoctinh['HINHANH'])): ?>
				<div><img src="upload/<?= htmlspecialchars($thuoctinh['HINHANH']) ?>" style="max-width:200px"></div>
			<?php endif; ?>
			<input type="file" name="HINHANH" class="form-control">
		</div>

		<button class="btn btn-primary">Lưu</button>
		<a href="index.php?controller=thuoctinh&action=index" class="btn btn-secondary">Hủy</a>
	</form>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
