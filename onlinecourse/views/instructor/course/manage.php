<?php 
// Đảm bảo logic này nằm trong controller hoặc trên cùng của view
$page_title='My courses';
$css_files = ['instructor-manage-courses.css']; 
include './views/layouts/header.php'; 

// Hàm PHP để xác định trạng thái và class (giúp code gọn gàng hơn)
function getStatusInfo($status) {
    $status = (int)$status;
    $info = [
        'text' => 'Không rõ', 
        'class' => 'bg-secondary'
    ];
    switch ($status) {
        case 1:
            $info = ['text' => 'Nháp (Draft)', 'class' => 'bg-info text-dark'];
            break;
        case 2:
            $info = ['text' => 'Đã xuất bản', 'class' => 'bg-success'];
            break;
        case 3:
            $info = ['text' => 'Chờ duyệt', 'class' => 'bg-warning text-dark'];
            break;
        case 4:
            $info = ['text' => 'Bị từ chối', 'class' => 'bg-danger'];
            break;
    }
    return $info;
}
?>

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
                            <th scope="col" class="text-center" width="15%">Trạng thái</th> 
                            <th scope="col" class="text-center" width="25%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($courses) && $courses->rowCount() > 0): 
                            while ($row = $courses->fetch(PDO::FETCH_ASSOC)): 
                                // Lấy thông tin trạng thái
                                $status = (int)($row['status'] ?? 0);
                                $statusInfo = getStatusInfo($status);
                        ?>
                            <tr>
                                <td class="text-center text-muted"><?php echo htmlspecialchars($row['id']); ?></td>

                                <td>
                                    <?php 
                                        $imgName = !empty($row['image']) ? $row['image'] : 'default.jpg';
                                        $webPath = BASE_URL . "assets/uploads/courses/" . $imgName;
                                        $sysPath = "assets/uploads/courses/" . $imgName; // Cần đường dẫn hệ thống thực tế
                                        
                                        // Kiểm tra sự tồn tại của ảnh trước khi hiển thị (tùy chọn)
                                        $displayPath = (file_exists($sysPath) && $row['image']) ? $webPath : BASE_URL.'assets/uploads/courses/default.jpg';

                                        echo '<img src="'.htmlspecialchars($displayPath).'" class="img-thumbnail rounded" style="width: 100px; height: 60px; object-fit: cover;" alt="Ảnh Khóa học">';
                                    ?>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> Thời lượng: <?php echo htmlspecialchars($row['duration_weeks'] ?? 'N/A'); ?> tuần
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-bold text-danger mb-1">
                                        $<?php echo number_format((float)($row['price'] ?? 0)); ?>
                                    </div>
                                    <?php 
                                         $level = $row['level'] ?? '';
                                         $badgeClass = 'bg-secondary';
                                         if($level == 'Beginner') $badgeClass = 'bg-success';
                                         elseif($level == 'Intermediate') $badgeClass = 'bg-warning text-dark';
                                         elseif($level == 'Advanced') $badgeClass = 'bg-danger';
                                    ?>
                                    <span class="badge <?php echo htmlspecialchars($badgeClass); ?> rounded-pill">
                                        <?php echo htmlspecialchars($level); ?>
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge <?php echo htmlspecialchars($statusInfo['class']); ?> py-2 px-3">
                                        <?php echo htmlspecialchars($statusInfo['text']); ?>
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    
                                    <a href="<?php echo BASE_URL; ?>lesson?course_id=<?php echo $row['id'];?>" class="btn btn-sm btn-info text-white mb-1" title="Quản lý bài học">
                                        📚 Bài học
                                    </a>

                                    <?php if ($status == 1 || $status == 4): // Nháp hoặc Bị từ chối (cần chỉnh sửa/gửi duyệt) ?>
                                        
                                        <a href="<?php echo BASE_URL; ?>course/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mb-1" title="Chỉnh sửa">
                                            ✏️ Sửa
                                        </a>

                                        <form method="POST" action="<?= BASE_URL ?>course/submit-review" style="display: inline-block;">
                                            <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-success mb-1" 
                                                    onclick="return confirm('Bạn có chắc chắn muốn gửi khóa học này đi duyệt không?');"
                                                    title="Gửi khóa học đến Admin để phê duyệt">
                                                ✅ Gửi đi duyệt
                                            </button>
                                        </form>

                                        <a href="<?php echo BASE_URL; ?>course/delete?id=<?php echo $row['id']; ?>" 
                                            class="btn btn-sm btn-danger mb-1"
                                            onclick="return confirm('⚠️ CẢNH BÁO:\nBạn có chắc chắn muốn xóa khóa học này?');"
                                            title="Xóa">
                                            🗑️ Xóa
                                        </a>
                                    
                                    <?php elseif ($status == 3 || $status == 2): // Chờ duyệt hoặc Đã xuất bản (chỉ xem) ?>

                                        <button class="btn btn-sm btn-secondary mb-1" disabled title="Khóa học đã được gửi/xuất bản, không thể chỉnh sửa">
                                            <?php echo ($status == 3) ? '⏳ Đang chờ duyệt' : '👍 Đã duyệt'; ?>
                                        </button>
                                        
                                        <a href="<?php echo BASE_URL; ?>course/edit?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning mb-1" title="Xem chi tiết">
                                            🔍 Xem
                                        </a>
                                        
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5"> 
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
<?php include './views/layouts/footer.php'; ?>