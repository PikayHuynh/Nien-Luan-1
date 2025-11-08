<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Tổng Quan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="d-flex">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../includes/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-grow-1 p-4">
            <h2 class="mb-4">Tổng Quan Hệ Thống</h2>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title">Khách Hàng</h5>
                            <p class="display-6 fw-bold text-primary">128</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title">Sản Phẩm</h5>
                            <p class="display-6 fw-bold text-success">56</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title">Đơn Hàng</h5>
                            <p class="display-6 fw-bold text-warning">72</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title">Doanh Thu</h5>
                            <p class="display-6 fw-bold text-danger">25M</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4>Biểu đồ doanh thu (Demo)</h4>
                <div class="bg-white shadow-sm rounded p-4 text-center">
                    <p class="text-muted">[Khu vực hiển thị biểu đồ - tích hợp sau]</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
