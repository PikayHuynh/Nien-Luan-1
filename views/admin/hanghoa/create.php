<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<h2>Thêm Hàng Hóa</h2>

	<form method="post" action="" enctype="multipart/form-data">
		<div class="mb-3">
			<label class="form-label">Tên hàng hóa</label>
			<input type="text" name="TENHANGHOA" class="form-control" required>
		</div>

		<div class="mb-3">
			<label class="form-label">Mô tả</label>
			<textarea name="MOTA" class="form-control" rows="4"></textarea>
		</div>

		<div class="mb-3">
			<label class="form-label">Đơn vị tính</label>
			<input type="text" name="DONVITINH" class="form-control">
		</div>

		<div class="mb-3">
			<label class="form-label">Phân loại</label>
			<select name="ID_PHANLOAI" class="form-control">
				<option value="">-- Chọn phân loại --</option>
				<?php foreach ($phanloaiList as $p): ?>
					<option value="<?= $p['ID_PHANLOAI'] ?>"><?= htmlspecialchars($p['TENPHANLOAI']) ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label">Hình ảnh</label>
			<input type="file" name="HINHANH" class="form-control">
		</div>

		<button class="btn btn-primary">Lưu</button>
		<a href="index.php?controller=hanghoa&action=index" class="btn btn-secondary">Hủy</a>
	</form>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
