<?php
$page_title = htmlspecialchars($course['title']);
$css_files = ['course-detail.css'];  // We'll create this CSS below
include './views/layouts/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Left: Course Info -->
        <div class="col-lg-8">
            <div class="bg-white rounded-4 shadow-lg p-5 mb-4">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <?= htmlspecialchars($course['title']) ?>
                </h1>

                <?php if (!empty($course['image'])): ?>
                    <div class="text-center mb-4">
                        <img src="<?= htmlspecialchars($course['image']) ?>" 
                             alt="<?= htmlspecialchars($course['title']) ?>"
                             class="img-fluid rounded-3 shadow course-detail-img">
                    </div>
                <?php endif; ?>

                <div class="course-meta mb-4">
                    <div class="d-flex flex-wrap gap-3 text-muted small">
                        <span><strong>Giảng viên:</strong> <?= htmlspecialchars($course['instructor_name']) ?></span>
                        <span><strong>Danh mục:</strong> 
                            <span class="badge bg-info text-dark"><?= htmlspecialchars($course['category_name']) ?></span>
                        </span>
                        <span><strong>Thời lượng:</strong> <?= $course['duration_weeks'] ?> tuần</span>
                        <span><strong>Trình độ:</strong> 
                            <span class="badge bg-<?= 
                                $course['level']==='Beginner' ? 'success' : 
                                ($course['level']==='Intermediate' ? 'warning' : 'danger')
                            ?>">
                                <?= $course['level']==='Beginner' ? 'Sơ cấp' : ($course['level']==='Intermediate' ? 'Trung cấp' : 'Nâng cao') ?>
                            </span>
                        </span>
                        <span><strong>Ngày tạo:</strong> <?= date('d/m/Y', strtotime($course['created_at'])) ?></span>
                    </div>
                </div>

                <hr class="my-4">

                <h4 class="fw-bold text-dark mb-3">Mô tả khóa học</h4>
                <div class="lead text-dark">
                    <?= nl2br(htmlspecialchars($course['description'])) ?>
                </div>
            </div>
        </div>

        <!-- Right: Sidebar - Price + Enroll -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-success fs-1">
                            <?= $course['price'] == 0 ? 'MIỄN PHÍ' : number_format($course['price']) . 'đ' ?>
                        </h2>
                        <?php if ($course['price'] > 0): ?>
                            <del class="text-muted small"><?= number_format($course['price'] * 1.5) ?>đ</del>
                            <span class="badge bg-danger ms-2">Giảm 33%</span>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 0): ?>
                        <!-- Student logged in -->
                        <form action="<?= BASE_URL ?>enrollment/register" method="POST" class="d-grid">
                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                                ĐĂNG KÝ NGAY
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Truy cập trọn đời • Không giới hạn
                            </small>
                        </div>
                    <?php elseif (isset($_SESSION['user_id'])): ?>
                        <!-- Logged in but not student (admin/instructor) -->
                        <div class="alert alert-info text-center">
                            <strong>Bạn là <?= $_SESSION['user_role'] === 2 ? 'Quản trị viên' : 'Giảng viên' ?></strong><br>
                            Không thể đăng ký khóa học này.
                        </div>
                    <?php else: ?>
                        <!-- Guest -->
                        <div class="text-center">
                            <p class="lead text-danger fw-bold mb-3">
                                Bạn cần đăng nhập để đăng ký!
                            </p>
                            <a href="<?= BASE_URL ?>login" class="btn btn-outline-primary btn-lg w-100 mb-2">
                                Đăng nhập
                            </a>
                            <a href="<?= BASE_URL ?>register" class="btn btn-primary btn-lg w-100">
                                Đăng ký miễn phí
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="mt-4 text-center">
                        <a href="<?= BASE_URL ?>courses" class="text-muted small">
                            Quay lại danh sách khóa học
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>