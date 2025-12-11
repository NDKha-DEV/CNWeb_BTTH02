<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách khóa học</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2>Danh sách khóa học</h2>

<!-- Form tìm kiếm -->
<form method="get" action="<?php echo BASE_URL; ?>courses">
    <input type="hidden" name="action" value="search">
    <input type="text" name="keyword" placeholder="Tìm theo tiêu đề..." 
           value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">

    <!-- Combobox category từ dữ liệu search -->
    <?php
    $categories = [];
    foreach($coursesAll as $c){
        $categories[$c['category_id']] = $c['category_name'];
    }
    ?>
    <select name="category" onchange="this.form.submit()">
        <option value="">-- Chọn danh mục --</option>
        <?php foreach($categories as $id => $name): ?>
            <option value="<?= $id ?>" <?= (isset($_GET['category']) && $_GET['category']==$id)?'selected':'' ?>>
                <?= htmlspecialchars($name) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Tìm kiếm</button>
</form>

<br>

<!-- Bảng kết quả khóa học -->
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
        <?php if (!empty($coursesSearch)): ?>
            <?php foreach($coursesSearch as $course): ?>
                <tr>
                    <td>
                        <a href="<?php echo BASE_URL; ?>courses?id=<?= $course['id'] ?>">
                            <?= htmlspecialchars($course['title']) ?>
                        </a>
                    </td>
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
<p><a href="<?php echo BASE_URL; ?>welcome">Trở về trang chủ</a></p>
</body>
</html>