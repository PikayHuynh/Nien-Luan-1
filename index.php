<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Trang chủ - Cửa hàng Bán Hàng</title>
    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/style.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-shop me-2" viewBox="0 0 16 16">
                    <path d="M2.97 1a1 1 0 0 0-.92.605L.5 5h15l-1.55-3.395A1 1 0 0 0 13.03 1H2.97z"/>
                    <path d="M0 6v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H0z"/>
                </svg>
                BánHàng.vn
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Liên hệ</a></li>
                </ul>

                <form class="d-flex me-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Tìm sản phẩm, mã…" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Tìm</button>
                </form>

                <div class="d-flex">
                    <a href="#" class="btn btn-primary me-2">Đăng nhập</a>
                    <a href="#" class="btn btn-outline-secondary">Giỏ (0)</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <header class="container my-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero">
                    <h1 class="display-5 fw-bold">Chào mừng đến với cửa hàng mẫu</h1>
                    <p class="lead">Sản phẩm chất lượng, giao nhanh, dịch vụ tận tâm. Dễ dàng quản lý kho, đơn hàng và khách hàng.</p>
                    <div class="d-flex gap-2">
                        <a href="#products" class="btn btn-primary btn-lg">Xem sản phẩm</a>
                        <a href="#about" class="btn btn-outline-primary btn-lg">Tìm hiểu thêm</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <img src="https://placehold.co/600x420?text=Hero+Image" alt="hero" class="img-fluid rounded">
            </div>
        </div>
    </header>

    <!-- FEATURES -->
    <section class="container mb-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded h-100">
                    <h5>Miễn phí giao hàng</h5>
                    <p class="mb-0">Đơn trên 500.000₫</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded h-100">
                    <h5>Bảo hành 12 tháng</h5>
                    <p class="mb-0">Hỗ trợ đổi trả nhanh chóng</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded h-100">
                    <h5>Thanh toán linh hoạt</h5>
                    <p class="mb-0">COD / Chuyển khoản / Ví điện tử</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCTS GRID -->
    <section id="products" class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Sản phẩm nổi bật</h3>
            <a href="#" class="text-decoration-none">Xem tất cả →</a>
        </div>

        <div class="row g-4">
            <!-- Sample product card -->
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    <img src="https://placehold.co/400x300?text=Sp+1" class="card-img-top" alt="Sản phẩm 1">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">Cà phê Rang Xay</h6>
                        <p class="card-text text-muted small mb-2">250g - Hương vị đậm</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">₫120.000</div>
                                <small class="text-success">Có sẵn</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#quickViewModal">Xem</button>
                                <button class="btn btn-sm btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repeat (demo) -->
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    <img src="https://placehold.co/400x300?text=Sp+2" class="card-img-top" alt="Sản phẩm 2">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">Trà Hoa Cúc</h6>
                        <p class="card-text text-muted small mb-2">50 túi lọc</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">₫85.000</div>
                                <small class="text-muted">Hết hàng</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#quickViewModal">Xem</button>
                                <button class="btn btn-sm btn-secondary" disabled>Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2 more cards -->
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    <img src="https://placehold.co/400x300?text=Sp+3" class="card-img-top" alt="Sản phẩm 3">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">Sinh tố Trái Cây</h6>
                        <p class="card-text text-muted small mb-2">Ly 350ml</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">₫60.000</div>
                                <small class="text-success">Có sẵn</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#quickViewModal">Xem</button>
                                <button class="btn btn-sm btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    <img src="https://placehold.co/400x300?text=Sp+4" class="card-img-top" alt="Sản phẩm 4">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">At Home Coffee Kit</h6>
                        <p class="card-text text-muted small mb-2">Combo 3 món</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">₫420.000</div>
                                <small class="text-success">Có sẵn</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#quickViewModal">Xem</button>
                                <button class="btn btn-sm btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4>Về chúng tôi</h4>
                    <p>Hệ thống quản lý bán hàng mẫu, phù hợp cho cửa hàng nhỏ, quán ăn, hoặc chuỗi bán lẻ. Tích hợp chức năng: quản lý sản phẩm, kho, đơn hàng và khách hàng.</p>
                    <ul>
                        <li>Quản lý tồn kho theo từng thuộc tính</li>
                        <li>Phiếu nhập / xuất, lịch sử giá</li>
                        <li>Thống kê doanh thu, báo cáo</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="https://placehold.co/600x360?text=About+Image" alt="about" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT & FOOTER -->
    <footer id="contact" class="pt-5 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Liên hệ</h5>
                    <p class="small mb-1">Địa chỉ: 123 Đường Mẫu, Quận 1, TP. HCM</p>
                    <p class="small mb-1">Hotline: 0909 123 456</p>
                    <p class="small">Email: info@banhang.vn</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small mb-1">© <span id="year"></span> BánHàng.vn — All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- QUICK VIEW MODAL -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xem nhanh sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <img src="https://placehold.co/600x400?text=Product" class="img-fluid rounded" alt="product">
                        </div>
                        <div class="col-md-6">
                            <h5>Cà phê Rang Xay</h5>
                            <p class="text-muted small">250g • Hương vị đậm</p>
                            <div class="fw-bold mb-3">₫120.000</div>
                            <p>Mô tả ngắn gọn sản phẩm. Thêm thông tin kỹ thuật, thành phần, cách sử dụng...</p>
                            <div class="d-flex gap-2 mt-3">
                                <button class="btn btn-primary">Thêm vào giỏ</button>
                                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./asset/js/script.js"></script>
</body>
</html>