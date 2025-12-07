<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa khóa học</title>
    <style>
        /* CSS cơ bản để giao diện gọn gàng hơn */
        body { font-family: sans-serif; padding: 20px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="number"], select, textarea, input[type="file"] {
            width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;
        }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; color: white; text-decoration: none; display: inline-block;}
        .btn-submit { background-color: #ffc107; color: black; } /* Màu vàng cho nút sửa */
        .btn-back { background-color: #6c757d; margin-right: 10px; }
        
        /* Style hiển thị ảnh cũ */
        .current-image-box { margin: 10px 0; padding: 10px; border: 1px dashed #ccc; background: #f9f9f9; display: inline-block;}
        .current-image-box img { max-width: 200px; height: auto; display: block; margin-bottom: 5px; }
        .note { font-size: 0.9em; color: #666; font-style: italic; }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Chỉnh sửa khóa học</h2>
    
    <form action="index.php?controller=course&action=update&id=<?php echo $this->course->id; ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Tiêu đề khóa học (*):</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($this->course->title); ?>" required>
        </div>

        <div class="form-group">
            <label>Danh mục (*):</label>
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php 
                if(isset($categories)){
                    while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) {
                        // Logic so sánh: Nếu ID danh mục trong vòng lặp bằng ID danh mục của khóa học -> thêm chữ 'selected'
                        $selected = ($cat['id'] == $this->course->category_id) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Trình độ:</label>
            <select name="level">
                <option value="Beginner" <?php echo ($this->course->level == 'Beginner') ? 'selected' : ''; ?>>Cơ bản (Beginner)</option>
                <option value="Intermediate" <?php echo ($this->course->level == 'Intermediate') ? 'selected' : ''; ?>>Trung bình (Intermediate)</option>
                <option value="Advanced" <?php echo ($this->course->level == 'Advanced') ? 'selected' : ''; ?>>Nâng cao (Advanced)</option>
            </select>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label>Giá ($):</label>
                <input type="number" name="price" value="<?php echo $this->course->price; ?>" min="0" step="0.01">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Thời lượng (tuần):</label>
                <input type="number" name="duration_weeks" value="<?php echo $this->course->duration_weeks; ?>" min="1">
            </div>
        </div>

        <div class="form-group">
            <label>Mô tả chi tiết:</label>
            <textarea name="description" rows="6"><?php echo htmlspecialchars($this->course->description); ?></textarea>
        </div>

        <div class="form-group">
            <label>Ảnh đại diện:</label>
            
            <div class="current-image-box">
                <div>Ảnh hiện tại:</div>
                <?php 
                    // Xây dựng đường dẫn ảnh
                    $imgName = !empty($this->course->image) ? $this->course->image : 'default.jpg';
                    $imgPath = "assets/uploads/courses/" . $imgName;

                    if (file_exists($imgPath)) {
                        echo "<img src='$imgPath' alt='Course Image'>";
                    } else {
                        echo "<span style='color:red'>Ảnh không tồn tại ($imgName)</span>";
                    }
                ?>
            </div>

            <label>Chọn ảnh mới (Nếu muốn thay đổi):</label>
            <input type="file" name="image" accept="image/*">
            <div class="note">* Lưu ý: Nếu bạn không chọn file mới, hệ thống sẽ giữ nguyên ảnh cũ.</div>
        </div>

        <hr>
        
        <button type="submit" class="btn btn-submit">Lưu cập nhật</button>
        <a href="index.php?controller=course&action=index" class="btn btn-back">Hủy bỏ</a>

    </form>
</div>

</body>
</html>