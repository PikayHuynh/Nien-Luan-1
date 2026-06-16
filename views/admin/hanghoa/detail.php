<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- ===============================================================
         TIÊU ĐỀ TRANG
    ================================================================ -->
    <h2 class="mb-4">
        Chi tiết Hàng Hóa
        #<?= htmlspecialchars($hanghoa['ID_HANGHOA'] ?? '') ?>
    </h2>

    <!-- ===============================================================
         BẢNG HIỂN THỊ CHI TIẾT HÀNG HÓA
    ================================================================ -->
    <table class="table table-bordered">

        <!-- ID -->
        <tr>
            <th style="width:180px">ID</th>
            <td><?= htmlspecialchars($hanghoa['ID_HANGHOA'] ?? '') ?></td>
        </tr>

        <!-- Tên hàng hóa -->
        <tr>
            <th>Tên</th>
            <td><?= htmlspecialchars($hanghoa['TENHANGHOA'] ?? '') ?></td>
        </tr>

        <!-- Mô tả -->
        <tr>
            <th>Mô tả</th>
            <td><?= nl2br(htmlspecialchars($hanghoa['MOTA'] ?? '')) ?></td>
        </tr>

        <!-- Đơn vị tính -->
        <tr>
            <th>Đơn vị</th>
            <td><?= htmlspecialchars($hanghoa['DONVITINH'] ?? '') ?></td>
        </tr>

        <!-- Phân loại -->
        <tr>
            <th>Phân loại</th>
            <td><?= htmlspecialchars($hanghoa['TENPHANLOAI'] ?? '') ?></td>
        </tr>

        <!-- Giá gốc -->
        <tr>
            <th>Giá gốc</th>
            <td><?= number_format($hanghoa['GIAGOC'] ?? 0) ?> VND</td>
        </tr>

        <!-- Số lượng -->
        <tr>
            <th>Số lượng</th>
            <td><?= htmlspecialchars($hanghoa['SOLUONG'] ?? 0) ?></td>
        </tr>

        <!-- Ngày tạo -->
        <tr>
            <th>Ngày tạo</th>
            <td><?= htmlspecialchars($hanghoa['NGAYTAO'] ?? '') ?></td>
        </tr>

        <!-- Hình ảnh -->
        <tr>
            <th>Hình ảnh</th>
            <td>
                <img src="upload/<?= (!empty($hanghoa['HINHANH']) ? htmlspecialchars($hanghoa['HINHANH']) : 'item-default.png') ?>"
                    style="max-width:200px; border-radius:6px; border:1px solid #ddd;"
                    onerror="this.src='upload/item-default.png'; this.onerror=null;">
            </td>
        </tr>

    </table>

    <!-- ===============================================================
        NÚT HÀNH ĐỘNG
    ================================================================ -->
    <a href="index.php?controller=hanghoa&action=edit&id=<?= $hanghoa['ID_HANGHOA'] ?>" class="btn btn-primary">
        Sửa
    </a>

    <a href="index.php?controller=hanghoa&action=index" class="btn btn-secondary">
        Quay lại
    </a>

</div>

<?php
// ======================================================================
//  FOOTER ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>