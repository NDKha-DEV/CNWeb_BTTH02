<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($lesson['title']) ?></title>

    <style>
        body { font-family: Arial; margin: 20px; }
        .lesson-box { padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        h2 { margin-bottom: 10px; }
        .video-box { margin: 15px 0; }
        .materials { margin-top: 25px; }
        .materials ul { list-style: none; padding-left: 0; }
        .materials li { margin-bottom: 8px; }
        .back-link { margin-top: 20px; display: inline-block; }
    </style>
</head>

<body>

<div class="lesson-box">

    <h2><?= htmlspecialchars($lesson['title']) ?></h2>

    <p><b>Ngày tạo:</b> <?= htmlspecialchars($lesson['created_at']) ?></p>

    <hr>

    <!-- VIDEO -->
    <?php if (!empty($lesson['video_url'])): ?>
        <div class="video-box">
            <h3>Video bài học</h3>
            <iframe width="560" height="315"
                src="<?= htmlspecialchars($lesson['video_url']) ?>"
                frameborder="0" allowfullscreen>
            </iframe>
        </div>
    <?php endif; ?>

    <hr>

    <!-- NỘI DUNG BÀI HỌC -->
    <h3>Nội dung bài học</h3>
    <div>
        <?= nl2br($lesson['content']) ?>
    </div>

    <hr>

    <!-- TÀI LIỆU ĐÍNH KÈM -->
    <div class="materials">
        <h3>Tài liệu đính kèm</h3>

        <?php if (!empty($materials)): ?>
            <ul>
                <?php foreach ($materials as $m): ?>
                    <li>
                        📄 
                        <a href="<?= BASE_URL . 'uploads/materials/' . htmlspecialchars($m['file_path']) ?>"
                           target="_blank">
                           <?= htmlspecialchars($m['filename']) ?> (<?= htmlspecialchars($m['file_type']) ?>)
                        </a>
                        - <small>Tải lên: <?= htmlspecialchars($m['uploaded_at']) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Không có tài liệu đính kèm.</p>
        <?php endif; ?>
    </div>

</div>

<a class="back-link" href="<?php echo BASE_URL; ?>enrollment">Trở lại khóa học của tôi</a>

</body>
</html>