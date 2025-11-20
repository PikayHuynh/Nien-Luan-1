<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
	<div class="row">
		<div class="col-lg-8">
			<h3>Chỉnh sửa Chứng Từ Mua #<?= htmlspecialchars($ctm['ID_CTMUA'] ?? '') ?></h3>

			<form method="post" action="">
	<div class="mb-3">
		<label class="form-label">Mã số</label>
		<input type="text" name="MASOCT" class="form-control" value="<?= htmlspecialchars($ctm['MASOCT'] ?? '') ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Ngày phát sinh</label>
		<input type="datetime-local" name="NGAYPHATSINH" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($ctm['NGAYPHATSINH'] ?? date('Y-m-d H:i'))) ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Khách hàng</label>
		<select name="ID_KHACHHANG" class="form-control">
			<option value="">-- Chọn khách hàng --</option>
			<?php foreach ($kh as $k): ?>
				<option value="<?= $k['ID_KHACHHANG'] ?>" <?= ($k['ID_KHACHHANG'] == ($ctm['ID_KHACHHANG'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($k['TEN_KH'] ?? $k['TENKH'] ?? '') ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="mb-3">
		<label class="form-label">Tổng tiền hàng</label>
		<input type="number" name="TONGTIENHANG" class="form-control" value="<?= htmlspecialchars($ctm['TONGTIENHANG'] ?? 0) ?>">
	</div>
	<div class="mb-3">
		<label class="form-label">Thuế (%)</label>
		<input type="number" name="THUE" class="form-control" value="<?= htmlspecialchars($ctm['THUE'] ?? 0) ?>">
	</div>

	<button class="btn btn-primary">Lưu</button>
	<a href="index.php?controller=chungtumua&action=detail&id=<?= $ctm['ID_CTMUA'] ?>" class="btn btn-secondary">Hủy</a>
			</form>
		</div>
		<div class="col-lg-4 d-none d-lg-block">
			<?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
		</div>
	</div>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
