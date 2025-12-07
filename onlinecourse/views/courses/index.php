

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách khóa học</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

<h2>Danh sách khóa học</h2>

<!-- Form tìm kiếm -->
<form method="get" action="">
    <input type="text" name="keyword" placeholder="Tìm theo tiêu đề..." 
           value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
    <input type="number" name="category" placeholder="Lọc theo danh mục" 
           value="<?= isset($_GET['category']) ? (int)$_GET['category'] : '' ?>">
    <button type="submit">Tìm kiếm</button>
</form>

<br>

<!-- Bảng khóa học -->
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Instructor</th>
            <th>Category</th>
            <th>Price</th>
            <th>Duration (weeks)</th>
            <th>Level</th>
            <th>Image</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($courses)): ?>
            <?php foreach($courses as $course): ?>
                <tr>
                    <td><?= htmlspecialchars($course['title']) ?></td>
                    <td><?= htmlspecialchars($course['description']) ?></td>
                    <td><?= htmlspecialchars($course['instructor_name']) ?></td>
                    <td><?= htmlspecialchars($course['category_name']) ?></td>
                    <td><?= htmlspecialchars($course['price']) ?></td>
                    <td><?= htmlspecialchars($course['duration_weeks']) ?></td>
                    <td><?= htmlspecialchars($course['level']) ?></td>
                    <td>
                        <?php if(!empty($course['image'])): ?>
                            <img src="<?= htmlspecialchars($course['image']) ?>" alt="image" width="80">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($course['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;">Không có khóa học nào</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>