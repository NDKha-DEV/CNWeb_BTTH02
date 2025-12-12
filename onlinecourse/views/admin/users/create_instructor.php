<?php 
$page_title = "Tạo tài khoản Giảng viên mới";
$css_files = ['admin-create-instructor.css']; // CSS riêng đẹp
include './views/layouts/header.php';
?>

<div class="create-instructor-container">
    <div class="page-header">
        <div>
            <h1>Tạo tài khoản Giảng viên mới</h1>
            <p class="subtitle">Thêm giảng viên vào hệ thống để họ có thể tạo và quản lý khóa học</p>
        </div>
        <a href="<?= BASE_URL ?>admin/users" class="btn-back">
            Danh sách người dùng
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card">
        <div class="card-header">
            <h2>Thông tin tài khoản giảng viên</h2>
            <div class="role-badge">
                <strong>Vai trò:</strong> 
                <span class="badge-role">Giảng viên</span>
                <small class="text-muted">(Quyền tạo & quản lý khóa học)</small>
            </div>
        </div>

        <form action="<?= BASE_URL ?>admin/users/create-instructor" method="POST" class="instructor-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="fullname">Họ và tên <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="fullname" 
                        name="fullname" 
                        class="form-input"
                        placeholder="Ví dụ: Nguyễn Văn A"
                        required
                        autocomplete="name"
                    >
                </div>

                <div class="form-group">
                    <label for="username">Tên đăng nhập (Username) <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input"
                        placeholder="abc123"
                        required
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input"
                        placeholder="giao.vien@example.com"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                        minlength="6"
                    >
                    <small class="form-hint">Tối thiểu 6 ký tự, nên có chữ hoa, số và ký tự đặc biệt</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-create">
                    Tạo tài khoản Giảng viên
                </button>
                <a href="<?= BASE_URL ?>admin/users" class="btn-cancel">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>