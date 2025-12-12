<?php
// views/admin/categories/edit.php

// Giả định: Biến $category được truyền từ AdminController::editCategory()
if (!isset($category) || empty($category)) {
    // Nếu không tìm thấy danh mục, chuyển hướng về trang danh sách
    header('Location: ' . BASE_URL . 'admin/categories?error=not_found');
    exit;
}

$page_title = "Chỉnh sửa Danh mục: " . htmlspecialchars($category['name']);
// require 'views/layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <style>
        .edit-container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-update { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-cancel { padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>

    <div class="edit-container">
        <h1>Chỉnh sửa Danh mục</h1>
        <p>ID: <strong><?= htmlspecialchars($category['id']) ?></strong></p>

        <form method="POST" action="<?= BASE_URL ?>admin/categories/update">
            
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
            
            <div class="form-group">
                <label for="name">Tên Danh mục:</label>
                <input type="text" id="name" name="name" 
                       value="<?= htmlspecialchars($category['name']) ?>" required>
            </div>
            
            <button type="submit" class="btn-update">Cập nhật Danh mục</button>
            <a href="<?= BASE_URL ?>admin/categories" class="btn-cancel">Hủy</a>
        </form>
    </div>
    <p style="text-align: center;">Quay lại <a href="<?= BASE_URL ?>admin/dashboard">Dashboard</a></p>

</body>
</html>

<?php 
// require 'views/layouts/footer.php'; 
?>