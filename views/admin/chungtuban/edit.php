<?php
// ==============================
// Giao diện Header + Sidebar
// ==============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8">

            <!-- ========================================
                TIÊU ĐỀ TRANG
            ========================================== -->
            <h3>
                Chỉnh sửa Chứng Từ Bán #<?= htmlspecialchars($ct['ID_CTBAN'] ?? '') ?>
            </h3>

            <!-- ========================================
                FORM CHỈNH SỬA CHỨNG TỪ BÁN
            ========================================== -->
            <form method="post" action="">

                <!-- Mã số chứng từ -->
                <div class="mb-3">
                    <label class="form-label">Mã số</label>
                    <input type="text" name="MASOCT" class="form-control"
                        value="<?= htmlspecialchars($ct['MASOCT'] ?? '') ?>">
                </div>

                <!-- Ngày đặt hàng -->
                <div class="mb-3">
                    <label class="form-label">Ngày đặt</label>
                    <input type="datetime-local" name="NGAYDATHANG" class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($ct['NGAYDATHANG'] ?? date('Y-m-d H:i'))) ?>">
                </div>

                <!-- Chọn khách hàng -->
                <div class="mb-3">
                    <label class="form-label">Khách hàng</label>
                    <select name="ID_KHACHHANG" class="form-control">
                        <option value="">-- Chọn khách hàng --</option>

                        <?php foreach ($khachHangList as $k): ?>
                            <option value="<?= $k['ID_KHACH_HANG'] ?>" <?= ($k['ID_KHACH_HANG'] == ($ct['ID_KHACHHANG'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['TEN_KH'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Tổng tiền hàng -->
                <div class="mb-3">
                    <label class="form-label">Tổng tiền hàng</label>
                    <input type="number" name="TONGTIENHANG" class="form-control"
                        value="<?= htmlspecialchars($ct['TONGTIENHANG'] ?? 0) ?>">
                </div>

                <!-- Thuế -->
                <div class="mb-3">
                    <label class="form-label">Thuế (%)</label>
                    <input type="number" name="THUE" class="form-control"
                        value="<?= htmlspecialchars($ct['THUE'] ?? 0) ?>">
                </div>

                <!-- Trạng thái đơn hàng -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="TRANGTHAI" class="form-control">

                        <?php
                        // Danh sách các trạng thái mặc định
                        $statusOptions = [
                            'Đã giao hàng' => 'Đã giao hàng',
                            'Đang xử lý' => 'Đang xử lý',
                            'Đã hủy' => 'Đã hủy',
                        ];
                        $currentStatus = $ct['TRANGTHAI'] ?? '';

                        foreach ($statusOptions as $val => $label): ?>
                            <option value="<?= htmlspecialchars($val) ?>" <?= ($currentStatus === $val) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- Ghi chú -->
                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="GHICHU" class="form-control" rows="3">
                        <?= htmlspecialchars($ct['GHICHU'] ?? '') ?>
                    </textarea>
                </div>


                <!-- ========================================
                    BẢNG CHỈNH SỬA CHI TIẾT HÀNG HÓA
                ========================================== -->
                <h5 class="mt-4">Chi tiết hàng hóa</h5>

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

                                    <!-- Chọn hàng hóa -->
                                    <td>
                                        <select name="ID_HANGHOA[]" class="form-control">
                                            <option value="">-- Chọn hàng --</option>

                                            <?php foreach ($hangHoaList as $hh): ?>
                                                <option value="<?= $hh['ID_HANGHOA'] ?>" <?= ($hh['ID_HANGHOA'] == ($item['ID_HANGHOA'] ?? '')) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($hh['TENHANGHOA'] ?? '') ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </td>

                                    <!-- Số lượng -->
                                    <td>
                                        <input type="number" name="SOLUONG[]" class="form-control"
                                            value="<?= htmlspecialchars($item['SOLUONG'] ?? 1) ?>">
                                    </td>

                                    <!-- Đơn giá -->
                                    <td>
                                        <input type="number" name="DONGIA[]" class="form-control"
                                            value="<?= htmlspecialchars($item['GIABAN'] ?? ($item['DONGIA'] ?? 0)) ?>">
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="3" class="text-muted text-center">
                                    Không có chi tiết hàng hóa
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Nút lưu & hủy -->
                <button class="btn btn-primary">Lưu</button>
                <a href="index.php?controller=chungtuban&action=detail&id=<?= $ct['ID_CTBAN'] ?>"
                    class="btn btn-secondary">Hủy</a>

            </form>

        </div>
    </div>
</div>

<?php
// ==============================
// Giao diện Footer
// ==============================
include ROOT . '/views/admin/layouts/footer.php';
?>