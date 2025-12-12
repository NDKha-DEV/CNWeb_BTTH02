<?php include 'views/layouts/header.php';
    include 'views/layouts/sidebar.php'; ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">+ Thêm bài học mới</h4>
                </div>
                <div class="card-body">
                    
                    <form action="<?php echo BASE_URL; ?>lesson/create" method="POST">
                        
                        <input type="hidden" name="course_id" value="<?php echo isset($_GET['course_id']) ? $_GET['course_id'] : ''; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài học (*)</label>
                            <input type="text" name="title" class="form-control" required placeholder="Ví dụ: Bài 1 - Giới thiệu...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Video (YouTube/Drive)</label>
                            <input type="text" name="video_url" class="form-control" placeholder="https://...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Thứ tự hiển thị</label>
                            <input type="number" name="lesson_order" class="form-control" 
                                value="<?php echo isset($nextOrder) ? $nextOrder : 1; ?>" min="1">
                                
                            <div class="form-text">Hệ thống tự động đề xuất số tiếp theo.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nội dung chi tiết</label>
                            <textarea name="content" class="form-control" rows="5" placeholder="Mô tả nội dung bài học..."></textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo BASE_URL; ?>lesson?course_id=<?php echo isset($_GET['course_id']) ? $_GET['course_id'] : ''; ?>" class="btn btn-secondary">Hủy bỏ</a>
                            <button type="submit" class="btn btn-success">Lưu bài học</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>