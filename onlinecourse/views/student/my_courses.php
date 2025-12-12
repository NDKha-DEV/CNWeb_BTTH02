<?php
// views/lessons/student.php

$page_title = "Các bài học";
$css_files = ['lessons-list.css']; // Liên kết tệp CSS mới

include './views/layouts/header.php';

// Bảo vệ trường hợp không có dữ liệu
if (!isset($lessons) || empty($lessons)) {
    ?>
    <div class="lessons-container">
        <h2>Danh sách bài học</h2>
        <p style="font-style: italic; color: var(--secondary-color);">
            Không có bài học nào trong khóa học này.
        </p>
        <div class="back-link">
            <a href="<?php echo BASE_URL; ?>enrollment">Trở về khóa học của tôi</a>
        </div>
    </div>
    <?php
    include './views/layouts/footer.php';
    return;
}
?>

<div class="lessons-container">
    <h2>Danh sách bài học</h2>

    <ul class="lesson-list">
        <?php foreach ($lessons as $lesson): ?>
            <li>
                <a href="<?php echo BASE_URL; ?>lesson/student?lesson_id=<?php 
                echo urlencode($lesson['id']); ?>&course_id=<?= urlencode($course_id) ?>">
                    <?php echo htmlspecialchars($lesson['title']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="back-link">
        <a href="<?php echo BASE_URL; ?>enrollment">Trở về khóa học của tôi</a>
    </div>
</div>

<?php include './views/layouts/footer.php' ?>