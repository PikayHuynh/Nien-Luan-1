<?php include ROOT . '/views/admin/layouts/header.php'; ?>
<?php include ROOT . '/views/admin/layouts/sidebar.php'; ?>

<h2 class="mb-4">Dashboard Quản Lý</h2>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    $modules = [
        'Khách Hàng' => ['count'=>$data['khachhang'] ?? 0,'link'=>'index.php?controller=khachhang&action=index','color'=>'primary'],
        'Phân Loại' => ['count'=>$data['phanloai'] ?? 0,'link'=>'index.php?controller=phanloai&action=index','color'=>'success'],
        'Hàng Hóa' => ['count'=>$data['hanghoa'] ?? 0,'link'=>'index.php?controller=hanghoa&action=index','color'=>'warning'],
        'Thuộc Tính' => ['count'=>$data['thuoctinh'] ?? 0,'link'=>'index.php?controller=thuoctinh&action=index','color'=>'info'],
        'Đơn Giá Bán' => ['count'=>$data['dongiaban'] ?? 0,'link'=>'index.php?controller=dongiaban&action=index','color'=>'secondary'],
        'Chứng Từ Mua' => ['count'=>$data['chungtumua'] ?? 0,'link'=>'index.php?controller=chungtumua&action=index','color'=>'danger'],
        'Chứng Từ Bán' => ['count'=>$data['chungtuban'] ?? 0,'link'=>'index.php?controller=chungtuban&action=index','color'=>'dark'],
    ];

    foreach($modules as $name=>$info): ?>
        <div class="col">
            <div class="card text-white bg-<?= $info['color'] ?> mb-3 h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><?= $name ?></h5>
                    <p class="card-text fs-4"><?= $info['count'] ?></p>
                    <a href="<?= $info['link'] ?>" class="btn btn-light btn-sm mt-auto">Xem chi tiết</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include ROOT . '/views/admin/layouts/footer.php'; ?>
