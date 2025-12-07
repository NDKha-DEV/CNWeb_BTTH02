<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo khóa học mới</title>
</head>
<body>
    <h2>Tạo khóa học mới</h2>
    <a href="<?php echo BASE_URL; ?>course/index">Quay lại danh sách</a>
    <hr>

    <form action="<?php echo BASE_URL; ?>course/store" method="POST" enctype="multipart/form-data">
        
        <div>
            <label>Tiêu đề khóa học:</label><br>
            <input type="text" name="title" required placeholder="Nhập tên khóa học">
        </div>
        <br>

        <div>
            <label>Danh mục:</label><br>
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php 
                // Kiểm tra biến $categories từ Controller->create()
                if(isset($categories)){
                    while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <br>

        <div>
            <label>Trình độ:</label><br>
            <select name="level">
                <option value="Beginner">Cơ bản (Beginner)</option>
                <option value="Intermediate">Trung bình (Intermediate)</option>
                <option value="Advanced">Nâng cao (Advanced)</option>
            </select>
        </div>
        <br>

        <div>
            <label>Giá ($):</label><br>
            <input type="number" name="price" value="0" min="0">
        </div>
        <br>

        <div>
            <label>Thời lượng (tuần):</label><br>
            <input type="number" name="duration_weeks" value="4" min="1">
        </div>
        <br>

        <div>
            <label>Mô tả:</label><br>
            <textarea name="description" rows="5" cols="50"></textarea>
        </div>
        <br>

        <div>
            <label>Ảnh bìa:</label><br>
            <input type="file" name="image" required>
        </div>
        <br>

        <button type="submit">Lưu khóa học</button>
    </form>
</body>
</html>