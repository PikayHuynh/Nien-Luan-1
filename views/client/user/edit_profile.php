<?php
include ROOT . '/views/client/layouts/header.php';
include ROOT . '/views/client/layouts/navbar.php';

$avatar = !empty($user['HINHANH'])
    ? 'upload/' . htmlspecialchars($user['HINHANH'])
    : 'upload/default.png';
?>

<div class="container mt-5 mb-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex align-items-center mb-5">
                <a href="index.php?controller=user&action=profile" class="btn btn-outline-light rounded-circle me-3 border-white-10 p-2">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1 class="fw-bold mb-0 text-white">Chỉnh sửa hồ sơ</h1>
            </div>

            <!-- HIỂN THỊ THÔNG BÁO -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger bg-glass border-white-10 text-danger rounded-4 mb-4 shadow-sm">
                    <i class="bi bi-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success bg-glass border-white-10 text-success rounded-4 mb-4 shadow-sm">
                    <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Avatar Upload Section -->
                <div class="col-md-4 text-center">
                    <div class="card bg-glass border-white-10 p-4 rounded-4 shadow-lg h-100">
                        <div class="avatar-edit-wrapper position-relative d-inline-block mx-auto mb-4">
                            <img src="<?= $avatar ?>" alt="avatar" id="avatarPreview" class="rounded-circle shadow-lg border border-white-20" style="width:140px; height:140px; object-fit: cover;">
                        </div>
                        <h6 class="text-white fw-bold mb-1">Ảnh đại diện</h6>
                        <p class="text-muted small mb-3">Hỗ trợ JPG, PNG (tối đa 5MB)</p>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="document.getElementById('avatarInput').click()">
                            Thay đổi ảnh
                        </button>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="col-md-8">
                    <div class="card bg-glass border-white-10 p-4 rounded-4 shadow-lg h-100">
                        <form method="POST" action="index.php?controller=user&action=editProfile" enctype="multipart/form-data">
                            <input type="file" id="avatarInput" name="HINHANH" style="display: none;" onchange="previewImage(this)">
                            
                            <div class="mb-4">
                                <label class="form-label text-white small fw-bold text-uppercase opacity-75">Tên người dùng / Username</label>
                                <div class="input-group bg-dark rounded-3 border border-white-10 overflow-hidden">
                                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control bg-transparent border-0 text-white py-2" 
                                           name="TEN_KH" value="<?= htmlspecialchars($user['TEN_KH'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-white small fw-bold text-uppercase opacity-75">Địa chỉ</label>
                                <div class="input-group bg-dark rounded-3 border border-white-10 overflow-hidden">
                                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control bg-transparent border-0 text-white py-2" 
                                           name="DIACHI" value="<?= htmlspecialchars($user['DIACHI'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label text-white small fw-bold text-uppercase opacity-75">Số điện thoại</label>
                                <div class="input-group bg-dark rounded-3 border border-white-10 overflow-hidden">
                                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="form-control bg-transparent border-0 text-white py-2" 
                                           name="SODIENTHOAI" value="<?= htmlspecialchars($user['SODIENTHOAI'] ?? '') ?>">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-lg">
                                <i class="bi bi-save me-2"></i>Lưu thay đổi
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include ROOT . '/views/client/layouts/footer.php'; ?>