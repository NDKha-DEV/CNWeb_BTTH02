<?php 
// Đảm bảo session_start() đã chạy (đã có trong index.php)
$username = $_SESSION['username'] ?? 'Người dùng';

ob_start(); 
?>

<div style="text-align: center; margin-top: 50px;">
    <h1>🎉 Đăng ký/Đăng nhập Thành công! 🎉</h1>
    <h2>Chào mừng trở lại, <?php echo htmlspecialchars($username); ?></h2>

    <p>Bạn đã đăng nhập vào hệ thống Online Course.</p>
    <?php 
        if($_SESSION['user_role'] == 1){
            echo "<p><a href=\"". BASE_URL . "instructor/dashboard\">Giao dien giang vien</a></p>";
        }
        ?>
    <p><a href="/onlinecourse/logout">Thoát / Đăng xuất</a></p>
</div>

<?php 
$content = ob_get_clean();
// Sử dụng đường dẫn tương đối để gọi Layout
require 'views/layouts/header.php'; 
echo $content;
require 'views/layouts/footer.php';
?>