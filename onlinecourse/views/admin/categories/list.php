<?php
// views/admin/categories/list.php

// Giả định: Bạn đã có biến $categories từ AdminController::manageCategories()
if (!isset($categories)) {
    // Nếu biến không tồn tại (lỗi), gán mảng rỗng để tránh lỗi foreach
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
    </style>
</head>
<body>

    <div class="category-container">
        <h1><?= $page_title ?></h1>
        
        <?php 
        // Hiển thị thông báo (nếu có)
        if (isset($_GET['success']) && $_GET['success'] === 'created') {
            echo "<p style='color: green;'>Tạo danh mục thành công!</p>";
        }
        if (isset($error)) {
             echo "<p style='color: red;'>Lỗi: " . htmlspecialchars($error) . "</p>";
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
                                <button disabled style="opacity: 0.5;">Sửa</button>
                                <button disabled style="opacity: 0.5;">Xóa</button>
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
    <p>Quay lại <a href="/onlinecourse/admin/dashboard">Dashboard</a></p>
</body>
</html>

<?php 
// require 'views/layouts/footer.php'; 
?>  