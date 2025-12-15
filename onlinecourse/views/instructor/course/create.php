<?php
// views/course/create.php

$page_title='Tạo khóa học';
$css_files = ['instructor-create-course.css']; // Khai báo tệp CSS
// Giả định $page_title và $css_files được sử dụng trong header.php
include './views/layouts/header.php'; 

?>

<div class="container">
    <h2>+ Tạo khóa học mới</h2>
    <form action="<?php echo BASE_URL; ?>course/create" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="title">Tiêu đề khóa học (*):</label>
            <input type="text" name="title" id="title" required placeholder="Nhập tên khóa học">
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục (*):</label>
            <select name="category_id" id="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php 
                if(isset($categories) && $categories instanceof PDOStatement){
                    // Đảm bảo categories là một đối tượng PDOStatement hợp lệ
                    while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="'.htmlspecialchars($cat['id']).'">'.htmlspecialchars($cat['name']).'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="level">Trình độ:</label>
            <select name="level" id="level">
                <option value="Beginner">Cơ bản (Beginner)</option>
                <option value="Intermediate">Trung bình (Intermediate)</option>
                <option value="Advanced">Nâng cao (Advanced)</option>
            </select>
        </div>

        <div style="display: flex; gap: 20px;"> 
            <div class="form-group" style="flex: 1;">
                <label for="price">Giá ($):</label>
                <input type="number" name="price" id="price" value="0" min="0" step="0.01">
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="duration_weeks">Thời lượng (tuần):</label>
                <input type="number" name="duration_weeks" id="duration_weeks" value="4" min="1">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description" rows="5" placeholder="Mô tả chi tiết về khóa học..."></textarea>
        </div>

        <div class="form-group">
            <label for="image">Ảnh bìa (*):</label>
            <input type="file" name="image" id="image" required>
        </div>

        <hr>

        <button type="submit" class="btn btn-submit">Lưu khóa học</button>
        <a href="<?php echo BASE_URL; ?>course/manage" class="btn btn-back">Hủy bỏ</a>
    </form>
</div>

<?php include './views/layouts/footer.php'?>