<?php
// views/student/my_courses.php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: ../../index.php");
    exit("Bạn không có quyền truy cập");
}

$studentId = $_SESSION['user']['id'];
require_once "../../controllers/EnrollmentController.php";

$enrollController = new EnrollmentController();
$enrolledCourses = $enrollController->getCoursesByStudent($studentId); // trả về mã khóa + progress + status
//$enrolledCourses kieu : = 
//'CNPM' => ['id'=>3,'progress' => 0.34, 'status' => 'đang thực hiện', 'name' => 'Công nghệ phần mềm'],
//   'ML'   => ['id'=>5,'progress' => 1.00, 'status' => 'finished', 'name' => 'Machine Learning'],
?>
<?php include_once "../layouts/header.php"; ?>
<?php include_once "../layouts/sidebar.php"; ?>

<div class="main-content">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary">Khóa học của tôi</h1>
            <a href="my_courses.php" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-clockwise"></i> Làm mới
            </a>
        </div>

        <?php if (empty($enrolledCourses)): ?>
            <div class="text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted"></i>
                <h4 class="mt-4 text-muted">Bạn chưa đăng ký khóa học nào</h4>
                <p class="text-muted">
                    Hãy đến <a href="../courses/index.php" class="text-primary fw-bold">Danh sách khóa học</a> để đăng ký ngay!
                </p>
            </div>
        <?php else: ?>
            <p class="text-center text-muted mb-5">Nhấn vào khóa học để tiếp tục học</p>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                <?php foreach ($enrolledCourses as $code => $course): ?>
                    <?php 
                        $progress = ($course['progress'] ?? 0) * 100;
                        $status = strtolower($course['status'] ?? 'not_started');

                        $statusInfo = match($status) {
                            'completed' => ['label' => 'Hoàn thành', 'class' => 'bg-success'],
                            'active'=> ['label' => 'Đang học', 'class' => 'bg-info text-dark'],
                            'not_started', 'pending' => ['label' => 'Chưa bắt đầu', 'class' => 'bg-warning text-dark'],
                            default => ['label' => 'Chưa xác định', 'class' => 'bg-secondary']
                        };
                    ?>

                    <div class="col">
                        <!-- Dẫn đến trang học chi tiết (có tiến độ, bài học...) -->
                        <a href="../courses/detail.php?course_id=<?= $course['id'] ?>" class="text-decoration-none">
                            <div class="card h-100 course-card shadow-sm border-0 position-relative overflow-hidden">
                                <?php if ($progress >= 100): ?>
                                    <div class="position-absolute top-0 end-0 bg-success text-white px-3 py-1 small rounded-start shadow">
                                        Hoàn thành
                                    </div>
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title mb-0 fw-bold text-primary"><?= htmlspecialchars($code) ?></h5>
                                        <i class="bi bi-journal-text fs-3 text-muted opacity-50"></i>
                                    </div>

                                    <?php if (!empty($course['name'] ?? '')): ?>
                                        <p class="mb-2 text-dark fw-medium"><?= htmlspecialchars($course['name']) ?></p>
                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <span class="badge <?= $statusInfo['class'] ?> rounded-pill px-3 py-2">
                                            <?= $statusInfo['label'] ?>
                                        </span>
                                    </div>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between mb-2">
                                            <small class="text-muted">Tiến độ</small>
                                            <span class="fw-bold text-primary"><?= number_format($progress, 0) ?>%</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar <?= $progress >= 100 ? 'bg-success' : 'bg-primary' ?>"
                                                 style="width: <?= $progress ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .course-card {
        border-radius: 12px !important;
        transition: all 0.3s ease;
    }
    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
    }
    .main-content {
        margin-left: 280px;
        padding: 20px;
        min-height: 100vh;
        background-color: #f8f9fa;
    }
    @media (max-width: 992px) {
        .main-content { margin-left: 0; }
    }
</style>

<?php include_once "../layouts/footer.php"; ?>