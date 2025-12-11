<?php
$page_title = "Tìm kiếm khóa học";
$css_files = ['courses_index.css'];  // We reuse the same beautiful CSS
include './views/layouts/header.php';
?>

<div class="container mt-4">

    <h2 class="mb-4 text-primary fw-bold">
        Danh sách khóa học
    </h2>

    <!-- Search Form -->
    <form method="get" action="<?= BASE_URL ?>courses" class="search-form mb-5">
        <input type="hidden" name="action" value="search">
        
        <div class="row g-3 align-items-center">
            <div class="col-lg-5">
                <input type="text" name="keyword" class="form-control search-box" 
                       placeholder="Nhập từ khóa tìm kiếm..." 
                       value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
            </div>

            <div class="col-lg-4">
                <select name="category" class="form-select search-box" onchange="this.form.submit()">
                    <option value="">-- Tất cả danh mục --</option>
                    <?php
                    // Build unique categories from $coursesAll
                    $categories = [];
                    foreach ($coursesAll as $c) {
                        if (!isset($categories[$c['category_id']])) {
                            $categories[$c['category_id']] = $c['category_name'];
                        }
                    }
                    foreach ($categories as $id => $name): ?>
                        <option value="<?= $id ?>" 
                            <?= (isset($_GET['category']) && $_GET['category'] == $id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-lg-3">
                <button type="submit" class="btn btn-primary btn-search w-100">
                    Tìm kiếm
                </button>
            </div>
        </div>
    </form>

    <!-- Results Count -->
    <?php if (isset($_GET['keyword']) || isset($_GET['category'])): ?>
        <div class="alert alert-info">
            <strong>
                <?= count($coursesSearch) ?> kết quả
                <?= isset($_GET['keyword']) ? " cho từ khóa \"<strong>" . htmlspecialchars($_GET['keyword']) . "</strong>\"" : '' ?>
                <?= isset($_GET['category']) ? " trong danh mục \"<strong>" . ($categories[$_GET['category']] ?? 'N/A') . "</strong>\"" : '' ?>
            </strong>
        </div>
    <?php endif; ?>

    <!-- Course Results Table -->
    <div class="table-responsive">
        <table class="table table-hover course-table align-middle">
            <thead>
                <tr>
                    <th>Khóa học</th>
                    <th>Mô tả ngắn</th>
                    <th>Giảng viên</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Thời lượng</th>
                    <th>Trình độ</th>
                    <th>Hình ảnh</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($coursesSearch)): ?>
                    <?php foreach ($coursesSearch as $course): ?>
                        <tr>
                            <td>
                                <a href="<?= BASE_URL ?>courses?id=<?= $course['id'] ?>" 
                                   class="text-decoration-none fw-bold text-primary hover-text">
                                    <?= htmlspecialchars($course['title']) ?>
                                </a>
                            </td>
                            <td class="text-muted small">
                                <?= htmlspecialchars(strlen($course['description']) > 100 
                                    ? substr($course['description'], 0, 100) . '...' 
                                    : $course['description']) ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle me-2" style="width:32px;height:32px;"></div>
                                    <?= htmlspecialchars($course['instructor_name']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?= htmlspecialchars($course['category_name']) ?>
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                <?= $course['price'] == 0 || $course['price'] == '0' ? 'Miễn phí' : number_format($course['price']) . 'đ' ?>
                            </td>
                            <td><?= $course['duration_weeks'] ?> tuần</td>
                            <td>
                                <span class="badge bg-<?= 
                                    $course['level'] === 'Beginner' ? 'success' : 
                                    ($course['level'] === 'Intermediate' ? 'warning' : 'danger')
                                ?>">
                                    <?= $course['level'] === 'Beginner' ? 'Sơ cấp' : 
                                        ($course['level'] === 'Intermediate' ? 'Trung cấp' : 'Nâng cao') ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($course['image'])): ?>
                                    <img src="<?= htmlspecialchars($course['image']) ?>" 
                                         alt="<?= htmlspecialchars($course['title']) ?>" 
                                         class="course-img shadow-sm">
                                <?php else: ?>
                                    <div class="bg-light border course-img d-flex align-items-center justify-content-center text-muted small">
                                        No image
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted small">
                                <?= date('d/m/Y', strtotime($course['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-courses py-5">
                            <div class="text-center">
                                Không tìm thấy khóa học nào phù hợp với tiêu chí của bạn
                                <div class="mt-3">
                                    <a href="<?= BASE_URL ?>courses" class="btn btn-outline-primary">
                                        Xem tất cả khóa học
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>