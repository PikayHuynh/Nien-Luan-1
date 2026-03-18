<?php
// ===============================================================
//  HEADER + SIDEBAR ADMIN
// ===============================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <div class="row">

        <!-- ========================== -->
        <!-- FORM CHỈNH SỬA PHÂN LOẠI -->
        <!-- ========================== -->
        <div class="col-lg-8">

            <h2 class="mb-3">
                Chỉnh sửa Phân loại #<?= htmlspecialchars($phanloai['ID_PHANLOAI'] ?? '') ?>
            </h2>

            <form method="post" action="" enctype="multipart/form-data">

                <!-- Tên phân loại -->
                <div class="mb-3">
                    <label class="form-label">Tên phân loại</label>
                    <input
                        type="text"
                        name="TENPHANLOAI"
                        class="form-control"
                        value="<?= htmlspecialchars($phanloai['TENPHANLOAI'] ?? '') ?>"
                        required>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea
                        name="MOTA"
                        class="form-control"
                        rows="4"><?= htmlspecialchars($phanloai['MOTA'] ?? '') ?></textarea>
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>

                    <?php if (!empty($phanloai['HINHANH'])): ?>
                        <div class="mb-2">
                            <img
                                src="upload/<?= htmlspecialchars($phanloai['HINHANH']) ?>"
                                alt="Hình phân loại"
                                style="max-width:200px; border-radius:6px;">
                        </div>
                    <?php endif; ?>

                    <input
                        type="file"
                        name="HINHANH"
                        class="form-control">
                </div>

                <!-- Nút lưu -->
                <button class="btn btn-primary">Lưu</button>

                <!-- Nút hủy -->
                <a
                    href="index.php?controller=phanloai&action=index"
                    class="btn btn-secondary">
                    Hủy
                </a>

            </form>
        </div>

        <!-- SIDEBAR GỢI Ý / MẸO -->
        <div class="col-lg-4 d-none d-lg-block">
            <?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
        </div>

    </div>

</div>

<?php
// FOOTER
include ROOT . '/views/admin/layouts/footer.php';
?>