<?php
// views/admin/courses/pending.php

// Giả định: Biến $pending_courses đã được AdminController::pendingCourses() truyền vào
if (!isset($pending_courses)) {
    $pending_courses = [];
}

$page_title = "Duyệt Phê duyệt Khóa học Mới";
// require 'views/layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <style>
        .pending-container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        .pending-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .pending-table th, .pending-table td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: top; }
        .action-form { display: inline-block; margin-right: 5px; }
        .approve-btn { background: #28a745; color: white; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .reject-btn { background: #dc3545; color: white; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .description-cell { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    </style>
</head>
<body>

    <div class="pending-container">
        <h1><?= $page_title ?></h1>
        <p>Danh sách các khóa học đang chờ được quản trị viên phê duyệt (Status = 3).</p>
        
        <?php 
        // Hiển thị thông báo (Thành công/Thất bại từ Controller)
        if (isset($_GET['success'])) {
            $action = htmlspecialchars($_GET['success']);
            $msg = ($action === 'approve') ? "Khóa học đã được PHÊ DUYỆT thành công." : "Khóa học đã bị TỪ CHỐI thành công.";
            echo "<p style='color: green; font-weight: bold;'>{$msg}</p>";
        }
        if (isset($_GET['error']) && $_GET['error'] === 'update_failed') {
            echo "<p style='color: red; font-weight: bold;'>Lỗi: Cập nhật trạng thái khóa học thất bại.</p>";
        }
        ?>

        <h2>Tổng cộng: <?= count($pending_courses) ?> Khóa học</h2>

        <table class="pending-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề Khóa học</th>
                    <th>Mô tả tóm tắt</th>
                    <th>Giảng viên</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pending_courses)): ?>
                    <?php foreach ($pending_courses as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['id']) ?></td>
                            <td><?= htmlspecialchars($course['title']) ?></td>
                            <td class="description-cell" title="<?= htmlspecialchars($course['description']) ?>">
                                <?= htmlspecialchars($course['description']) ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($course['instructor_name']) ?></strong><br>
                                <small>(<?= htmlspecialchars($course['instructor_email']) ?>)</small>
                            </td>
                            <td><?= date('d/m/Y', strtotime($course['created_at'])) ?></td>
                            <td>
                                <form method="POST" action="<?= BASE_URL ?>admin/courses/review" class="action-form">
                                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="approve-btn" onclick="return confirm('Xác nhận PHÊ DUYỆT khóa học này?');">Phê duyệt</button>
                                </form>

                                <form method="POST" action="<?= BASE_URL ?>admin/courses/review" class="action-form">
                                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="reject-btn" onclick="return confirm('Xác nhận TỪ CHỐI khóa học này?');">Từ chối</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">🎉 Không có khóa học nào đang chờ duyệt.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <p style="text-align: center;">Quay lại <a href="<?= BASE_URL ?>admin/dashboard">Dashboard</a></p>

</body>
</html>

<?php 
// require 'views/layouts/footer.php'; 
?>