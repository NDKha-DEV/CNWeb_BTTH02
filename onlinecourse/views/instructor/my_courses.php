<div class="container py-4">
    <h3 class="mb-4">🎓 Khóa học của tôi</h3>
    
    <div class="row">
        <?php if(isset($courses) && $courses->rowCount() > 0): ?>
            <?php while ($row = $courses->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm hover-effect">
                        <?php 
                            $img = !empty($row['image']) ? $row['image'] : 'default.jpg';
                            $imgSrc = BASE_URL . "assets/uploads/courses/" . $img;
                        ?>
                        <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="Course Image" style="height: 180px; object-fit: cover;">
                        
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="<?php echo $row['title']; ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-bar-chart"></i> <?php echo $row['level']; ?> | 
                                <i class="bi bi-clock"></i> <?php echo $row['duration_weeks']; ?> tuần
                            </p>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0 d-grid">
                            <a href="<?php echo BASE_URL; ?>course/students?course_id=<?php echo $row['id']; ?>" class="btn btn-primary">
                                <i class="bi bi-people-fill"></i> Xem Học viên
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
</div