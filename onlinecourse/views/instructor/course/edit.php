

<div class="container">
    <h2>✏️ Chỉnh sửa khóa học</h2>
    
    <form action="<?php echo BASE_URL; ?>course/edit?id=<?php echo $this->courseModel->id; ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Tiêu đề khóa học (*):</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($this->courseModel->title); ?>" required>
        </div>

        <div class="form-group">
            <label>Danh mục (*):</label>
            <select name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                <?php 
                if(isset($categories)){
                    while ($cat = $categories->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($cat['id'] == $this->courseModel->category_id) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Trình độ:</label>
            <select name="level">
                <option value="Beginner" <?php echo ($this->courseModel->level == 'Beginner') ? 'selected' : ''; ?>>Cơ bản (Beginner)</option>
                <option value="Intermediate" <?php echo ($this->courseModel->level == 'Intermediate') ? 'selected' : ''; ?>>Trung bình (Intermediate)</option>
                <option value="Advanced" <?php echo ($this->courseModel->level == 'Advanced') ? 'selected' : ''; ?>>Nâng cao (Advanced)</option>
            </select>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label>Giá ($):</label>
                <input type="number" name="price" value="<?php echo $this->courseModel->price; ?>" min="0" step="0.01">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Thời lượng (tuần):</label>
                <input type="number" name="duration_weeks" value="<?php echo $this->courseModel->duration_weeks; ?>" min="1">
            </div>
        </div>

        <div class="form-group">
            <label>Mô tả chi tiết:</label>
            <textarea name="description" rows="6"><?php echo htmlspecialchars($this->courseModel->description); ?></textarea>
        </div>

        <div class="form-group">
            <label>Ảnh đại diện:</label>
            
            <div class="current-image-box">
                <div>Ảnh hiện tại:</div>
                <?php 
                    $imgName = !empty($this->courseModel->image) ? $this->courseModel->image : 'default.jpg';
                    $webPath = BASE_URL . "assets/uploads/courses/" . $imgName;
                    echo "<img src='$webPath' alt='Course Image'>";
                ?>
            </div>

            <label>Chọn ảnh mới (Nếu muốn thay đổi):</label>
            <input type="file" name="image" accept="image/*">
            <div class="note">* Lưu ý: Nếu bạn không chọn file mới, hệ thống sẽ giữ nguyên ảnh cũ.</div>
        </div>

        <hr>
        
        <button type="submit" class="btn btn-submit">Lưu cập nhật</button>
        <a href="<?php echo BASE_URL; ?>course/manage" class="btn btn-back">Hủy bỏ</a>

    </form>
</div>

