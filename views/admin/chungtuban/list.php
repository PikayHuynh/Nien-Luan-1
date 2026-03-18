<?php
// ==================================
//  HEADER + SIDEBAR QUẢN TRỊ
// ==================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">

    <!-- ============================
        TIÊU ĐỀ TRANG
    ================================ -->
    <h2>Danh sách Chứng Từ Bán</h2>

    <!-- Form tìm kiếm -->
    <form method="GET" class="mb-3 adminSearchForm">
        <input type="hidden" name="controller" value="chungtuban">
        <input type="hidden" name="action" value="index">
        <div class="input-group" style="max-width: 400px;">
            <input type="text"
                name="q"
                class="form-control adminSearchInput"
                placeholder="Tìm theo tên khách hàng..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>


    <!-- ============================
        BẢNG DANH SÁCH CHỨNG TỪ BÁN
    ================================ -->
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Mã CT</th>
                <th>Ngày Đặt</th>
                <th>Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Thuế</th>
                <th>Tổng Cộng</th>
                <th>Trạng Thái</th>
                <th style="width: 180px;">Hành Động</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data as $ct): ?>

                <tr>
                    <!-- ID chứng từ -->
                    <td><?= htmlspecialchars($ct['ID_CTBAN'] ?? '') ?></td>

                    <!-- Mã số chứng từ -->
                    <td><?= htmlspecialchars($ct['MASOCT'] ?? '') ?></td>

                    <!-- Ngày đặt hàng -->
                    <td><?= htmlspecialchars($ct['NGAYDATHANG'] ?? '') ?></td>

                    <!-- Tên khách hàng -->
                    <td>
                        <?php
                        // Lấy thông tin khách hàng theo ID
                        $kh = $khModel->getById($ct['ID_KHACHHANG'] ?? 0);
                        echo htmlspecialchars($kh['TEN_KH'] ?? 'Không xác định');
                        ?>
                    </td>

                    <!-- Tổng tiền trước thuế -->
                    <td><?= number_format($ct['TONGTIENHANG'] ?? 0, 0, ',', '.') ?> VND</td>

                    <!-- Thuế (%) -->
                    <td><?= number_format($ct['THUE'] ?? 0) ?>%</td>

                    <!-- Tổng cộng -->
                    <td><?= number_format($ct['TONGCONG'] ?? 0, 0, ',', '.') ?> VND</td>

                    <!-- Trạng thái đơn -->
                    <td><?= htmlspecialchars($ct['TRANGTHAI'] ?? '') ?></td>

                    <!-- Nút hành động -->
                    <td>
                        <a href="index.php?controller=chungtuban&action=detail&id=<?= $ct['ID_CTBAN'] ?>"
                            class="btn btn-sm btn-info">
                            Xem chi tiết
                        </a>

                        <a href="index.php?controller=chungtuban&action=edit&id=<?= $ct['ID_CTBAN'] ?>"
                            class="btn btn-sm btn-warning">
                            Sửa
                        </a>

                        <a href="index.php?controller=chungtuban&action=delete&id=<?= $ct['ID_CTBAN'] ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc muốn xóa chứng từ này không?')">
                            Xóa
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ============================
        PHÂN TRANG
    ================================ -->
    <nav>
        <ul class="pagination justify-content-center">

            <!-- Nút Prev -->
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?controller=chungtuban&action=index&page=<?= $currentPage - 1 ?>">
                        « Prev
                    </a>
                </li>
            <?php endif; ?>

            <!-- Các nút số trang -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?controller=chungtuban&action=index&page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Nút Next -->
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?controller=chungtuban&action=index&page=<?= $currentPage + 1 ?>">
                        Next »
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

</div>

<?php
// FOOTER QUẢN TRỊ
include ROOT . '/views/admin/layouts/footer.php';
?>