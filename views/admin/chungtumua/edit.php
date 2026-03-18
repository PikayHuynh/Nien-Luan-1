<?php
// ===============================
//  HEADER + SIDEBAR ADMIN
// ===============================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <div class="row">
        <!-- ===============================
             FORM CHỈNH SỬA
        ================================== -->
        <div class="col-lg-8">

            <h3>Chỉnh sửa Chứng Từ Mua #<?= htmlspecialchars($ctm['ID_CTMUA'] ?? '') ?></h3>

            <!-- FORM SUBMIT -->
            <form method="post" action="">

                <!-- Mã số chứng từ -->
                <div class="mb-3">
                    <label class="form-label">Mã số</label>
                    <input
                        type="text"
                        name="MASOCT"
                        class="form-control"
                        value="<?= htmlspecialchars($ctm['MASOCT'] ?? '') ?>">
                </div>

                <!-- Ngày phát sinh -->
                <div class="mb-3">
                    <label class="form-label">Ngày phát sinh</label>
                    <input
                        type="datetime-local"
                        name="NGAYPHATSINH"
                        class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($ctm['NGAYPHATSINH'] ?? date('Y-m-d H:i'))) ?>">
                </div>

                <!-- Chọn khách hàng -->
                <div class="mb-3">
                    <label class="form-label">Khách hàng</label>
                    <select name="ID_KHACHHANG" class="form-control">
                        <option value="">-- Chọn khách hàng --</option>

                        <?php foreach ($khachHangList as $k):
                            $kId = $k['ID_KHACHHANG'] ?? $k['ID_KHACH_HANG'] ?? '';
                        ?>
                            <option
                                value="<?= $kId ?>"
                                <?= ($kId == ($ctm['ID_KHACHHANG'] ?? '')) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['TEN_KH'] ?? $k['TENKH'] ?? 'Không rõ') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tổng tiền -->
                <div class="mb-3">
                    <label class="form-label">Tổng tiền hàng</label>
                    <input
                        type="number"
                        name="TONGTIENHANG"
                        class="form-control"
                        value="<?= htmlspecialchars($ctm['TONGTIENHANG'] ?? 0) ?>">
                </div>

                <!-- Thuế -->
                <div class="mb-3">
                    <label class="form-label">Thuế (%)</label>
                    <input
                        type="number"
                        name="THUE"
                        class="form-control"
                        value="<?= htmlspecialchars($ctm['THUE'] ?? 0) ?>">
                </div>

                <!-- Nút submit -->
                <button class="btn btn-primary">Lưu</button>

                <!-- Nút hủy -->
                <a
                    href="index.php?controller=chungtumua&action=detail&id=<?= $ctm['ID_CTMUA'] ?>"
                    class="btn btn-secondary">
                    Hủy
                </a>

            </form>
        </div>

        <!-- ===============================
             KHUNG HƯỚNG DẪN BÊN PHẢI
        ================================== -->
        <div class="col-lg-4 d-none d-lg-block">
            <?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
        </div>
    </div>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>