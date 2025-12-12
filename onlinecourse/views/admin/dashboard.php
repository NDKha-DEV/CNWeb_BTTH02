<?php
// views/admin/dashboard.php

// Giả định: Bạn đã có biến session
if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_role'] !== 2) {
    header('Location: ' . BASE_URL . 'home');
    exit;
}

$page_title = "Admin Dashboard | Tổng quan Hệ thống";

// Giả định: Dữ liệu thống kê được Controller lấy từ Model (chưa code)
// $stats = [
//     'total_users' => 150,
//     'total_instructors' => 12,
//     'total_courses' => 55,
//     'pending_courses' => 5 // Khóa học chờ duyệt
// ];

require 'views/layouts/header.php'; // Sử dụng header chung
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <style>
        .dashboard-container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #f0f0f0; padding: 15px; border-radius: 8px; text-align: center; }
        .stat-card h3 { margin: 0 0 5px 0; color: #333; }
        .stat-card p { font-size: 2em; margin: 5px 0 0 0; font-weight: bold; }
        .admin-nav ul { list-style: none; padding: 0; }
        .admin-nav li { margin-bottom: 10px; }
        .admin-nav a { display: block; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .admin-nav a:hover { background: #0056b3; }
    </style>
</head>
<body>

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

</body>
</html>

<?php 
require 'views/layouts/footer.php'; 
?>