
<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<div class="row">
		<div class="col-lg-8">
			<h2>Tạo mới Thuộc tính</h2>

			<form method="post" action="" enctype="multipart/form-data">
				<div class="mb-3">
					<label class="form-label">Tên thuộc tính</label>
					<input type="text" name="TEN" class="form-control" value="<?= htmlspecialchars($_POST['TEN'] ?? '') ?>" required>
				</div>

				<div class="mb-3">
					<label class="form-label">Giá trị</label>
					<input type="text" name="GIATRI" class="form-control" value="<?= htmlspecialchars($_POST['GIATRI'] ?? '') ?>">
				</div>

				<div class="mb-3">
					<label class="form-label">Hàng hóa</label>
					<select name="ID_HANGHOA" class="form-control">
						<option value="">-- Chọn hàng hóa --</option>
						<?php if (!empty($hanghoas)): ?>
							<?php foreach ($hanghoas as $hh): ?>
								<option value="<?= $hh['ID_HANGHOA'] ?>" <?= (isset($_POST['ID_HANGHOA']) && $_POST['ID_HANGHOA'] == $hh['ID_HANGHOA']) ? 'selected' : '' ?>><?= htmlspecialchars($hh['TENHANGHOA']) ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>

				<div class="mb-3">
					<label class="form-label">Hình ảnh</label>
					<input type="file" name="HINHANH" class="form-control">
				</div>

				<button class="btn btn-primary">Lưu</button>
				<a href="index.php?controller=thuoctinh&action=index" class="btn btn-secondary">Hủy</a>
			</form>
		</div>

		<div class="col-lg-4 d-none d-lg-block">
			<?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
		</div>
	</div>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
