<?php
// Bảo vệ trường hợp không có dữ liệu
if (!isset($lessons) || empty($lessons)) {
    echo "<p>Không có bài học nào trong khóa học này.</p>";
    return;
}
?>

<h2>Danh sách bài học</h2>

<ul>
    <?php foreach ($lessons as $lesson): ?>
        <li>
            <a href="<?php echo BASE_URL; ?>lesson/student?lesson_id=<?php 
            echo urlencode($lesson['id']); ?>&course_id=<?= urlencode($course_id) ?>">
                <?php echo htmlspecialchars($lesson['title']); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<p><a href="<?php echo BASE_URL; ?>enrollment">Trở về khóa học của tôi</a></p>