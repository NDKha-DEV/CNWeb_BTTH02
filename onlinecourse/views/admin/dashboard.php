<?php
// views/admin/dashboard.php

// Giả định: Bạn đã có biến session
if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_role'] !== 2) {
    header('Location: ' . BASE_URL . 'home');
    exit;
}

$page_title = "Admin Dashboard | Tổng quan Hệ thống";
$css_files=['admin-dashboard.css'];
include './views/layouts/header.php'; // Sử dụng header chung
?>

    <div class="dashboard-container">
        <h1>Chào mừng, Quản trị viên!</h1>
        <p>Đây là trang tổng quan hệ thống. Bạn đang đăng nhập với quyền **<?= $_SESSION['username'] ?? 'Admin' ?>**.</p>
        
        <h2>📊 Thống kê nhanh</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Tổng số Người dùng</h3>
                <p><?= $stats['total_users'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Giảng viên</h3>
                <p><?= $stats['total_instructors'] ?></p>
            </div>
            <div class="stat-card">
                <h3>Tổng số Khóa học</h3>
                <p><?= $stats['total_courses'] ?></p>
            </div>
            <div class="stat-card" style="background: #ffc107;">
                <h3>Khóa học Chờ duyệt</h3>
                <p><a href="<?= BASE_URL ?>admin/courses/pending" style="color: #333; text-decoration: none;"><?= $stats['pending_courses'] ?></a></p>
            </div>
        </div>

        <h2>🛠️ Điều hướng nhanh</h2>
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= BASE_URL ?>admin/users/create-instructor" style="background: #28a745;">Tạo Tài khoản Giảng viên</a></li>
                <li><a href="<?= BASE_URL ?>admin/users">Quản lý Người dùng (Xem, Kích hoạt/Vô hiệu hóa)</a></li>
                <li><a href="<?= BASE_URL ?>admin/categories">Quản lý Danh mục Khóa học</a></li>
                <li><a href="<?= BASE_URL ?>admin/courses/pending">Duyệt Phê duyệt Khóa học</a></li>
                <li><a href="<?= BASE_URL ?>admin/statistics/views">Xem Thống kê Lượt truy cập</a></li>
                <li><a href="<?= BASE_URL ?>logout" style="background: #dc3545;">Đăng xuất</a></li>
            </ul>
        </nav>
    </div>


<?php 
include './views/layouts/footer.php'; 
?>