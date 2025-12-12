<div style="padding: 20px; max-width: 800px; margin: auto;">

    <!-- Tiêu đề bài học -->
    <h2>
        <?php echo htmlspecialchars($lesson['title']); ?>
    </h2>

    <!-- Ngày tạo -->
    <?php if (!empty($lesson['created_at'])): ?>
        <p style="color: #888; font-size: 14px;">
            Ngày tạo: <?php echo htmlspecialchars($lesson['created_at']); ?>
        </p>
    <?php endif; ?>

    <hr>

    <!-- Nội dung bài học -->
    <div style="margin-top: 15px; line-height: 1.6;">
        <?php echo nl2br(htmlspecialchars($lesson['content'])); ?>
    </div>

    <!-- Video nhúng -->
    <?php if (!empty($lesson['video_url'])): ?>
        <div style="margin-top: 25px;">
            <h3>Video bài học</h3>

            <?php
                $video = $lesson['video_url'];

                // Nếu là link YouTube dạng watch?v= thì đổi sang embed
                if (strpos($video, "youtube.com/watch") !== false) {
                    $video = str_replace("watch?v=", "embed/", $video);
                }

                // Nếu là link youtu.be ngắn thì cũng chuyển sang embed
                if (strpos($video, "youtu.be") !== false) {
                    $id = substr(strrchr($video, "/"), 1);
                    $video = "https://www.youtube.com/embed/" . $id;
                }
            ?>

            <iframe width="100%" height="400"
                    src="<?php echo htmlspecialchars($video); ?>"
                    frameborder="0"
                    allowfullscreen>
            </iframe>
        </div>
    <?php endif; ?>

    <!-- Tài liệu -->
    <div style="margin-top: 30px;">
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
            <p>Không có tài liệu nào.</p>
        <?php endif; ?>
    </div>

</div>

<p><a href="<?php echo BASE_URL; ?>lessons/student?course_id=<?= $course_id ?>">Trở lại danh sách bài học</a></p>
