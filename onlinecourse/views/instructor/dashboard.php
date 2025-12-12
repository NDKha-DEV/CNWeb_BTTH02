<?php 
// views/instructor/dashboard.php (hoặc tên file hiện tại của bạn)

// Đảm bảo instructor-dashboard.css được load
$css_files=['instructor-dashboard.css', 'instructor-courses.css']; 
$page_title='Dashboard';
include './views/layouts/header.php'; // Đây là nơi CSS sẽ được load
?>

    <div class="hero">
        <h1>Chào mừng đến với hệ thống quản lý khóa học</h1>
        <p>Nơi giảng viên có thể tạo và quản lý các khóa học trực tuyến một cách dễ dàng.</p>
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p>Vui lòng <a href="<?php echo BASE_URL; ?>login">đăng nhập</a> để bắt đầu tạo khóa học của bạn.</p>
        <?php endif; ?>
    </div>
    
    <?php include './views/instructor/my_courses.php'; ?> 
    
    <?php include './views/layouts/footer.php'; ?>