<?php
// ======================================================================
//  HEADER + SIDEBAR ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- TIÊU ĐỀ -->
    <h2 class="mb-3">
        Chi tiết Thuộc Tính #<?= htmlspecialchars($thuoctinh['ID_THUOCTINH'] ?? '') ?>
    </h2>

    <!-- ===============================================================
         THÔNG TIN THUỘC TÍNH
    ================================================================ -->
    <table class="table table-bordered">

        <tr>
            <th style="width:200px;">Tên thuộc tính</th>
            <td><?= htmlspecialchars($thuoctinh['TEN'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Giá trị</th>
            <td><?= htmlspecialchars($thuoctinh['GIATRI'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Thuộc hàng hóa</th>
            <td><?= htmlspecialchars($thuoctinh['TENHANGHOA'] ?? '') ?></td>
        </tr>

        <tr>
            <th>Hình ảnh</th>
            <td>
                <?php if (!empty($thuoctinh['HINHANH'])): ?>
                    <img
                        src="upload/<?= htmlspecialchars($thuoctinh['HINHANH']) ?>"
                        style="max-width:300px; border-radius:6px;">
                <?php else: ?>
                    <span class="text-muted">Không có hình ảnh</span>
                <?php endif; ?>
            </td>
        </tr>

    </table>

    <!-- NÚT TÁC VỤ -->
    <a
        href="index.php?controller=thuoctinh&action=edit&id=<?= $thuoctinh['ID_THUOCTINH'] ?>"
        class="btn btn-warning">
        Sửa
    </a>

    <a
        href="index.php?controller=thuoctinh&action=index"
        class="btn btn-secondary">
        Quay lại
    </a>

</div>

<?php
// FOOTER ADMIN
include ROOT . '/views/admin/layouts/footer.php';
?>