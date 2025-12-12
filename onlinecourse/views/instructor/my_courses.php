<div class="container py-4">
    <h3 class="mb-4">🎓 Khóa học của tôi</h3>
    
    <div class="row">
        <?php if(isset($courses) && $courses->rowCount() > 0): ?>
            <?php while ($row = $courses->fetch(PDO::FETCH_ASSOC)): 
                
                // ❗ BỔ SUNG LOGIC XÁC ĐỊNH TRẠNG THÁI (Status)
                $status = (int)$row['status'];
                $statusText = 'Không rõ';
                $statusClass = 'badge-secondary'; // Bootstrap 5 uses bg-*
                
                switch ($status) {
                    case 1:
                        $statusText = 'Nháp';
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
                    default:
                        $statusText = 'Mới tạo';
                        $statusClass = 'bg-secondary';
                        break;
                }
                // ❗ HẾT LOGIC STATUS
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm hover-effect">
                        <?php 
                            $img = !empty($row['image']) ? $row['image'] : 'default.jpg';
                            $imgSrc = BASE_URL . "assets/uploads/courses/" . $img;
                        ?>
                        
                        <div style="position: relative;">
                            <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="Course Image" style="height: 180px; object-fit: cover;">
                            <span class="badge <?php echo $statusClass; ?> position-absolute top-0 end-0 m-2 py-2 px-3 fw-bold">
                                <?php echo $statusText; ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="<?php echo $row['title']; ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </h5>
                            <p class="card-text text-muted small mb-3">
                                <i class="bi bi-bar-chart"></i> <?php echo $row['level']; ?> | 
                                <i class="bi bi-clock"></i> <?php echo $row['duration_weeks']; ?> tuần
                            </p>
                            
                            <?php if ($status !== 2): ?>
                                <a href="<?php echo BASE_URL; ?>course/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mb-2 w-100">
                                    ✏️ Chỉnh sửa / Gửi duyệt
                                </a>
                            <?php endif; ?>
                            
                        </div>
                        
                        <div class="card-footer bg-white border-top-0 d-grid">
                            <a href="<?php echo BASE_URL; ?>course/students?course_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-people-fill"></i> Xem Học viên
                            </a>
                            <a href="<?php echo BASE_URL; ?>lesson?course_id=<?php echo $row['id'];?>" class="btn btn-outline-primary btn-sm mt-1">
                                📚 Quản lý Bài học
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">Bạn chưa có khóa học nào.</div>
            </div>
        <?php endif; ?>
    </div>
</div>