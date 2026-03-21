<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="mb-4 text-primary"><i class="bi bi-bell-fill me-2"></i>Thông báo của tôi</h2>
            
            <?php if (empty($notifications)): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-chat-left-dots text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 text-muted">Bạn chưa có thông báo nào.</h5>
                        <a href="index.php?controller=home&action=index" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm border-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($notifications as $n): ?>
                            <div class="list-group-item list-group-item-action py-3 border-bottom <?= $n['IS_READ'] ? '' : 'bg-light fw-bold' ?>">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class="bi <?= $n['LOAI'] == 'all' ? 'bi-megaphone' : 'bi-info-circle' ?> text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 text-dark"><?= htmlspecialchars($n['NOIDUNG']) ?></p>
                                            <small class="text-muted"><?= date('H:i, d/m/Y', strtotime($n['NGAYTAO'])) ?></small>
                                        </div>
                                    </div>
                                    <?php if (!$n['IS_READ']): ?>
                                        <span class="badge rounded-pill bg-danger">Mới</span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!$n['IS_READ']) $tbModel->markAsRead($n['ID']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Phân trang -->
                <?php if ($totalPages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?controller=user&action=notifications&page=<?= $currentPage - 1 ?>">« Ngược</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == $currentPage ? 'active' : '') ?>">
                                    <a class="page-link" href="?controller=user&action=notifications&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?controller=user&action=notifications&page=<?= $currentPage + 1 ?>">Tiếp »</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

                <div class="mt-4 text-center">
                    <p class="text-muted small">Trang <?= $currentPage ?> / <?= $totalPages ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
