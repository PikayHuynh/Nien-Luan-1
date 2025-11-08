<?php
// Nhúng module logic danh sách khách hàng
require_once __DIR__ . '/../../../module/khach_hang/list.php';

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khách Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold">Danh sách khách hàng</h2>
                <a href="form_add.php" class="btn btn-primary">+ Thêm khách hàng</a>
            </div>

            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên khách hàng</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Hình ảnh</th>
                        <th>Số B</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($khach_hang)): ?>
                        <?php foreach ($khach_hang as $kh): ?>
                            <tr>
                                <td><?= $kh['ID_KHACH_HANG'] ?></td>
                                <td><?= htmlspecialchars($kh['TEN_KH']) ?></td>
                                <td><?= htmlspecialchars($kh['DIACHI']) ?></td>
                                <td><?= htmlspecialchars($kh['SODIENTHOAI']) ?></td>
                                <td>
                                    <?php if ($kh['HINHANH']): ?>
                                        <img src="../../../uploads/<?= $kh['HINHANH'] ?>" alt="Ảnh" width="60" height="60" class="rounded">
                                    <?php else: ?>
                                        <span class="text-muted">Không có</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($kh['SOB']) ?></td>
                                <td class="text-center">
                                    <a href="form_edit.php?id=<?= $kh['ID_KHACH_HANG'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="../../../module/khach_hang/delete.php?id=<?= $kh['ID_KHACH_HANG'] ?>"
                                        onclick="return confirm('Bạn có chắc muốn xóa khách hàng này?')"
                                        class="btn btn-sm btn-danger">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Không có khách hàng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <!-- Nút Previous -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
                    </li>

                    <!-- Các số trang -->
                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Nút Next -->
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
    <!-- Footer -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
