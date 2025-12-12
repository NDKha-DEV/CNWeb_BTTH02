<?php 
    include 'views/layouts/header.php';
    include 'views/layouts/sidebar.php';
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
                            <th scope="col" width="25%">Tên khóa học</th>
                            <th scope="col" width="15%">Giá / Trình độ</th>
                            <th scope="col" class="text-center" width="15%">Trạng thái</th> <th scope="col" class="text-center" width="25%">Hành động</th>
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
                                        $badgeClass = 'bg-secondary';
                                        if($row['level'] == 'Beginner') $badgeClass = 'bg-success';
                                        elseif($row['level'] == 'Intermediate') $badgeClass = 'bg-warning text-dark';
                                        elseif($row['level'] == 'Advanced') $badgeClass = 'bg-danger';
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> rounded-pill">
                                        <?php echo $row['level']; ?>
                                    </span>
                                </td>
                                
<td>
                                    <?php 
                                        $status = (int)$row['status'];
                                        // Logic xác định $statusText và $statusClass đã được giữ nguyên và chạy đúng
                                        $statusText = 'Không rõ';
                                        $statusClass = 'bg-secondary';
                                        // ... (Logic switch case của bạn) ...
                                        switch ($status) {
                                            case 1:
                                                $statusText = 'Nháp (Draft)';
                                                $statusClass = 'bg-info text-dark';
                                                break;
                                            case 2:
                                                $statusText = 'Đã xuất bản';
                                                $statusClass = 'bg-success';
                                                break;
                                            case 3:
                                                $statusText = 'Chờ duyệt';
                                                $statusClass = 'bg-warning text-dark';
                                                break;
                                            case 4:
                                                $statusText = 'Bị từ chối';
                                                $statusClass = 'bg-danger';
                                                break;
                                        }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?> py-2 px-3">
                                        <?php echo $statusText; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    
                                    <a href="<?php echo BASE_URL; ?>lesson?course_id=<?php echo $row['id'];?>" class="btn btn-sm btn-info text-white mb-1" title="Quản lý bài học">
                                        📚 Bài học
                                    </a>

                                    <?php if ($status == 1 || $status == 4): // Chỉ hiển thị Sửa, Xóa và Gửi duyệt nếu là Nháp hoặc Bị từ chối ?>
                                        
                                        <form method="POST" action="<?= BASE_URL ?>course/submit-review" style="display: inline-block;">
                                            <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-success mb-1" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn gửi khóa học này đi duyệt không?');"
                                                    title="Gửi khóa học đến Admin để phê duyệt">
                                                ✅ Gửi đi duyệt
                                            </button>
                                        </form>
                                        <a href="<?php echo BASE_URL; ?>course/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mb-1" title="Chỉnh sửa">
                                            ✏️ Sửa
                                        </a>

                                        <a href="<?php echo BASE_URL; ?>course/delete?id=<?php echo $row['id']; ?>" 
                                            class="btn btn-sm btn-danger mb-1"
                                            onclick="return confirm('⚠️ CẢNH BÁO:\nBạn có chắc chắn muốn xóa khóa học này?');"
                                            title="Xóa">
                                            🗑️ Xóa
                                        </a>
                                    
                                    <?php elseif ($status == 3): // Khóa học đang chờ duyệt ?>
                                        
                                        <button class="btn btn-sm btn-secondary mb-1" disabled title="Khóa học đang trong quá trình Admin xem xét">
                                            ⏳ Đang chờ duyệt
                                        </button>
                                        
                                        <a href="<?php echo BASE_URL; ?>course/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mb-1" title="Xem chi tiết (Không chỉnh sửa được)">
                                            🔍 Xem
                                        </a>

                                    <?php elseif ($status == 2): // Khóa học đã xuất bản ?>

                                        <button class="btn btn-sm btn-secondary mb-1" disabled title="Khóa học đã được xuất bản">
                                            👍 Đã duyệt
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>course/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mb-1" title="Xem chi tiết (Không chỉnh sửa được)">
                                            🔍 Xem
                                        </a>
                                        
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5"> <div class="text-muted mb-3">Bạn chưa tạo khóa học nào.</div>
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
<?php include 'views/layouts/footer.php'; ?>