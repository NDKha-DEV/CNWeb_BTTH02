<?php
// views/admin/categories/list.php

// Giả định: Bạn đã có biến $categories từ AdminController::manageCategories()
if (!isset($categories)) {
    $categories = []; 
}

$page_title = "Quản lý Danh mục Khóa học";
// require 'views/layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <style>
        .category-container { max-width: 800px; margin: 20px auto; padding: 20px; }
        .category-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .category-table th, .category-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .form-create input[type="text"] { width: 60%; padding: 8px; margin-right: 10px; }
        .form-create button { padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .action-button { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-right: 5px; }
        .edit-btn { background: #007bff; color: white; }
        .delete-btn { background: #dc3545; color: white; }
    </style>
</head>
<body>

    <div class="category-container">
        <h1><?= $page_title ?></h1>
        
        <?php 
        // Hiển thị thông báo (nếu có)
        if (isset($_GET['success'])) {
            $msg = '';
            if ($_GET['success'] === 'created') $msg = "Tạo danh mục thành công!";
            if ($_GET['success'] === 'updated') $msg = "Cập nhật danh mục thành công!";
            if ($_GET['success'] === 'deleted') $msg = "Xóa danh mục thành công!";
            if ($msg) echo "<p style='color: green; font-weight: bold;'>{$msg}</p>";
        }
        if (isset($_GET['error'])) {
            $err = '';
            if ($_GET['error'] === 'delete_failed') $err = "Xóa thất bại! Có khóa học đang sử dụng danh mục này.";
            if ($_GET['error'] === 'update_failed') $err = "Cập nhật thất bại.";
            if ($err) echo "<p style='color: red; font-weight: bold;'>Lỗi: {$err}</p>";
        }
        ?>

        <h2>➕ Tạo Danh mục Mới</h2>
        <form method="POST" action="<?= BASE_URL ?>admin/categories" class="form-create">
            <input type="text" name="name" placeholder="Tên danh mục mới (ví dụ: Lập trình Web)" required>
            <button type="submit">Thêm Danh mục</button>
        </form>

        <hr>

        <h2>📋 Danh sách Danh mục (<?= count($categories) ?>)</h2>
        <table class="category-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Danh mục</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category['id']) ?></td>
                            <td><?= htmlspecialchars($category['name']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>admin/categories/edit?id=<?= $category['id'] ?>" class="action-button edit-btn">Sửa</a>
                                
                                <!-- <form method="POST" action="<?= BASE_URL ?>admin/categories/delete" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn XÓA danh mục này? Thao tác này có thể bị lỗi nếu danh mục đang được sử dụng.');">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
                                    <button type="submit" class="action-button delete-btn">Xóa</button>
                                </form> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Chưa có danh mục nào được tạo.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <p>Quay lại <a href="<?= BASE_URL ?>admin/dashboard">Dashboard</a></p>
</body>
</html>

<?php 
// require 'views/layouts/footer.php'; 
?>