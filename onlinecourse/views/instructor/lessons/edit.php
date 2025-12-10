<?php include 'views/layouts/header.php'; ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">✏️ Chỉnh sửa bài học</h4>
                </div>
                <div class="card-body">
                    
                    <form action="<?php echo BASE_URL; ?>lesson/edit?id=<?php echo $this->lessonModel->getId(); ?>" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài học (*)</label>
                            <input type="text" name="title" class="form-control" required 
                                   value="<?php echo htmlspecialchars($this->lessonModel->getTitle()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Video</label>
                            <input type="text" name="video_url" class="form-control" 
                                   value="<?php echo htmlspecialchars($this->lessonModel->getVideoUrl()); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Thứ tự hiển thị</label>
                            <input type="number" name="lesson_order" class="form-control" 
                                   value="<?php echo $this->lessonModel->getLessonOrder(); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nội dung chi tiết</label>
                            <textarea name="content" class="form-control" rows="6"><?php echo htmlspecialchars($this->lessonModel->getContent()); ?></textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo BASE_URL; ?>lesson?course_id=<?php echo $this->lessonModel->getCourseId(); ?>" class="btn btn-secondary">Hủy bỏ</a>
                            <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>