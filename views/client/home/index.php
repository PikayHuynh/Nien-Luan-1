<div class="lp-mesh-gradient min-vh-100 pb-5 position-relative">
    <!-- Decorative Blobs -->
    <div class="bg-blur-blob" style="top: 10%; left: -5%; width: 500px; height: 500px; opacity: 0.2;"></div>
    <div class="bg-blur-blob" style="top: 40%; right: -10%; background: linear-gradient(135deg, #3b82f6, #ec4899); width: 400px; height: 400px; opacity: 0.15;"></div>
    
    <!-- HERO SECTION -->
    <section class="hero-section pt-5 pb-5 mb-5 overflow-hidden">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 my-auto text-center text-lg-start animate__animated animate__fadeInLeft">
                    <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 fw-bold animate__animated animate__fadeInDown">
                        <i class="bi bi-stars me-1"></i> PIKAY SHOP PREIMIUM
                    </span>
                    <h1 class="display-1 fw-black mb-4 text-white">
                        Kiệt tác <br><span class="text-gradient-premium">Công nghệ</span> <br>Tầm cao mới
                    </h1>
                    <p class="lead mb-5 text-white-50 fs-4">
                        Khám phá bộ sưu tập sản phẩm công nghệ đẳng cấp nhất thế giới. Từ iPhone, MacBook đến những phụ kiện tinh tế nhất.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-4">
                        <a class="btn btn-premium-glow btn-lg px-5 py-3 rounded-pill position-relative" style="z-index: 10;" href="index.php?controller=product&action=list">
                            <i class="bi bi-shop me-2"></i> Mua sắm ngay
                        </a>
                        <a class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill glass-button position-relative" style="z-index: 10;" href="index.php?controller=user&action=register">
                            Tham gia cộng đồng
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 animate__animated animate__fadeInRight animate__delay-1s">
                    <div class="position-relative ps-lg-5">
                        <div class="hero-image-container floating">
                             <img src="upload/hero_banner.png" 
                                  class="img-fluid rounded-5 shadow-2xl" 
                                  alt="Pikay Shop Hero Content">
                        </div>
                        <!-- Thẻ trang trí -->
                        <div class="position-absolute bottom-0 start-0 glass-card p-3 animate__animated animate__fadeInUp animate__delay-2s d-none d-md-block" style="transform: translate(-20px, 20px);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success rounded-circle p-2">
                                    <i class="bi bi-shield-check text-white"></i>
                                </div>
                                <div class="small">
                                    <div class="fw-bold text-white">100% Chính hãng</div>
                                    <div class="text-white-50">Bảo hành toàn quốc</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-n4">
        <!-- FEATURE BAR -->
        <section class="feature-bar mb-5 position-relative z-3 reveal">
            <div class="glass-card p-4 shadow-xl">
                <div class="row g-4 text-center">
                    <div class="col-6 col-md-3 border-end border-white-10">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-truck fs-3 text-primary mb-2"></i>
                            <h6 class="fw-bold mb-0 text-white">Giao hàng 2h</h6>
                            <span class="text-white-50 small">Nội thành miễn phí</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 border-end-md border-white-10">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-arrow-repeat fs-3 text-primary mb-2"></i>
                            <h6 class="fw-bold mb-0 text-white">Đổi trả 7 ngày</h6>
                            <span class="text-white-50 small">Lỗi là đổi mới</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 border-end border-white-10">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-headset fs-3 text-primary mb-2"></i>
                            <h6 class="fw-bold mb-0 text-white">Hỗ trợ 24/7</h6>
                            <span class="text-white-50 small">Tận tâm phục vụ</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-credit-card fs-3 text-primary mb-2"></i>
                            <h6 class="fw-bold mb-0 text-white">Trả góp 0%</h6>
                            <span class="text-white-50 small">Qua thẻ tín dụng</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DANH MỤC NỔI BẬT -->
        <?php if (!empty($categories)): ?>
        <section class="categories-overhaul mb-5 section-container reveal">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="section-title-premium h1 fw-bold text-white">Khám phá theo nhu cầu</h2>
                    <p class="text-white-50 mb-0">Lựa chọn dòng sản phẩm phù hợp với phong cách của bạn</p>
                </div>
                <a href="index.php?controller=product&action=list" class="btn btn-outline-primary rounded-pill px-4 glass-button">
                    Tất cả <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">
                <?php 
                $catImages = [
                    'Điện Thoại' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?q=80&w=600&auto=format&fit=crop',
                    'Dien Thoai' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?q=80&w=600&auto=format&fit=crop',
                    'Máy Tính Bảng' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?q=80&w=600&auto=format&fit=crop',
                    'May Tinh Bang' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?q=80&w=600&auto=format&fit=crop',
                    'Laptop' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=600&auto=format&fit=crop',
                    'Máy tính' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=600&auto=format&fit=crop',
                    'Phụ kiện' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=600&auto=format&fit=crop',
                    'Phu kien' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=600&auto=format&fit=crop',
                    'MacBook' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=600&auto=format&fit=crop',
                    'iPad' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?q=80&w=600&auto=format&fit=crop',
                    'iPhone' => 'https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?q=80&w=600&auto=format&fit=crop',
                    'Default' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=600&auto=format&fit=crop'
                ];
                foreach (array_slice($categories, 0, 4) as $category): 
                    $catName = $category['TENPHANLOAI'];
                    $imgUrl = $catImages['Default'];
                    foreach ($catImages as $key => $val) {
                        if (stripos($catName, $key) !== false || stripos($key, $catName) !== false) {
                            $imgUrl = $val;
                            break;
                        }
                    }
                ?>
                <div class="col-6 col-lg-3 animate__animated animate__fadeInUp delay-<?= ($index + 1) * 100 ?>">
                    <a href="index.php?controller=product&action=list&id_phanloai=<?= htmlspecialchars($category['ID_PHANLOAI']) ?>" class="text-decoration-none">
                        <div class="category-tile shadow-lg">
                            <img src="<?= $imgUrl ?>" alt="<?= $catName ?>">
                            <div class="category-overlay">
                                <h4 class="fw-bold text-white mb-0"><?= $catName ?></h4>
                                <div class="text-white-50 small">Khám phá ngay <i class="bi bi-chevron-right fs-xs"></i></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- SẢN PHẨM KHUYẾN MÃI -->
        <?php if (!empty($saleProducts)): ?>
        <section class="mb-5 section-container reveal">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="section-title-premium h1 fw-bold text-gradient-premium">Ưu đãi độc quyền</h2>
                    <p class="text-white-50 mb-0">Sản phẩm chất lượng với mức giá không thể tốt hơn</p>
                </div>
            </div>
            <div class="row g-4">
                <?php foreach ($saleProducts as $index => $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 animate__animated animate__fadeInUp delay-<?= ($index % 4 + 1) * 100 ?>">
                        <!-- Reusing the product-card class from style.css -->
                        <div class="card h-100 product-card glass-card">
                            <?php 
                                $giaGoc = $product['GIAGOC'] ?? 0;
                                $donGia = $product['DONGIA'] ?? 0;
                                $isSale = $giaGoc > $donGia && $giaGoc > 0;
                                $salePercent = $isSale ? round((($giaGoc - $donGia) / $giaGoc) * 100) : 0;
                            ?>
                            <div class="position-absolute top-0 end-0 p-2 z-3">
                                <span class="badge bg-warning text-dark mb-1 d-block shadow-sm">SALE</span>
                                <?php if ($isSale): ?>
                                    <span class="badge bg-danger d-block shadow-sm">-<?= $salePercent ?>%</span>
                                <?php endif; ?>
                            </div>
                            <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="product-img-link overflow-hidden rounded-top-4">
                                <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>" alt="<?= htmlspecialchars($product['TENHANGHOA']) ?>">
                            </a>
                            <div class="card-body d-flex flex-column p-4">
                                <div class="text-white-50 small mb-1"><?= htmlspecialchars($product['TENPHANLOAI'] ?? 'Sản phẩm') ?></div>
                                <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-decoration-none">
                                    <h6 class="fw-bold text-white mb-3 h5"><?= htmlspecialchars($product['TENHANGHOA']) ?></h6>
                                </a>
                                <div class="mt-auto">
                                    <div class="price-wrapper mb-3">
                                        <span class="current-price text-primary fs-4 fw-bold"><?= number_format($donGia) ?> <span class="fs-6">đ</span></span>
                                        <?php if ($isSale): ?>
                                            <span class="old-price text-white-50 text-decoration-line-through small ms-2"><?= number_format($giaGoc) ?> đ</span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" class="btn btn-premium-glow w-100 rounded-pill py-2 fw-bold">
                                        <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- SẢN PHẨM MỚI (Grid 4x2) -->
        <?php if (!empty($newProducts)): ?>
        <section class="mb-5 section-container reveal">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="section-title-premium h1 fw-bold text-gradient-premium">Mới cập bến</h2>
                    <p class="text-white-50 mb-0">Những siêu phẩm vừa có mặt tại Pikay Shop</p>
                </div>
            </div>
            <div class="row g-4">
                <?php foreach ($newProducts as $index => $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 animate__animated animate__fadeInUp delay-<?= ($index % 4 + 1) * 100 ?>">
                        <div class="card h-100 product-card glass-card">
                            <div class="position-absolute top-0 end-0 p-2 z-3">
                                <span class="badge bg-success mb-1 d-block shadow-sm">NEW</span>
                            </div>
                            <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="product-img-link overflow-hidden rounded-top-4">
                                <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>" alt="<?= htmlspecialchars($product['TENHANGHOA']) ?>">
                            </a>
                            <div class="card-body d-flex flex-column p-4">
                                <div class="text-white-50 small mb-1"><?= htmlspecialchars($product['TENPHANLOAI'] ?? 'Sản phẩm') ?></div>
                                <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-decoration-none">
                                    <h6 class="fw-bold text-white mb-3 h5"><?= htmlspecialchars($product['TENHANGHOA']) ?></h6>
                                </a>
                                <div class="mt-auto">
                                    <div class="price-wrapper mb-3">
                                        <span class="current-price text-primary fs-4 fw-bold"><?= number_format($product['DONGIA']) ?> <span class="fs-6">đ</span></span>
                                    </div>
                                    <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" class="btn btn-premium-glow w-100 rounded-pill py-2 fw-bold">
                                        <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- SẢN PHẨM BÁN CHẠY (Grid 4x2) -->
        <?php if (!empty($hotProducts)): ?>
        <section class="mb-5 section-container reveal">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="section-title-premium h1 fw-bold text-gradient-premium">Sức hút khó cưỡng</h2>
                    <p class="text-white-50 mb-0">Những sản phẩm đang làm mưa làm gió tại cửa hàng</p>
                </div>
            </div>
            <div class="row g-4">
                <?php foreach ($hotProducts as $index => $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 animate__animated animate__fadeInUp delay-<?= ($index % 4 + 1) * 100 ?>">
                        <div class="card h-100 product-card glass-card">
                            <div class="position-absolute top-0 start-0 p-2 z-3">
                                <span class="badge bg-primary mb-1 d-block shadow-sm">HOT</span>
                            </div>
                            <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="product-img-link overflow-hidden rounded-top-4">
                                <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>" alt="<?= htmlspecialchars($product['TENHANGHOA']) ?>">
                            </a>
                            <div class="card-body d-flex flex-column p-4">
                                <div class="text-white-50 small mb-1"><?= htmlspecialchars($product['TENPHANLOAI'] ?? 'Sản phẩm') ?></div>
                                <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-decoration-none">
                                    <h6 class="fw-bold text-white mb-3 h5"><?= htmlspecialchars($product['TENHANGHOA']) ?></h6>
                                </a>
                                <div class="mt-auto">
                                    <div class="price-wrapper mb-3">
                                        <span class="current-price text-primary fs-4 fw-bold"><?= number_format($product['DONGIA']) ?> <span class="fs-6">đ</span></span>
                                    </div>
                                    <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" class="btn btn-premium-glow w-100 rounded-pill py-2 fw-bold">
                                        <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</div>