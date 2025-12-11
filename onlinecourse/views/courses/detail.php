<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết khóa học</title>
</head>
<body>
    <h2><?= htmlspecialchars($courseModel['title']) ?></h2>

    <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($courseModel['description'])) ?></p>
    <p><strong>Giảng viên:</strong> <?= htmlspecialchars($courseModel['instructor_name']) ?></p>
    <p><strong>Danh mục:</strong> <?= htmlspecialchars($courseModel['category_name']) ?></p>
    <p><strong>Giá:</strong> <?= htmlspecialchars($courseModel['price']) ?></p>
    <p><strong>Thời lượng (tuần):</strong> <?= htmlspecialchars($courseModel['duration_weeks']) ?></p>
    <p><strong>Level:</strong> <?= htmlspecialchars($courseModel['level']) ?></p>
    <p><strong>Ngày tạo:</strong> <?= htmlspecialchars($courseModel['created_at']) ?></p>

    <?php if (!empty($course['image'])): ?>
        <img src="<?= htmlspecialchars($courseModel['image']) ?>" alt="Hình khóa học" width="200">
    <?php endif; ?>

    <hr>

    <!-- ===== FORM ĐĂNG KÝ KHÓA HỌC ===== -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="<?= BASE_URL ?>enrollment/register" method="POST">
            <input type="hidden" name="course_id" value="<?= $courseModel['id'] ?>">

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