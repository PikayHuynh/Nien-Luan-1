
<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<div class="row">
		<div class="col-lg-8">
			<h2>Tạo mới Phân loại</h2>

			<form method="post" action="" enctype="multipart/form-data">
				<div class="mb-3">
					<label class="form-label">Tên phân loại</label>
					<input type="text" name="TENPHANLOAI" class="form-control" value="<?= htmlspecialchars($_POST['TENPHANLOAI'] ?? '') ?>" required>
				</div>

				<div class="mb-3">
					<label class="form-label">Mô tả</label>
					<textarea name="MOTA" class="form-control" rows="4"><?php echo htmlspecialchars($_POST['MOTA'] ?? '') ?></textarea>
				</div>

				<div class="mb-3">
					<label class="form-label">Hình ảnh</label>
					<input type="file" name="HINHANH" class="form-control">
				</div>

				<button class="btn btn-primary">Lưu</button>
				<a href="index.php?controller=phanloai&action=index" class="btn btn-secondary">Hủy</a>
			</form>
		</div>

		<div class="col-lg-4 d-none d-lg-block">
			<?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
		</div>
	</div>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
