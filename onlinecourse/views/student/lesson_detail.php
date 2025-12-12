<?php
// views/lessons/detail.php

$page_title = "Chi tiết bài học";
// Liên kết tệp CSS mới
$css_files = ['lesson-details.css']; 

include './views/layouts/header.php';

// Giả sử các biến $lesson, $materials, $course_id đã được load từ controller
?>

<div class="lesson-container">

    <div class="lesson-header">
        <h2>
            <?php echo htmlspecialchars($lesson['title']); ?>
        </h2>

        <?php if (!empty($lesson['created_at'])): ?>
            <p class="lesson-metadata">
                Ngày tạo: <?php echo htmlspecialchars($lesson['created_at']); ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="lesson-content">
        <?php 
        // Sử dụng nl2br() để giữ định dạng xuống dòng từ database
        echo nl2br(htmlspecialchars($lesson['content'] ?? 'Nội dung bài học đang được cập nhật.')); 
        ?>
    </div>

    <?php if (!empty($lesson['video_url'])): ?>
        <div>
            <h3>Video bài học</h3>

            <?php
                $video = $lesson['video_url'];

                // Logic chuyển đổi link YouTube sang định dạng embed
                if (strpos($video, "youtube.com/watch") !== false) {
                    $video = str_replace("watch?v=", "embed/", $video);
                }
                if (strpos($video, "youtu.be") !== false) {
                    $id = substr(strrchr($video, "/"), 1);
                    $video = "https://www.youtube.com/embed/" . $id;
                }
                // Thêm autoplay=0 và rel=0 để cải thiện UX
                $video_embed_url = $video . '?autoplay=0&rel=0';
            ?>

            <div class="video-wrapper">
                <iframe
                    src="<?php echo htmlspecialchars($video_embed_url); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    <?php endif; ?>

    <div class="materials-list">
        <h3>Tài liệu đính kèm</h3>

        <?php if (!empty($materials)): ?>
            <ul>
                <?php foreach ($materials as $m): ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($m['file_path']); ?>" download>
                            <?php echo htmlspecialchars($m['filename']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p style="font-style: italic;">Không có tài liệu đính kèm cho bài học này.</p>
        <?php endif; ?>
    </div>
    
</div>

<div class="back-link">
    <a href="<?php echo BASE_URL; ?>lessons/student?course_id=<?= htmlspecialchars($course_id ?? '') ?>">Trở lại danh sách bài học</a>
</div>

<?php
include './views/layouts/footer.php';
?>