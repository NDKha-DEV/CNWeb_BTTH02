<?php include 'views/layouts/header.php' ?>
<div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="mb-3">
                <a href="<?php echo BASE_URL; ?>lesson?course_id=<?php echo $this->lessonModel->course_id ?? $this->lessonModel->getCourseId(); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách bài học
                </a>
            </div>

            <div class="card shadow-sm mb-4 bg-light border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">📌 Thông tin bài học</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 fw-bold">Tên bài học:</div>
                        <div class="col-md-9"><?php echo htmlspecialchars($this->lessonModel->getTitle()); ?></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3 fw-bold">Thứ tự:</div>
                        <div class="col-md-9">Bài số <?php echo htmlspecialchars($this->lessonModel->getLessonOrder()); ?></div>
                    </div>
                     <div class="row mt-2">
                        <div class="col-md-3 fw-bold">Video URL:</div>
                        <div class="col-md-9 text-truncate"><?php echo htmlspecialchars($this->lessonModel->getVideoUrl()); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="card shadow-sm">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-cloud-upload"></i> Upload Tài Liệu</h6>
    </div>
    
    <div class="card-body">
        <form action="<?php echo BASE_URL; ?>lesson/upload" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="id" value="<?php echo $this->lessonModel->getId(); ?>">
            
            <div class="mb-3 text-center p-3 border border-1 border-dashed rounded bg-light">
                <i class="bi bi-cloud-arrow-up display-6 text-success"></i>
                
                <label for="material_file" class="form-label d-block mt-2 fw-bold small">Chọn file</label>
                
                <input type="file" class="form-control form-control-sm" name="material_file" id="material_file" required>
                
                <div class="form-text mt-1" style="font-size: 0.8rem;">
                    PDF, DOCX, ZIP, MP4 (Max 20MB)
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-check-circle"></i> Tải lên ngay
                </button>
            </div>
        </form>
    </div>
</div>

<?php if(isset($materials) && count($materials) > 0): ?>
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-light fw-bold small">
            Danh sách file
        </div>
        <ul class="list-group list-group-flush small">
            <?php foreach($materials as $file): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="text-truncate me-2" title="<?php echo $file['filename']; ?>">
                        <a href="<?php echo BASE_URL . 'assets/uploads/materials/' . $file['file_path']; ?>" target="_blank" class="text-decoration-none text-dark">
                            📄 <?php echo $file['filename']; ?>
                        </a>
                    </div>
                    </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>