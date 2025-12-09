<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết khóa học</title>
</head>
<body>
    <h2><?= htmlspecialchars($course['title']) ?></h2>

    <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($course['description'])) ?></p>
    <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course['instructor_name']) ?></p>
    <p><strong>Danh mục:</strong> <?= htmlspecialchars($course['category_name']) ?></p>
    <p><strong>Giá:</strong> <?= htmlspecialchars($course['price']) ?></p>
    <p><strong>Thời lượng (tuần):</strong> <?= htmlspecialchars($course['duration_weeks']) ?></p>
    <p><strong>Level:</strong> <?= htmlspecialchars($course['level']) ?></p>
    <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($course['created_at']) ?></p>

    <?php if (!empty($course['image'])): ?>
        <img src="<?= htmlspecialchars($course['image']) ?>" alt="Hình khóa học" width="200">
    <?php endif; ?>

    <hr>

    <!-- ===== FORM ĐĂNG KÝ KHÓA HỌC ===== -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="<?= BASE_URL ?>enrollment/register" method="POST">
            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">

            <button type="submit" 
                    style="
                        padding: 10px 20px; 
                        background: green; 
                        color: white; 
                        border: none; 
                        border-radius: 6px;
                        cursor: pointer;
                    ">
                Đăng ký khóa học
            </button>
        </form>
    <?php else: ?>
        <p style="color:red;"><strong>Bạn cần đăng nhập để đăng ký khóa học.</strong></p>
        <a href="<?= BASE_URL ?>login">Đăng nhập ngay</a>
    <?php endif; ?>

    <hr>

    <p><a href="<?= BASE_URL ?>courses">Quay lại danh sách khóa học</a></p>
</body>
</html>