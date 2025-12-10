<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo khóa học mới</title>
    <style>
        /* Tận dụng CSS từ trang Edit để đồng bộ giao diện */
        body { font-family: sans-serif; padding: 20px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="number"], select, textarea, input[type="file"] {
            width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;
        }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; color: white; text-decoration: none; display: inline-block;}
        .btn-submit { background-color: #28a745; } /* Xanh lá */
        .btn-back { background-color: #6c757d; margin-right: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>+ Tạo khóa học mới</h2>
    
    <form action="<?php echo BASE_URL; ?>course/create" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label>Tiêu đề khóa học (*):</label>
            <input type="text" name="title" required placeholder="Nhập tên khóa học">
        </div>

        <div class="form-group">
            <label>Danh mục (*):</label>
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php 
                if(isset($categories)){
                    while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Trình độ:</label>
            <select name="level">
                <option value="Beginner">Cơ bản (Beginner)</option>
                <option value="Intermediate">Trung bình (Intermediate)</option>
                <option value="Advanced">Nâng cao (Advanced)</option>
            </select>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label>Giá ($):</label>
                <input type="number" name="price" value="0" min="0" step="0.01">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Thời lượng (tuần):</label>
                <input type="number" name="duration_weeks" value="4" min="1">
            </div>
        </div>

        <div class="form-group">
            <label>Mô tả:</label>
            <textarea name="description" rows="5"></textarea>
        </div>

        <div class="form-group">
            <label>Ảnh bìa:</label>
            <input type="file" name="image" required>
        </div>

        <hr>

        <button type="submit" class="btn btn-submit">Lưu khóa học</button>
        <a href="<?php echo BASE_URL; ?>course/manage" class="btn btn-back">Hủy bỏ</a>
    </form>
</div>
</body>
</html>