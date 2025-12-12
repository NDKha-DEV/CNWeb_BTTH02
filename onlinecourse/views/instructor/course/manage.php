<?php 
    include 'views/layouts/header.php';
?>
<div>
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-primary">📂 Danh sách khóa học của tôi</h2>
        <a href="<?php echo BASE_URL; ?>course/create" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> + Thêm khóa học mới
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" width="5%">ID</th>
                            <th scope="col" width="12%">Ảnh bìa</th>
                            <th scope="col" width="30%">Tên khóa học</th>
                            <th scope="col" width="18%">Giá / Trình độ</th>
                            <th scope="col" width="10%">Trạng thái</th>
                            <th scope="col" class="text-center" width="25%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($courses) && $courses->rowCount() > 0): 
                            while ($row = $courses->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                            <tr>
                                <td class="text-center text-muted"><?php echo $row['id']; ?></td>

                                <td>
                                    <?php 
                                        $imgName = !empty($row['image']) ? $row['image'] : 'default.jpg';
                                        $webPath = BASE_URL . "assets/uploads/courses/" . $imgName;
                                        $sysPath = "assets/uploads/courses/" . $imgName;
                                        
                                        // Sử dụng class img-thumbnail và rounded của Bootstrap
                                        if (file_exists($sysPath)) {
                                            echo '<img src="'.$webPath.'" class="img-thumbnail rounded" style="width: 100px; height: 60px; object-fit: cover;">';
                                        } else {
                                            echo '<img src="'.BASE_URL.'assets/uploads/courses/default.jpg" class="img-thumbnail rounded" style="width: 100px; height: 60px; object-fit: cover;" alt="Default">';
                                        }
                                    ?>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> Thời lượng: <?php echo $row['duration_weeks']; ?> tuần
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-bold text-danger mb-1">
                                        $<?php echo number_format($row['price']); ?>
                                    </div>
                                    <?php 
                                        // Logic màu sắc badge dựa trên trình độ
                                        $badgeClass = 'bg-secondary';
                                        if($row['level'] == 'Beginner') $badgeClass = 'bg-success';
                                        elseif($row['level'] == 'Intermediate') $badgeClass = 'bg-warning text-dark';
                                        elseif($row['level'] == 'Advanced') $badgeClass = 'bg-danger';
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> rounded-pill">
                                        <?php echo $row['level']; ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <?php 
                                        if($row['status'] == 1): 
                                    ?>
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success">
                                            <i class="bi bi-check-circle-fill me-1"></i> Công khai
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill border border-secondary">
                                            <i class="bi bi-eye-slash-fill me-1"></i> Đang ẩn
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <!-- <div class="btn-group" role="group"> -->
                                        <a href="<?php echo BASE_URL; ?>lesson?course_id=<?php echo $row['id'];?>" class="btn btn-sm btn-info text-white" title="Quản lý bài học">
                                            📚 Bài học
                                        </a>

                                        <a href="<?php echo BASE_URL; ?>course/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                            ✏️ Sửa
                                        </a>

                                        <a href="<?php echo BASE_URL; ?>course/delete?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('⚠️ CẢNH BÁO:\nBạn có chắc chắn muốn xóa khóa học này?\nHành động này không thể hoàn tác!');"
                                           title="Xóa">
                                           🗑️ Xóa
                                        </a>
                                    <!-- </div> -->
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-3">Bạn chưa tạo khóa học nào.</div>
                                    <a href="<?php echo BASE_URL; ?>course/create" class="btn btn-outline-primary">
                                        + Tạo khóa học đầu tiên ngay
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="<?php echo BASE_URL; ?>instructor/dashboard" class="text-decoration-none text-secondary">
            &larr; Quay về trang chủ
        </a>
    </div>

</div>    
</div>
<?php include 'views/layouts/footer.php';