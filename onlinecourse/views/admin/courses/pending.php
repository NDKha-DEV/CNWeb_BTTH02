<?php
// views/admin/courses/pending.php

if (!isset($pending_courses)) {
    $pending_courses = [];
}

$page_title = "Duyệt Phê duyệt Khóa học Mới";
$css_files = ['admin-courses-pending.css']; // CSS đẹp riêng
include './views/layouts/header.php';
?>

<div class="pending-container">
    <div class="page-header">
        <div>
            <h1><?= $page_title ?></h1>
            <p class="subtitle">Danh sách khóa học đang chờ bạn phê duyệt (Trạng thái: Chờ duyệt)</p>
        </div>
        <a href="<?= BASE_URL ?>admin/dashboard" class="btn-back">
            Dashboard
        </a>
    </div>

    <!-- Thông báo thành công / lỗi -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_GET['success'] === 'approve'
                ? 'Khóa học đã được <strong>PHÊ DUYỆT</strong> thành công!'
                : 'Khóa học đã bị <strong>TỪ CHỐI</strong> thành công!';
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'update_failed'): ?>
        <div class="alert alert-error">
            Lỗi: Không thể cập nhật trạng thái khóa học. Vui lòng thử lại!
        </div>
    <?php endif; ?>

    <!-- Tổng quan -->
    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-number"><?= count($pending_courses) ?></span>
            <span class="stat-label">Khóa học chờ duyệt</span>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <?php if (!empty($pending_courses)): ?>
        <div class="table-responsive">
            <table class="pending-table">
                <thead>
                    <tr>
                        <th width="6%">#</th>
                        <th width="25%">Tiêu đề Khóa học</th>
                        <th width="28%">Mô tả ngắn</th>
                        <th width="16%">Giảng viên</th>
                        <th width="12%">Ngày tạo</th>
                        <th width="13%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_courses as $course): ?>
                        <tr>
                            <td><strong>#<?= htmlspecialchars($course['id']) ?></strong></td>
                            <td class="course-title">
                                <div class="title-text"><?= htmlspecialchars($course['title']) ?></div>
                            </td>
                            <td class="description-cell">
                                <div class="truncate-text" title="<?= htmlspecialchars($course['description']) ?>">
                                    <?= htmlspecialchars($course['description']) ?: '<em>Chưa có mô tả</em>' ?>
                                </div>
                            </td>
                            <td class="in Itructor">
                                <div class="instructor-info">
                                    <strong><?= htmlspecialchars($course['instructor_name']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($course['instructor_email']) ?></small>
                                </div>
                            </td>
                            <td class="text-center">
                                <?= date('d/m/Y', strtotime($course['created_at'])) ?>
                            </td>
                            <td class="actions">
                                <!-- Phê duyệt -->
                                <form method="POST" action="<?= BASE_URL ?>admin/courses/review" class="action-form">
                                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn-approve" 
                                            onclick="return confirm('✅ Bạn chắc chắn muốn PHÊ DUYỆT khóa học:\n\n\"<?= addslashes(htmlspecialchars($course['title'])) ?>\"?')">
                                        Phê duyệt
                                    </button>
                                </form>

                                <!-- Từ chối -->
                                <form method="POST" action="<?= BASE_URL ?>admin/courses/review" class="action-form">
                                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn-reject"
                                            onclick="return confirm('❌ Bạn chắc chắn muốn TỪ CHỐI khóa học:\n\n\"<?= addslashes(htmlspecialchars($course['title'])) ?>\"?\n\nKhóa học sẽ bị ẩn khỏi hệ thống.')">
                                        Từ chối
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">🎉</div>
            <h3>Không có khóa học nào đang chờ duyệt</h3>
            <p>Tất cả khóa học mới đã được xử lý. Tuyệt vời!</p>
            <a href="<?= BASE_URL ?>admin/dashboard" class="btn-primary">Về Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<?php include './views/layouts/footer.php'; ?>