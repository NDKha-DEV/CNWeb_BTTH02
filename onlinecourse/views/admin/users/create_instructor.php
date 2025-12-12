<?php 
    include 'views/layouts/header.php';
    include 'views/layouts/sidebar.php';
?>

<div class="container py-4">
    <h2 class="h3 mb-4 text-primary">👤 Tạo tài khoản Giảng viên mới</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= BASE_URL ?>admin/users/create-instructor" method="POST">
                
                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                </div>
                
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập (Username)</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="form-text">Mật khẩu tối thiểu 6 ký tự.</div>
                </div>

                <div class="mb-4">
                    <p class="text-muted">Vai trò được gán: <span class="badge bg-primary">Giảng viên (Role: 1)</span></p>
                </div>
                
                <button type="submit" class="btn btn-primary me-2">Tạo tài khoản Giảng viên</button>
                <a href="<?= BASE_URL ?>admin/users" class="btn btn-secondary">Hủy bỏ</a>
            </form>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>