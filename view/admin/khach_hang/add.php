<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="fw-bold mb-3">Thêm khách hàng mới</h2>

        <form action="../../../modules/khach_hang/add.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Tên khách hàng</label>
                <input type="text" name="TENKH" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="DIACHI" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="SODIENTHOAI" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Hình ảnh (tùy chọn)</label>
                <input type="text" name="HINHANH" placeholder="Tên file ảnh (nếu có)" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Số B</label>
                <input type="number" name="SOB" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-success">Thêm</button>
            </div>
        </form>
    </div>
</body>
</html>
