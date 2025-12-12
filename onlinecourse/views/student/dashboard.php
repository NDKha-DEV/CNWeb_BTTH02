<?php
// views/courses/my-courses.php

$page_title = "Khóa học của tôi";
// Sử dụng tên tệp CSS phù hợp với giao diện bạn đã chọn
// Nếu bạn sử dụng tệp my-courses.css tôi cung cấp, hãy thay đổi dòng này:
$css_files = ['my-courses.css']; 
// Hoặc nếu bạn muốn giữ tên cũ:
// $css_files = ['admin-create-instructor.css']; 

include './views/layouts/header.php';
?>

<div class="container">

    <h2>Danh sách khóa học đã đăng ký</h2>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Tên Khóa Học</th>
                    <th style="width: 25%;">Mô tả</th> <th>Giảng viên</th>
                    <th>Ngày đăng ký</th>
                    <th>Tiến độ</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($enrollments )): ?>
                    <?php foreach ($enrollments as $item): 
                        // Đảm bảo $item['progress'] là số và không null
                        $progress = (int)($item['progress'] ?? 0);
                        // Đảm bảo $item['status'] tồn tại
                        $status = $item['status'] ?? 'cancelled'; 
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>

                        <td><?= htmlspecialchars(mb_substr($item['description'], 0, 80)) ?><?= (mb_strlen($item['description']) > 80) ? '...' : '' ?></td>

                        <td><?= htmlspecialchars($item['instructor_name']) ?></td>

                        <td><?= htmlspecialchars($item['enrolled_date']) ?></td>

                        <td class="progress-cell">
                            <div class="progress-text" style="font-weight: bold;"><?= $progress ?>%</div>
                            <div class="progress-container">
                                <div class="progress-bar" style="width: <?= $progress ?>%;"></div>
                            </div>
                        </td>

                        <td>
                            <?php if ($status === 'active'): ?>
                                <span class="status-tag status-active">Đang học</span>
                            <?php elseif ($status === 'completed'): ?>
                                <span class="status-tag status-completed">Hoàn thành</span>
                            <?php else: ?>
                                <span class="status-tag status-cancelled">Đã hủy</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="<?php echo BASE_URL; ?>lessons/student?course_id=<?= $item['course_id'] ?>">Xem</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; font-style: italic;">
                            Bạn chưa đăng ký bất kỳ khóa học nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <p style="margin-top:25px;">
        <a href="<?php echo BASE_URL; ?>">Trở Về Trang Chủ</a>
    </p>
</div>
<?php 
include './views/layouts/footer.php'; 
?>