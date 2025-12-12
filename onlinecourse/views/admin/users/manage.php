<?php 
// Kiểm tra quyền truy cập lần cuối (tuy AdminController đã làm, nhưng nên có ở View)
if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_role'] !== 2) {
    echo "Bạn không có quyền truy cập trang này.";
    exit;
}

$page_title = "Quản lý Người dùng";
// Giả định có file header và footer để tạo khung giao diện
// require 'views/layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <style>
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .active-status { color: green; font-weight: bold; }
        .inactive-status { color: red; font-weight: bold; }
        .btn { padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-success { background-color: #28a745; color: white; border-color: #28a745; }
        .header-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="header-controls">
        <h1><?= $page_title ?></h1>
        <a href="<?= BASE_URL ?>admin/users/create-instructor" class="btn btn-success">
            + Tạo tài khoản Giảng viên mới
        </a>
    </div>
    <?php 
    // Hiển thị thông báo thành công hoặc lỗi (nếu có từ redirect)
    if (isset($_GET['success']) && $_GET['success'] === 'status_updated') {
        echo "<p style='color: green;'>Cập nhật trạng thái người dùng thành công!</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] === 'status_failed') {
        echo "<p style='color: red;'>Cập nhật trạng thái người dùng thất bại.</p>";
    }
    // Thêm thông báo tạo thành công/lỗi
    if (isset($_SESSION['success'])): ?>
        <p style='color: green;'><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; 
    if (isset($_SESSION['error'])): ?>
        <p style='color: red;'><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Trạng thái (Status)</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <?php
                                // Chuyển Role ID thành tên dễ đọc
                                if ($user['role'] == 2) {
                                    echo "Admin";
                                } elseif ($user['role'] == 1) {
                                    echo "Giảng viên";
                                } else {
                                    echo "Học viên";
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                $status = (int)$user['status'];
                                if ($status === 1) {
                                    echo "<span class='active-status'>Hoạt động</span>";
                                } else {
                                    echo "<span class='inactive-status'>Vô hiệu hóa</span>";
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td>
                            <form method="POST" action="<?= BASE_URL ?>admin/users/toggle-status" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                                
                                <?php if ($status === 1): ?>
                                    <input type="hidden" name="status" value="0">
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn VÔ HIỆU HÓA người dùng này?');">Vô hiệu hóa</button>
                                <?php else: ?>
                                    <input type="hidden" name="status" value="1">
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn KÍCH HOẠT người dùng này?');">Kích hoạt</button>
                                <?php endif; ?>
                            </form>
                            
                            </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Không tìm thấy người dùng nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p>Quay lại <a href="/onlinecourse/admin/dashboard">Dashboard</a></p>
</body>
</html>

<?php 
// require 'views/layouts/footer.php'; 
?>