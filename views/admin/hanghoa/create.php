<?php
// ======================================================================
//  INCLUDE HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- ===============================================================
         TIÊU ĐỀ TRANG
    ================================================================ -->
    <h2 class="mb-4">Thêm Hàng Hóa</h2>

    <!-- ===============================================================
         FORM THÊM HÀNG HÓA
         - enctype="multipart/form-data" để upload ảnh
    ================================================================ -->
    <form method="post" action="" enctype="multipart/form-data">

        <!-- Tên hàng hóa -->
        <div class="mb-3">
            <label class="form-label">Tên hàng hóa</label>
            <input type="text" name="TENHANGHOA" class="form-control" required>
        </div>

        <!-- Mô tả -->
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="MOTA" class="form-control" rows="4"></textarea>
        </div>

        <!-- Đơn vị tính -->
        <div class="mb-3">
            <label class="form-label">Đơn vị tính</label>
            <input type="text" name="DONVITINH" class="form-control">
        </div>

        <!-- Phân loại -->
        <div class="mb-3">
            <label class="form-label">Phân loại</label>
            <select name="ID_PHANLOAI" class="form-control">
                <option value="">-- Chọn phân loại --</option>

                <?php foreach ($phanloaiList as $p): ?>
                    <option value="<?= $p['ID_PHANLOAI'] ?>">
                        <?= htmlspecialchars($p['TENPHANLOAI']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- Giá bán (DONGIA_BAN) -->
        <div class="mb-3">
            <label class="form-label">Giá bán (VND)</label>
            <input type="number" name="DONGIA_BAN" class="form-control" value="0" required
                placeholder="Nhập giá bán trực tiếp">
        </div>

        <!-- Giá gốc (Dùng để tính Sale) -->
        <div class="mb-3">
            <label class="form-label">Giá gốc (VND)</label>
            <input type="number" name="GIAGOC" class="form-control"
                placeholder="Nhập giá gốc để hiển thị nhãn SALE nếu > giá bán">
        </div>

        <!-- Số lượng -->
        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="SOLUONG" class="form-control" value="0"
                placeholder="Nhập số lượng hiện có">
        </div>

        <!-- Ngày tạo (Dùng để tính nhãn NEW) -->
        <div class="mb-3">
            <label class="form-label">Ngày tạo</label>
            <input type="datetime-local" name="NGAYTAO" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
            <div class="form-text">Nhãn NEW sẽ hiển thị trong 3 ngày kể từ ngày này.</div>
        </div>

        <!-- Hình ảnh -->
        <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" name="HINHANH" class="form-control">
        </div>

        <!-- Nút hành động -->
        <button class="btn btn-primary">Lưu</button>
        <a href="index.php?controller=hanghoa&action=index" class="btn btn-secondary">
            Hủy
        </a>

    </form>
</div>

<?php
// ======================================================================
//  FOOTER ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>