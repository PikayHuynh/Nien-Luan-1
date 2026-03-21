<?php
include ROOT . '/views/admin/layouts/header.php';
include ROOT . '/views/admin/layouts/sidebar.php';
?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-bell me-2"></i>Lịch sử thông báo Admin</h2>

    <?php if (empty($notifications)): ?>
        <div class="alert alert-info">Chưa có thông báo nào.</div>
    <?php else: ?>
        <div class="list-group shadow-sm">
            <?php foreach ($notifications as $n): ?>
                <div class="list-group-item list-group-item-action py-3 <?= $n['IS_READ'] ? '' : 'bg-light border-start border-primary border-4' ?>">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 fw-bold"><?= htmlspecialchars($n['NOIDUNG']) ?></h6>
                        <small class="text-muted"><?= date('H:i - d/m/Y', strtotime($n['NGAYTAO'])) ?></small>
                    </div>
                    <?php if (!$n['IS_READ']): ?>
                        <span class="badge bg-primary">Mới</span>
                    <?php endif; ?>
                </div>
                <?php 
                // Đánh dấu đã đọc ngay khi hiển thị (hoặc dùng nút riêng)
                if (!$n['IS_READ']) $tbModel->markAsRead($n['ID']);
                ?>
            <?php endforeach; ?>
        </div>

        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?controller=dashboard&action=notifications&page=<?= $currentPage - 1 ?>">«</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $currentPage ? 'active' : '') ?>">
                            <a class="page-link" href="?controller=dashboard&action=notifications&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?controller=dashboard&action=notifications&page=<?= $currentPage + 1 ?>">»</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php?controller=dashboard&action=index" class="btn btn-secondary">Quay lại Dashboard</a>
    </div>
</div>

<?php
include ROOT . '/views/admin/layouts/footer.php';
?>
