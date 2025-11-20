<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<div class="row">
		<div class="col-lg-8">
			<h2>Chỉnh sửa Hàng Hóa #<?= htmlspecialchars($hanghoa['ID_HANGHOA'] ?? '') ?></h2>

			<form method="post" action="" enctype="multipart/form-data">
		<div class="mb-3">
			<label class="form-label">Tên hàng hóa</label>
			<input type="text" name="TENHANGHOA" class="form-control" value="<?= htmlspecialchars($hanghoa['TENHANGHOA'] ?? '') ?>" required>
		</div>

		<div class="mb-3">
			<label class="form-label">Mô tả</label>
			<textarea name="MOTA" class="form-control" rows="4"><?= htmlspecialchars($hanghoa['MOTA'] ?? '') ?></textarea>
		</div>

		<div class="mb-3">
			<label class="form-label">Đơn vị tính</label>
			<input type="text" name="DONVITINH" class="form-control" value="<?= htmlspecialchars($hanghoa['DONVITINH'] ?? '') ?>">
		</div>

		<div class="mb-3">
			<label class="form-label">Phân loại</label>
			<select name="ID_PHANLOAI" class="form-control">
				<option value="">-- Chọn phân loại --</option>
				<?php foreach ($phanloaiList as $p): ?>
					<option value="<?= $p['ID_PHANLOAI'] ?>" <?= ($p['ID_PHANLOAI'] == ($hanghoa['ID_PHANLOAI'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($p['TENPHANLOAI']) ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label">Hình ảnh</label>
			<?php if (!empty($hanghoa['HINHANH'])): ?>
				<div><img src="upload/<?= htmlspecialchars($hanghoa['HINHANH']) ?>" style="max-width:200px"></div>
			<?php endif; ?>
			<input type="file" name="HINHANH" class="form-control">
		</div>

		<button class="btn btn-primary">Lưu</button>
		<a href="index.php?controller=hanghoa&action=index" class="btn btn-secondary">Hủy</a>
			</form>
		</div>
		<div class="col-lg-4 d-none d-lg-block">
			<?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
		</div>
	</div>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
