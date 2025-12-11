<?php include 'views/layouts/header.php';
    include 'views/layouts/sidebar.php';
    ?>
<div>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-primary">📚 Danh sách bài học</h2>
            <small class="text-muted">Khóa học: <strong><?php echo htmlspecialchars($courseTitle); ?></strong></small>
        </div>
        
        <div>
            <a href="<?php echo BASE_URL; ?>course/manage" class="btn btn-outline-secondary me-2">
                &larr; Quay lại
            </a>
            <a href="<?php echo BASE_URL; ?>lesson/create?course_id=<?php echo $course_id; ?>" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> + Thêm bài học mới
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" width="10%">Thứ tự</th>
                            <th scope="col" width="65%">Tên bài học</th>
                            <th scope="col" class="text-center" width="25%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($lessons->rowCount() > 0): ?>
                            <?php while ($row = $lessons->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-circle" style="width: 30px; height: 30px; line-height: 25px;">
                                        <?php echo $row['lesson_order']; ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></div>
                                </td>

                                <td class="text-center">
                                    <div class="" role="group">

                                        <a href="<?php echo BASE_URL; ?>lesson/uploadForm?id=<?php echo $row['id']; ?>" 
                                            class="btn btn-info btn-sm text-white" 
                                            title="Upload tài liệu">
                                            <i class="bi bi-cloud-upload"></i> Tài liệu
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>lesson/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                            ✏️ Sửa
                                        </a>

                                        <a href="<?php echo BASE_URL; ?>lesson/delete?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('⚠️ CẢNH BÁO:\nBạn có chắc chắn muốn xóa bài học này không?');">
                                           🗑️ Xóa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted mb-3">Chưa có bài học nào trong khóa này.</div>
                                    <a href="<?php echo BASE_URL; ?>lesson/create?course_id=<?php echo $course_id; ?>" class="btn btn-outline-primary">
                                        + Thêm bài học đầu tiên ngay
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 
</div>
<?php include 'views/layouts/footer.php';