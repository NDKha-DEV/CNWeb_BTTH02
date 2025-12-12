<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khóa học đã đăng ký</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2>Danh sách khóa học đã đăng ký</h2>

<table>
    <thead>
        <tr>
            <th>Tên Khóa Học</th>
            <th>Mô tả</th>
            <th>Giảng viên</th>
            <th>Ngày đăng ký</th>
            <th>Tiến độ</th>
            <th>Trạng thái</th>
            <th>Chi tiết</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($enrollments )): ?>
            <?php foreach ($enrollments as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['title']) ?></td>

                <td><?= htmlspecialchars(mb_substr($item['description'], 0, 60)) ?>...</td>

                <td><?= htmlspecialchars($item['instructor_name']) ?></td>

                <td><?= htmlspecialchars($item['enrolled_date']) ?></td>

                <td><?= htmlspecialchars($item['progress']) ?>%</td>

                <td>
                    <?php if ($item['status'] === 'active'): ?>
                        <span style="color: green; font-weight: bold;">Đang học</span>
                    <?php elseif ($item['status'] === 'completed'): ?>
                        <span style="color: blue; font-weight: bold;">Hoàn thành</span>
                    <?php else: ?>
                        <span style="color: gray;">Đã hủy</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="<?php echo BASE_URL; ?>lessons/student?course_id=<?= $item['course_id'] ?>">Xem</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;">Không có khóa học nào</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<p style="margin-top:15px;">
    <a href="<?php echo BASE_URL; ?>welcome">Trở Về Trang Chủ</a>
</p>

</body>
</html>
