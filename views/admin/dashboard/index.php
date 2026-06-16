<?php
// ======================================================================
//  HEADER + SIDEBAR CHO GIAO DIỆN ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<h2 class="mb-4">Dashboard Quản Lý</h2>

<?php
// ======================================================================
//  DANH SÁCH MODULE HIỂN THỊ TRÊN DASHBOARD
//  - Mỗi module có: số lượng, đường dẫn quản lý, màu nền.
// ======================================================================

$modules = [
    'Khách Hàng' => [
        'count' => $data['khachhang'] ?? 0,
        'link' => 'index.php?controller=khachhang&action=index',
        'color' => 'primary'
    ],
    'Phân Loại' => [
        'count' => $data['phanloai'] ?? 0,
        'link' => 'index.php?controller=phanloai&action=index',
        'color' => 'success'
    ],
    'Hàng Hóa' => [
        'count' => $data['hanghoa'] ?? 0,
        'link' => 'index.php?controller=hanghoa&action=index',
        'color' => 'warning'
    ],
    'Thuộc Tính' => [
        'count' => $data['thuoctinh'] ?? 0,
        'link' => 'index.php?controller=thuoctinh&action=index',
        'color' => 'info'
    ],
    'Đơn Giá Bán' => [
        'count' => $data['dongiaban'] ?? 0,
        'link' => 'index.php?controller=dongiaban&action=index',
        'color' => 'secondary'
    ],
    'Chứng Từ Mua' => [
        'count' => $data['chungtumua'] ?? 0,
        'link' => 'index.php?controller=chungtumua&action=index',
        'color' => 'danger'
    ],
    'Chứng Từ Bán' => [
        'count' => $data['chungtuban'] ?? 0,
        'link' => 'index.php?controller=chungtuban&action=index',
        'color' => 'dark'
    ],
];
?>

<div class="row row-cols-1 row-cols-md-3 g-4">

    <?php foreach ($modules as $name => $info): ?>
        <!-- ===============================
            CARD MODULE TỪNG MỤC QUẢN LÝ
        ================================ -->
        <div class="col">
            <div class="card text-white bg-<?= htmlspecialchars($info['color']) ?> mb-3 h-100">

                <div class="card-body d-flex flex-column justify-content-between">

                    <!-- Tên module -->
                    <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>

                    <!-- Số lượng -->
                    <p class="card-text fs-4">
                        <?= htmlspecialchars($info['count']) ?>
                    </p>

                    <!-- Link điều hướng -->
                    <a href="<?= htmlspecialchars($info['link']) ?>" class="btn btn-light btn-sm mt-auto">
                        Xem chi tiết
                    </a>

                </div>
            </div>
        </div>

    <?php endforeach; ?>

</div>

<!-- BIỂU ĐỒ DOANH THU -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Biểu Đồ Doanh Thu Tháng <?= date('m/Y') ?></h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');

    // Dữ liệu từ Controller
    const rawData = <?= json_encode($data['revenueData']) ?>;

    // Chuẩn bị label (ngày) và data (doanh thu)
    // Tạo mảng ngày từ 1 đến hết tháng
    const daysInMonth = new Date(<?= date('Y') ?>, <?= date('m') ?>, 0).getDate();
    const labels = Array.from({
        length: daysInMonth
    }, (_, i) => i + 1);

    // Map doanh thu vào đúng ngày
    const revenueMap = {};
    rawData.forEach(item => {
        revenueMap[item.day] = parseFloat(item.revenue);
    });

    const dataPoints = labels.map(day => revenueMap[day] || 0);

    const chart = new Chart(ctx, {
        type: 'bar', // Hoặc 'line'
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh Thu (VNĐ)',
                data: dataPoints,
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Triệu VNĐ'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Ngày trong tháng'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(context.raw);
                        }
                    }
                }
            }
        }
    });
</script>

<?php
// ======================================================================
//  FOOTER ADMIN
// ======================================================================
include ROOT . '/views/admin/layouts/footer.php';
?>