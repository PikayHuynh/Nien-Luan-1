<div class="container mt-4 home-page">
    <!-- Hero Section -->
    <section class="home-hero position-relative text-center rounded mb-5">
        <div class="hero-content py-5">
            <h1 class="display-5 mb-3 fw-bold">Chào mừng đến với Shop của chúng tôi!</h1>
            <p class="lead mb-4">Mua sắm sản phẩm chất lượng với giá tốt nhất.</p>
            <a class="btn btn-primary btn-lg px-5" href="index.php?controller=product&action=list" role="button">
                <i class="bi bi-bag"></i> Xem sản phẩm
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section mb-5">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">📦</div>
                    <div class="stat-number fw-bold fs-3"><?php echo $totalProducts ?? 0; ?></div>
                    <div class="stat-label text-muted">Sản phẩm</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">🏷️</div>
                    <div class="stat-number fw-bold fs-3"><?php echo count($categories ?? []); ?></div>
                    <div class="stat-label text-muted">Danh mục</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">⭐</div>
                    <div class="stat-number fw-bold fs-3">5.0</div>
                    <div class="stat-label text-muted">Đánh giá</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">🚚</div>
                    <div class="stat-number fw-bold fs-3">24/7</div>
                    <div class="stat-label text-muted">Hỗ trợ</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Cards Section -->
    <section class="features row gx-4 justify-content-center mb-5">
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <a class="feature-link" href="index.php?controller=product&action=list&feature=new">
                <div class="card feature-card p-4 text-center h-100">
                    <div class="feature-icon mb-3">🆕</div>
                    <h5 class="mb-2">Sản phẩm mới</h5>
                    <p class="mb-0 small">Những sản phẩm mới nhất đã có mặt tại cửa hàng.</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <a class="feature-link" href="index.php?controller=product&action=list&feature=promo">
                <div class="card feature-card p-4 text-center h-100">
                    <div class="feature-icon mb-3">🔥</div>
                    <h5 class="mb-2">Khuyến mãi</h5>
                    <p class="mb-0 small">Cập nhật những chương trình khuyến mãi hấp dẫn.</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <a class="feature-link" href="index.php?controller=product&action=list">
                <div class="card feature-card p-4 text-center h-100">
                    <div class="feature-icon mb-3">🏆</div>
                    <h5 class="mb-2">Bán chạy</h5>
                    <p class="mb-0 small">Những sản phẩm được yêu thích nhất hiện nay.</p>
                </div>
            </a>
        </div>
    </section>

    <!-- Featured Products Section - Redesigned with larger cards and CTA blocks -->
    <section class="featured-products-section mt-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="m-0">Sản phẩm nổi bật</h3>
            <a href="index.php?controller=product&action=list" class="small">Xem tất cả &rarr;</a>
        </div>

        <?php if (!empty($featuredProducts)): ?>
        <div class="product-preview-grid row g-4">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="col-12 col-md-6 col-lg-3">
                <a href="index.php?controller=product&action=detail&id=<?php echo $product['ID_HANGHOA']; ?>" class="text-decoration-none">
                    <div class="card featured-product-card h-100">
                        <div class="product-image-wrapper">
                            <?php if (!empty($product['HINHANH'])): ?>
                                <img src="upload/<?php echo htmlspecialchars($product['HINHANH']); ?>" 
                                        alt="<?php echo htmlspecialchars($product['TENHANGHOA']); ?>"
                                        class="featured-product-image">
                            <?php else: ?>
                                <div class="preview-thumb">📦</div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-3">
                            <?php if (!empty($product['TENPHANLOAI'])): ?>
                                <div class="featured-product-category mb-1"><?php echo htmlspecialchars($product['TENPHANLOAI']); ?></div>
                            <?php endif; ?>
                            <div class="featured-product-name mb-2"><?php echo htmlspecialchars($product['TENHANGHOA']); ?></div>
                            <div class="featured-product-price mb-2">
                                <?php if (!empty($product['DONGIA'])): ?>
                                    <?php echo number_format($product['DONGIA'], 0, ',', '.'); ?> ₫
                                <?php else: ?>
                                    <span class="text-muted">Liên hệ</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary btn-sm">Xem</button>
                                <a href="index.php?controller=cart&action=add&id=<?php echo $product['ID_HANGHOA']; ?>" class="btn btn-outline-primary btn-sm">Thêm vào giỏ</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <p class="text-muted">Chưa có sản phẩm nào.</p>
        </div>
        <?php endif; ?>
    </section>

    <!-- Promotional / CTA Blocks to fill page with blocks -->
    <section class="row g-4 mb-5">
        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h4>Ưu đãi riêng</h4>
                <p class="mb-0 small">Nhận mã giảm giá khi đăng ký thành viên mới.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h4>Giao hàng nhanh</h4>
                <p class="mb-0 small">Miễn phí vận chuyển cho đơn hàng trên 500k.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card cta-card p-4 text-center">
                <h4>Hỗ trợ 24/7</h4>
                <p class="mb-0 small">Hỗ trợ khách hàng mọi lúc mọi nơi.</p>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <?php if (!empty($categories)): ?>
    <section class="categories-section mb-5">
        <div class="section-header mb-4">
            <h2 class="section-title mb-1">Danh mục sản phẩm</h2>
            <p class="text-muted mb-0">Khám phá theo từng danh mục</p>
        </div>
        <?php 
        $categoriesPerRow = 6;
        $categoryChunks = array_chunk($categories, $categoriesPerRow);
        foreach ($categoryChunks as $chunk): 
        ?>
        <div class="row g-3 mb-3">
            <?php foreach ($chunk as $category): ?>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="index.php?controller=product&action=list&id_phanloai=<?php echo $category['ID_PHANLOAI']; ?>" 
                   class="text-decoration-none">
                    <div class="card category-card text-center p-3 h-100">
                        <div class="category-icon mb-2">🏷️</div>
                        <div class="category-name"><?php echo htmlspecialchars($category['TENPHANLOAI']); ?></div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us mb-5">
        <div class="section-header text-center mb-4">
            <h2 class="section-title mb-1">Tại sao chọn chúng tôi?</h2>
            <p class="text-muted">Những lý do khiến khách hàng tin tưởng</p>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">✨</div>
                    <h5 class="mb-2">Chất lượng cao</h5>
                    <p class="text-muted mb-0 small">Sản phẩm được kiểm định chất lượng nghiêm ngặt</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">💰</div>
                    <h5 class="mb-2">Giá tốt nhất</h5>
                    <p class="text-muted mb-0 small">Cam kết giá cạnh tranh trên thị trường</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">🚚</div>
                    <h5 class="mb-2">Giao hàng nhanh</h5>
                    <p class="text-muted mb-0 small">Vận chuyển nhanh chóng, an toàn</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">💬</div>
                    <h5 class="mb-2">Hỗ trợ 24/7</h5>
                    <p class="text-muted mb-0 small">Đội ngũ tư vấn luôn sẵn sàng hỗ trợ</p>
                </div>
            </div>
        </div>
    </section>
</div>

