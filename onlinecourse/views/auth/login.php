<?php 
ob_start(); 
?>

<h2>Đăng nhập Hệ thống</h2>

<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<form action="<?php echo BASE_URL; ?>login" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Mật khẩu:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Đăng nhập</button>
</form>
<p>Chưa có tài khoản? <a href="/onlinecourse/register">Đăng ký ngay!</a></p>

<?php 
$content = ob_get_clean();
// Sử dụng đường dẫn tương đối (từ views/auth/ lùi ra views/)
require 'views/layouts/header.php'; 
echo $content;
require 'views/layouts/footer.php';
?>