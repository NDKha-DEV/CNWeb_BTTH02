<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Hệ thống khóa học</title>
    <base href="<?php echo BASE_URL; ?>">
    <style>
        body { font-family: sans-serif; padding: 20px; line-height: 1.6; }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: #f8f9fa; 
            padding: 15px; 
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-primary { background-color: #007bff; } /* Xanh dương (Login) */
        .btn-success { background-color: #28a745; } /* Xanh lá (Register/Create) */
        .btn-danger { background-color: #dc3545; }  /* Đỏ (Logout) */
        .btn-info { background-color: #17a2b8; }    /* Xanh nhạt (Manage) */
        
        .welcome-text { font-weight: bold; color: #333; }
        .hero { text-align: center; margin-top: 50px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <h2>📚 Online Course</h2>
        </div>

        <div class="actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="welcome-text">Xin chào, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Giảng viên'); ?>!</span>
                
                <a href="<?php echo BASE_URL; ?>course/manage" class="btn btn-info">📂 Quản lý khóa học</a>
                <a href="<?php echo BASE_URL; ?>course/create" class="btn btn-success">+ Tạo mới</a>
                <a href="<?php echo BASE_URL; ?>logout" class="btn btn-danger">Đăng xuất</a>
            
            <?php else: ?>
                <span style="margin-right: 10px;">Bạn chưa đăng nhập?</span>
                <a href="<?php echo BASE_URL; ?>login" class="btn btn-primary">Đăng nhập</a>
                <a href="<?php echo BASE_URL; ?>register" class="btn btn-success">Đăng ký</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero">
        <h1>Chào mừng đến với hệ thống quản lý khóa học</h1>
        <p>Nơi giảng viên có thể tạo và quản lý các khóa học trực tuyến một cách dễ dàng.</p>
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p>Vui lòng <a href="<?php echo BASE_URL; ?>login">đăng nhập</a> để bắt đầu tạo khóa học của bạn.</p>
        <?php endif; ?>
    </div>

</body>
</html>