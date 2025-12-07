<?php 
ob_start(); 
?>

<h2>Đăng ký Tài khoản Mới</h2>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form action="<?php echo BASE_URL; ?>auth/register" method="POST">
    
    <label for="username">Tên người dùng (Username):</label>
    <input type="text" id="username" name="username" required><br>
    
    <label for="fullname">Họ và Tên:</label>
    <input type="text" id="fullname" name="fullname" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Mật khẩu:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Đăng ký</button>
</form>

<p>Đã có tài khoản? <a href="<?php echo BASE_URL; ?>auth/login">Đăng nhập ngay!</a></p>

<?php 
$content = ob_get_clean();
// Sử dụng đường dẫn tương đối để gọi Layout
require 'views/layouts/header.php'; 
echo $content;
require 'views/layouts/footer.php';
?>