<?php include 'views/layouts/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Chỉnh sửa khóa học</h4>
                </div>
                
                <div class="card-body p-4">
                    <form action="<?php echo BASE_URL; ?>course/edit?id=<?php echo $this->courseModel->id; ?>" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Tiêu đề khóa học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($this->courseModel->title); ?>" required placeholder="Nhập tên khóa học...">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
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

                            <div class="col-md-6 mb-3">
                                <label for="level" class="form-label fw-bold">Trình độ</label>
                                <select class="form-select" id="level" name="level">
                                    <option value="Beginner" <?php echo ($this->courseModel->level == 'Beginner') ? 'selected' : ''; ?>>Cơ bản (Beginner)</option>
                                    <option value="Intermediate" <?php echo ($this->courseModel->level == 'Intermediate') ? 'selected' : ''; ?>>Trung bình (Intermediate)</option>
                                    <option value="Advanced" <?php echo ($this->courseModel->level == 'Advanced') ? 'selected' : ''; ?>>Nâng cao (Advanced)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">Giá ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?php echo $this->courseModel->price; ?>" min="0" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label fw-bold">Thời lượng (tuần)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="duration" name="duration_weeks" 
                                           value="<?php echo $this->courseModel->duration_weeks; ?>" min="1">
                                    <span class="input-group-text">Tuần</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô tả chi tiết</label>
                            <textarea class="form-control" id="description" name="description" rows="6" placeholder="Nhập nội dung mô tả..."><?php echo htmlspecialchars($this->courseModel->description); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh đại diện</label>
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <p class="text-muted mb-2">Ảnh hiện tại:</p>
                                    <?php 
                                        $imgName = !empty($this->courseModel->image) ? $this->courseModel->image : 'default.jpg';
                                        $webPath = BASE_URL . "assets/uploads/courses/" . $imgName;
                                    ?>
                                    <img src="<?php echo $webPath; ?>" alt="Current Course Image" class="img-thumbnail mb-3" style="max-height: 200px; object-fit: cover;">
                                    
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="image" accept="image/*" id="inputGroupFile02">
                                        <label class="input-group-text" for="inputGroupFile02">Upload ảnh mới</label>
                                    </div>
                                    <small class="text-muted fst-italic mt-1 d-block">* Để trống nếu bạn muốn giữ nguyên ảnh cũ.</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo BASE_URL; ?>course/manage" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Lưu cập nhật
                            </button>