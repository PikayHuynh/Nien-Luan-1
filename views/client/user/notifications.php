<?php 
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';
?>

<div class="container mt-5 mb-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div class="d-flex align-items-center mb-5">
                <div class="p-3 rounded-circle bg-glass border border-white-10 me-3 shadow-lg">
                    <i class="bi bi-bell text-primary fs-3"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-white">Thông báo của tôi</h2>
                    <p class="text-muted small mb-0">Cập nhật những tin tức mới nhất từ hệ thống</p>
                </div>
            </div>
            
            <?php if (empty($notifications)): ?>
                <div class="card bg-glass border-white-10 text-center py-5 rounded-4 shadow-lg">
                    <div class="mb-4 opacity-25">
                        <i class="bi bi-chat-dots-fill display-1"></i>
                    </div>
                    <h4 class="text-white fw-bold">Hộp thư trống</h4>
                    <p class="text-muted mb-4">Bạn chưa nhận được thông báo nào từ chúng tôi.</p>
                    <a href="index.php?controller=home&action=index" class="btn btn-primary px-5 rounded-pill shadow-lg">
                        Tiếp tục mua sắm
                    </a>
                </div>
            <?php else: ?>
                <div class="notification-list d-flex flex-column gap-3">
                    <?php foreach ($notifications as $n): 
                        $isNew = !$n['IS_READ'];
                        $icon = $n['LOAI'] == 'all' ? 'bi-megaphone' : 'bi-info-circle';
                        $iconClass = $n['LOAI'] == 'all' ? 'text-warning' : 'text-primary';
                    ?>
                        <div class="card bg-glass border-white-10 rounded-4 p-3 shadow-sm transition-all hover-lift <?= $isNew ? 'border-primary-40' : '' ?>">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="rounded-circle bg-dark-soft border border-white-5 p-2 flex-shrink-0">
                                        <i class="bi <?= $icon ?> <?= $iconClass ?> fs-5"></i>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-white <?= $isNew ? 'fw-bold' : '' ?>"><?= htmlspecialchars($n['NOIDUNG']) ?></p>
                                        <div class="d-flex align-items-center gap-2">
                                            <small class="text-muted"><i class="bi bi-clock me-1"></i><?= date('H:i, d/m/Y', strtotime($n['NGAYTAO'])) ?></small>
                                            <?php if ($isNew): ?>
                                                <span class="badge bg-danger rounded-pill px-2" style="font-size: 0.65rem;">MỚI</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <button class="btn btn-link text-muted p-0 text-decoration-none border-0" title="Chi tiết">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                            <?php if ($isNew && isset($tbModel)) $tbModel->markAsRead($n['ID']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- PAGINATION -->
                <?php if ($totalPages > 1): ?>
                    <nav class="mt-5">
                        <ul class="pagination justify-content-center gap-2 border-0">
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link rounded-circle border-white-10 bg-glass" href="?controller=user&action=notifications&page=<?= $currentPage - 1 ?>">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == $currentPage ? 'active' : '') ?>">
                                    <a class="page-link rounded-circle border-white-10 bg-glass" href="?controller=user&action=notifications&page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link rounded-circle border-white-10 bg-glass" href="?controller=user&action=notifications&page=<?= $currentPage + 1 ?>">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>
