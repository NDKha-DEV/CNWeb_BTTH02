<?php 
$page_title = "Đăng nhập - OnlineCourse";
$css_files = ['login.css'];  // We'll create this CSS file below
ob_start(); 
include './views/layouts/header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            
            <!-- Login Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-gradient text-white text-center py-4" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h3 class="mb-0 fw-bold">
                        Đăng nhập
                    </h3>
                    <p class="mb-0 opacity-90 small">Chào mừng bạn trở lại!</p>
                </div>

                <div class="card-body p-5">

                    <!-- Error Message -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3">
                            <strong>Lỗi:</strong> <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form action="<?= BASE_URL ?>login" method="POST" novalidate>
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control form-control-lg border-start-0 ps-0" 
                                       id="email" 
                                       name="email" 
                                       placeholder="nhập email của bạn" 
                                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control form-control-lg border-start-0 ps-0" 
                                       id="password" 
                                       name="password" 
                                       placeholder="nhập mật khẩu" 
                                       required>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                Đăng nhập ngay
                            </button>
                        </div>

                        <div class="text-center">
                            <small class="text-muted">
                                Chưa có tài khoản? 
                                <a href="<?= BASE_URL ?>register" class="text-decoration-none fw-bold text-primary">
                                    Đăng ký miễn phí
                                </a>
                            </small>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-4">
                    <small class="text-muted">
                        © 2025 LearnHub. Tất cả quyền được bảo lưu.
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