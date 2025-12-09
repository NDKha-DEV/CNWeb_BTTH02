<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý bài học</title>
</head>
<body>

    <h2>Danh sách bài học của khóa học <?php echo htmlspecialchars($courseTitle); ?></h2>

    <a href="<?php echo BASE_URL; ?>course/manage">⬅️ Quay lại danh sách khóa học</a>

    <a href="<?php echo BASE_URL; ?>lesson/create?course_id=<?php echo $course_id; ?>" 
       style="background: green; color: white; padding: 5px;">
       + Thêm bài học mới
    </a>

    <hr>

    <table>
        <thead>
            <tr>
                <th>Thứ tự</th>
                <th>Tên bài học</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if($lessons->rowCount() > 0): ?>
                <?php while ($row = $lessons->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['lesson_order']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>lesson/edit?id=<?php echo $row['id']; ?>">Sửa</a>
                        <a href="<?php echo BASE_URL; ?>lesson/delete?id=<?php echo $row['id']; ?>">Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">Chưa có bài học nào. Hãy thêm bài đầu tiên!</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>