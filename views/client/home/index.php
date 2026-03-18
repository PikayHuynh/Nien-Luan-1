<div class="container mt-4 home-page">

    <!-- ============================================================
         HERO SECTION - Banner giới thiệu
    ============================================================ -->
    <section class="home-hero position-relative text-center rounded mb-5">
        <div class="hero-content py-5">
            <h1 class="display-5 mb-3 fw-bold">
                Chào mừng đến với Shop của chúng tôi!
            </h1>

            <p class="lead mb-4">
                Mua sắm sản phẩm chất lượng với giá tốt nhất.
            </p>

            <a class="btn btn-primary btn-lg px-5"
                href="index.php?controller=product&action=list">
                <i class="bi bi-bag"></i> Xem sản phẩm
            </a>
        </div>
    </section>


    <!-- ============================================================
         THỐNG KÊ NHANH
    ============================================================ -->
    <section class="stats-section mb-5">
        <div class="row g-4">

            <!-- Tổng số sản phẩm -->
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">📦</div>
                    <div class="stat-number fw-bold fs-3">
                        <?= htmlspecialchars($totalProducts ?? 0) ?>
                    </div>
                    <div class="stat-label text-muted">Sản phẩm</div>
                </div>
            </div>

            <!-- Số danh mục -->
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">🏷️</div>
                    <div class="stat-number fw-bold fs-3">
                        <?= count($categories ?? []) ?>
                    </div>
                    <div class="stat-label text-muted">Danh mục</div>
                </div>
            </div>

            <!-- Đánh giá -->
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">⭐</div>
                    <div class="stat-number fw-bold fs-3">5.0</div>
                    <div class="stat-label text-muted">Đánh giá</div>
                </div>
            </div>

            <!-- Hỗ trợ -->
            <div class="col-6 col-md-3">
                <div class="stat-card text-center p-4 rounded">
                    <div class="stat-icon mb-3">🚚</div>
                    <div class="stat-number fw-bold fs-3">24/7</div>
                    <div class="stat-label text-muted">Hỗ trợ</div>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================
         CTA – Khối quảng bá nhỏ
    ============================================================ -->
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


    <!-- ============================================================
         DANH MỤC SẢN PHẨM
    ============================================================ -->
    <!-- <?php if (!empty($categories)): ?>
    <section class="categories-section mb-5">

        <div class="section-header mb-4">
            <h2 class="section-title mb-1">Danh mục sản phẩm</h2>
            <p class="text-muted mb-0">Khám phá theo từng danh mục</p>
        </div>

        <?php
                $categoriesPerRow = 6;
                $categoryChunks = array_chunk($categories, $categoriesPerRow);
        ?>

        <?php foreach ($categoryChunks as $chunk): ?>
        <div class="row g-3 mb-3">

            <?php foreach ($chunk as $category): ?>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="index.php?controller=product&action=list&id_phanloai=<?= htmlspecialchars($category['ID_PHANLOAI']) ?>"
                   class="text-decoration-none">
                    <div class="card category-card text-center p-3 h-100">
                        <div class="category-icon mb-2">🏷️</div>
                        <div class="category-name">
                            <?= htmlspecialchars($category['TENPHANLOAI']) ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>

        </div>
        <?php endforeach; ?>

    </section>
    <?php endif; ?> -->


    <!-- ============================================================
         WHY CHOOSE US - Lý do chọn shop
    ============================================================ -->
    <!-- <section class="why-choose-us mb-5">

        <div class="section-header text-center mb-4">
            <h2 class="section-title mb-1">Tại sao chọn chúng tôi?</h2>
            <p class="text-muted">Những lý do khiến khách hàng tin tưởng</p>
        </div>

        <div class="row g-4">

            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">✨</div>
                    <h5 class="mb-2">Chất lượng cao</h5>
                    <p class="text-muted mb-0 small">
                        Sản phẩm được kiểm định chất lượng nghiêm ngặt
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">💰</div>
                    <h5 class="mb-2">Giá tốt nhất</h5>
                    <p class="text-muted mb-0 small">
                        Cam kết giá cạnh tranh trên thị trường
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">🚚</div>
                    <h5 class="mb-2">Giao hàng nhanh</h5>
                    <p class="text-muted mb-0 small">
                        Vận chuyển nhanh chóng, an toàn
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="benefit-card text-center p-4">
                    <div class="benefit-icon mb-3">💬</div>
                    <h5 class="mb-2">Hỗ trợ 24/7</h5>
                    <p class="text-muted mb-0 small">
                        Đội ngũ tư vấn luôn sẵn sàng hỗ trợ
                    </p>
                </div>
            </div>

        </div>

    </section> -->

    <!-- ============================================================
         DANH SÁCH HOT
    ============================================================ -->
    <?php if (!empty($hotProducts)): ?>
        <section class="mb-5">
            <h2 class="section-title mb-4 fw-bold" style="color: #6610f2;">Sản phẩm HOT</h2>
            <div class="row g-4">
                <?php foreach ($hotProducts as $product): 
                    $soldCount = $product['SOLD_COUNT'] ?? 0;
                    $isHot = true; // Lọc bắt buộc mang số lượng > 5
                    $giaGoc = $product['GIAGOC'] ?? 0;
                    $donGia = $product['DONGIA'] ?? 0;
                    $isSale = $giaGoc > $donGia && $giaGoc > 0;
                    $salePercent = $isSale ? round((($giaGoc - $donGia) / $giaGoc) * 100) : 0;
                    $categoryName = $product['TENPHANLOAI'] ?? 'Chưa phân loại';
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <!-- Badges -->
                            <div class="position-absolute top-0 end-0 p-2 text-end" style="z-index: 10;">
                                <span class="badge bg-danger mb-1 d-block" style="border-radius: 4px;">HOT</span>
                                <?php if ($isSale): ?><span class="badge bg-warning text-dark d-block" style="border-radius: 4px;">-<?= $salePercent ?>%</span><?php endif; ?>
                            </div>
                            
                            <!-- Image -->
                            <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-center d-block">
                                <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>" 
                                     class="card-img-top img-fluid" 
                                     alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>"
                                     style="height: 220px; object-fit: cover;">
                            </a>

                            <!-- Body -->
                            <div class="card-body d-flex flex-column p-4">
                                <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-decoration-none mb-2">
                                    <h6 class="card-title fw-normal mb-0" style="color: #6610f2; font-size: 1.15rem;">
                                        <?= htmlspecialchars($product['TENHANGHOA'] ?? 'Không tên') ?>
                                    </h6>
                                </a>
                                <div class="fw-bold mb-3" style="color: #b02a37; font-size: 1.05rem;">
                                    <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND
                                    <?php if ($isSale): ?>
                                        <del class="text-muted ms-2 small fw-normal" style="font-size: 0.85rem;"><?= number_format($giaGoc) ?> VND</del>
                                    <?php endif; ?>
                                </div>
                                <div class="text-muted small mt-auto mb-3"><?= htmlspecialchars($categoryName) ?></div>
                                <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" 
                                   class="btn w-100 text-white" 
                                   style="background-color: #6610f2; border-radius: 6px;">
                                   Thêm giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ============================================================
         DANH SÁCH NEW
    ============================================================ -->
    <?php if (!empty($newProducts)): ?>
        <section class="mb-5">
            <h2 class="section-title mb-4 fw-bold" style="color: #6610f2;">Sản phẩm NEW</h2>
            <div class="row g-4">
                <?php foreach ($newProducts as $product): 
                    $giaGoc = $product['GIAGOC'] ?? 0;
                    $donGia = $product['DONGIA'] ?? 0;
                    $isSale = $giaGoc > $donGia && $giaGoc > 0;
                    $salePercent = $isSale ? round((($giaGoc - $donGia) / $giaGoc) * 100) : 0;
                    $categoryName = $product['TENPHANLOAI'] ?? 'Chưa phân loại';
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <div class="position-absolute top-0 end-0 p-2 text-end" style="z-index: 10;">
                                <span class="badge bg-success mb-1 d-block" style="border-radius: 4px;">NEW</span>
                                <?php if ($isSale): ?><span class="badge bg-warning text-dark d-block" style="border-radius: 4px;">-<?= $salePercent ?>%</span><?php endif; ?>
                            </div>
                            
                            <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-center d-block">
                                <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>" 
                                     class="card-img-top img-fluid" 
                                     alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>"
                                     style="height: 220px; object-fit: cover;">
                            </a>

                            <div class="card-body d-flex flex-column p-4">
                                <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-decoration-none mb-2">
                                    <h6 class="card-title fw-normal mb-0" style="color: #6610f2; font-size: 1.15rem;">
                                        <?= htmlspecialchars($product['TENHANGHOA'] ?? 'Không tên') ?>
                                    </h6>
                                </a>
                                <div class="fw-bold mb-3" style="color: #b02a37; font-size: 1.05rem;">
                                    <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND
                                    <?php if ($isSale): ?>
                                        <del class="text-muted ms-2 small fw-normal" style="font-size: 0.85rem;"><?= number_format($giaGoc) ?> VND</del>
                                    <?php endif; ?>
                                </div>
                                <div class="text-muted small mt-auto mb-3"><?= htmlspecialchars($categoryName) ?></div>
                                <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" 
                                   class="btn w-100 text-white" 
                                   style="background-color: #6610f2; border-radius: 6px;">
                                   Thêm giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ============================================================
         DANH SÁCH SALE
    ============================================================ -->
    <?php if (!empty($saleProducts)): ?>
        <section class="mb-5">
            <h2 class="section-title mb-4 fw-bold" style="color: #6610f2;">Sản phẩm SALE</h2>
            <div class="row g-4">
                <?php foreach ($saleProducts as $product): 
                    $giaGoc = $product['GIAGOC'] ?? 0;
                    $donGia = $product['DONGIA'] ?? 0;
                    $isSale = $giaGoc > $donGia && $giaGoc > 0;
                    $salePercent = $isSale ? round((($giaGoc - $donGia) / $giaGoc) * 100) : 0;
                    $categoryName = $product['TENPHANLOAI'] ?? 'Chưa phân loại';
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <div class="position-absolute top-0 end-0 p-2 text-end" style="z-index: 10;">
                                <span class="badge bg-warning text-dark mb-1 d-block" style="border-radius: 4px;">SALE</span>
                                <span class="badge bg-danger text-white d-block" style="border-radius: 4px;">-<?= $salePercent ?>%</span>
                            </div>
                            
                            <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-center d-block">
                                <img src="upload/<?= htmlspecialchars($product['HINHANH'] ?? 'item-default.png') ?>" 
                                     class="card-img-top img-fluid" 
                                     alt="<?= htmlspecialchars($product['TENHANGHOA'] ?? '') ?>"
                                     style="height: 220px; object-fit: cover;">
                            </a>

                            <div class="card-body d-flex flex-column p-4">
                                <a href="index.php?controller=product&action=detail&id=<?= $product['ID_HANGHOA'] ?>" class="text-decoration-none mb-2">
                                    <h6 class="card-title fw-normal mb-0" style="color: #6610f2; font-size: 1.15rem;">
                                        <?= htmlspecialchars($product['TENHANGHOA'] ?? 'Không tên') ?>
                                    </h6>
                                </a>
                                <div class="fw-bold mb-3" style="color: #b02a37; font-size: 1.05rem;">
                                    <?= isset($product['DONGIA']) ? number_format($product['DONGIA']) : 0 ?> VND
                                    <?php if ($isSale): ?>
                                        <del class="text-muted ms-2 small fw-normal" style="font-size: 0.85rem;"><?= number_format($giaGoc) ?> VND</del>
                                    <?php endif; ?>
                                </div>
                                <div class="text-muted small mt-auto mb-3"><?= htmlspecialchars($categoryName) ?></div>
                                <a href="index.php?controller=cart&action=add&id=<?= $product['ID_HANGHOA'] ?>" 
                                   class="btn w-100 text-white" 
                                   style="background-color: #6610f2; border-radius: 6px;">
                                   Thêm giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</div>