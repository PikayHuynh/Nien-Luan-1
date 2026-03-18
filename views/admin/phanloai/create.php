<?php
// ======================================================================
//  HEADER + SIDEBAR
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">
    <div class="row">

        <!-- ==========================================================
			 FORM TẠO MỚI PHÂN LOẠI
		========================================================== -->
        <div class="col-lg-8">

            <h2 class="mb-3">Tạo mới Phân Loại</h2>

            <form method="post" action="" enctype="multipart/form-data">

                <!-- Tên phân loại -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên phân loại</label>
                    <input
                        type="text"
                        name="TENPHANLOAI"
                        class="form-control"
                        value="<?= htmlspecialchars($_POST['TENPHANLOAI'] ?? '') ?>"
                        required>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea
                        name="MOTA"
                        class="form-control"
                        rows="4"><?= htmlspecialchars($_POST['MOTA'] ?? '') ?></textarea>
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Hình ảnh</label>
                    <input
                        type="file"
                        name="HINHANH"
                        class="form-control">
                </div>

                <!-- Nút thao tác -->
                <button class="btn btn-primary">Lưu</button>
                <a href="index.php?controller=phanloai&action=index" class="btn btn-secondary">Hủy</a>

            </form>
        </div>

        <!-- Sidebar phụ bên phải (mẹo nhập liệu) -->
        <div class="col-lg-4 d-none d-lg-block">
            <?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
        </div>

    </div>
</div>

<?php
// ======================================================================
//  FOOTER
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>