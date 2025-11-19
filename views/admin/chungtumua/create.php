<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<h3>Tạo Chứng Từ Mua</h3>

<form method="post" action="">
    <div class="mb-3">
        <label class="form-label">Mã số</label>
        <input type="text" name="MASOCT" class="form-control" value="<?= 'CTM-' . time() ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Ngày phát sinh</label>
        <input type="datetime-local" name="NGAYPHATSINH" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Khách hàng</label>
        <select name="ID_KHACHHANG" class="form-control">
            <option value="">-- Chọn khách hàng --</option>
            <?php foreach ($kh as $k): ?>
                <option value="<?= $k['ID_KHACHHANG'] ?>"><?= htmlspecialchars($k['TENKH']) ?? htmlspecialchars($k['TEN_KH'] ?? $k['TENPHU']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Tổng tiền hàng</label>
        <input type="number" name="TONGTIENHANG" class="form-control" value="0">
    </div>
    <div class="mb-3">
        <label class="form-label">Thuế (%)</label>
        <input type="number" name="THUE" class="form-control" value="0">
    </div>

    <button class="btn btn-primary">Tạo mới</button>
    <a href="index.php?controller=chungtumua&action=index" class="btn btn-secondary">Hủy</a>
</form>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>