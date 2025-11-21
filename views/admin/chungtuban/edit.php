<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">
            <h3>Chỉnh sửa Chứng Từ Bán #<?= htmlspecialchars($ct['ID_CTBAN'] ?? '') ?></h3>

            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Mã số</label>
                    <input type="text" name="MASOCT" class="form-control" value="<?= htmlspecialchars($ct['MASOCT'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày đặt</label>
                    <input type="datetime-local" name="NGAYDATHANG" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($ct['NGAYDATHANG'] ?? date('Y-m-d H:i'))) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Khách hàng</label>
                    <select name="ID_KHACHHANG" class="form-control">
                        <option value="">-- Chọn khách hàng --</option>
                        <?php foreach ($khachHangList as $k): ?>
                            <option value="<?= $k['ID_KHACH_HANG'] ?>" <?= ($k['ID_KHACH_HANG'] == ($ct['ID_KHACHHANG'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($k['TEN_KH'] ?? '') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tổng tiền hàng</label>
                    <input type="number" name="TONGTIENHANG" class="form-control" value="<?= htmlspecialchars($ct['TONGTIENHANG'] ?? 0) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Thuế (%)</label>
                    <input type="number" name="THUE" class="form-control" value="<?= htmlspecialchars($ct['THUE'] ?? 0) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="TRANGTHAI" class="form-control">
                        <?php
                        $statusOptions = [
                            'Đã giao hàng' => 'Đã giao hàng',
                            'Hoàn thành' => 'Hoàn thành',
                            'Đang xử lý' => 'Đang xử lý',
                            'Đã hủy' => 'Đã hủy',
                        ];
                        $currentStatus = $ct['TRANGTHAI'] ?? '';
                        foreach ($statusOptions as $val => $label): ?>
                            <option value="<?= htmlspecialchars($val) ?>" <?= ($currentStatus == $val) ? 'selected' : '' ?>><?= htmlspecialchars($label) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="GHICHU" class="form-control" rows="3"><?= htmlspecialchars($ct['GHICHU'] ?? '') ?></textarea>
                </div>

                <h5>Chi tiết hàng hóa</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Hàng hóa</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ctChiTiet)): ?>
                            <?php foreach ($ctChiTiet as $item): ?>
                                <tr>
                                    <td>
                                        <select name="ID_HANGHOA[]" class="form-control">
                                            <option value="">-- Chọn hàng --</option>
                                            <?php foreach ($hangHoaList as $hh): ?>
                                                <option value="<?= $hh['ID_HANGHOA'] ?>" <?= ($hh['ID_HANGHOA'] == ($item['ID_HANGHOA'] ?? '')) ? 'selected' : '' ?>><?= htmlspecialchars($hh['TENHANGHOA'] ?? '') ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td><input type="number" name="SOLUONG[]" class="form-control" value="<?= htmlspecialchars($item['SOLUONG'] ?? 1) ?>"></td>
                                    <td><input type="number" name="DONGIA[]" class="form-control" value="<?= htmlspecialchars($item['GIABAN'] ?? $item['DONGIA'] ?? 0) ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-muted">Không có chi tiết hàng hóa</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <button class="btn btn-primary">Lưu</button>
                <a href="index.php?controller=chungtuban&action=detail&id=<?= $ct['ID_CTBAN'] ?>" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
