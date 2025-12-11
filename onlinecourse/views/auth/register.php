<?php 
$page_title = "Đăng ký ";
$css_files = ['login.css'];  // Reuse the same CSS from login page
ob_start(); 
include './views/layouts/header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 col-xl-5">

            <!-- Register Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-gradient text-white text-center py-5" 
                     style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h3 class="mb-0 fw-bold fs-2">Tạo tài khoản mới</h3>
                    <p class="mb-0 opacity-90">Tham gia LearnHub miễn phí ngay hôm nay!</p>
                </div>

                <div class="card-body p-5">

                    <!-- Success message (optional - if you want to show after register) -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success rounded-3">
                            <?= htmlspecialchars($success) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Error message -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3">
                            <strong>Lỗi:</strong> <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Register Form -->
                    <form action="<?= BASE_URL ?>register" method="POST" novalidate>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="username" class="form-label fw-semibold">Tên đăng nhập</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg border-start-0 ps-0" 
                                           id="username" name="username" placeholder="Chọn tên đăng nhập"
                                           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                                           required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="fullname" class="form-label fw-semibold">Họ và tên</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person-badge"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg border-start-0 ps-0" 
                                           id="fullname" name="fullname" placeholder="Nguyễn Văn A"
                                           value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '' ?>"
                                           required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control form-control-lg border-start-0 ps-0" 
                                           id="email" name="email" placeholder="you@example.com"
                                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                           required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg border-start-0 ps-0" 
                                           id="password" name="password" placeholder="Tối thiểu 6 ký tự"
                                           minlength="6" required>
                                </div>
                                <div class="form-text text-muted small">
                                    Mật khẩu phải có ít nhất 6 ký tự
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                Đăng ký ngay
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                Đã có tài khoản? 
                                <a href="<?= BASE_URL ?>login" class="text-decoration-none fw-bold text-primary">
                                    Đăng nhập tại đây
                                </a>
                            </small>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-4">
                    <small class="text-muted">
                        Bằng việc đăng ký, bạn đồng ý với <a href="#" class="text-decoration-none">Điều khoản dịch vụ</a> và <a href="#" class="text-decoration-none">Chính sách bảo mật</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
echo $content;
include './views/layouts/footer.php'; 
?>