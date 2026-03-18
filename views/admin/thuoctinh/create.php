<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <div class="row">
        <div class="col-lg-8">

            <!-- TIÊU ĐỀ -->
            <h2 class="mb-3">Tạo mới Thuộc Tính</h2>

            <!-- FORM THÊM MỚI -->
            <form method="post" action="" enctype="multipart/form-data">

                <!-- Tên thuộc tính -->
                <div class="mb-3">
                    <label class="form-label">Tên thuộc tính</label>
                    <input
                        type="text"
                        name="TEN"
                        class="form-control"
                        value="<?= htmlspecialchars($_POST['TEN'] ?? '') ?>"
                        required>
                </div>

                <!-- Giá trị -->
                <div class="mb-3">
                    <label class="form-label">Giá trị</label>
                    <input
                        type="text"
                        name="GIATRI"
                        class="form-control"
                        value="<?= htmlspecialchars($_POST['GIATRI'] ?? '') ?>">
                </div>

                <!-- Chọn hàng hóa -->
                <div class="mb-3">
                    <label class="form-label">Hàng hóa</label>
                    <select name="ID_HANGHOA" class="form-control">

                        <?php if (!empty($hanghoas)): ?>
                            <?php foreach ($hanghoas as $hh): ?>
                                <option
                                    value="<?= $hh['ID_HANGHOA'] ?>"
                                    <?= (!empty($_POST['ID_HANGHOA']) && $_POST['ID_HANGHOA'] == $hh['ID_HANGHOA']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($hh['TENHANGHOA']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        required

                    </select>
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>
                    <input type="file" name="HINHANH" class="form-control">
                </div>

                <!-- Nút bấm -->
                <button class="btn btn-primary">Lưu</button>
                <a href="index.php?controller=thuoctinh&action=index" class="btn btn-secondary">Hủy</a>

            </form>
        </div>

        <!-- SIDEBAR GỢI Ý / MẸO -->
        <div class="col-lg-4 d-none d-lg-block">
            <?php include ROOT . '/views/admin/layouts/edit_helper.php'; ?>
        </div>
    </div>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>