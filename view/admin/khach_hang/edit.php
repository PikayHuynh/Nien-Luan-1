<?php
require_once __DIR__ . '/../../../config/db_connect.php';

if (!isset($_GET['id'])) {
    die("Thiếu ID khách hàng!");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM KHACH_HANG WHERE ID_KHACH_HANG = :id");
$stmt->execute([':id' => $id]);
$kh = $stmt->fetch();

if (!$kh) {
    die("Không tìm thấy khách hàng!");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="fw-bold mb-3">Sửa thông tin khách hàng</h2>

        <form action="../../../modules/khach_hang/edit.php" method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="ID_KHACH_HANG" value="<?= $kh['ID_KHACH_HANG'] ?>">

            <div class="mb-3">
                <label class="form-label">Tên khách hàng</label>
                <input type="text" name="TENKH" value="<?= htmlspecialchars($kh['TEN_KH']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="DIACHI" value="<?= htmlspecialchars($kh['DIACHI']) ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="SODIENTHOAI" value="<?= htmlspecialchars($kh['SODIENTHOAI']) ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Hình ảnh</label>
                <input type="text" name="HINHANH" value="<?= htmlspecialchars($kh['HINHANH']) ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Số B</label>
                <input type="number" name="SOB" value="<?= htmlspecialchars($kh['SOB']) ?>" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-warning">Cập nhật</button>
            </div>
        </form>
    </div>
</body>
</html>
