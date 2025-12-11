<?php
$page_title = "Danh sách khóa học";
$css_files = ['courses-list.css'];  // This loads our beautiful CSS
include './views/layouts/header.php';
?>

<div class="container mt-4">

    <h2 class="mb-4 text-primary fw-bold">
        <i class="bi bi-journal-text"></i> Danh sách khóa học
    </h2>

    <!-- Search Form -->
    <form method="get" action="<?= BASE_URL ?>courses" class="search-form">
        <input type="hidden" name="action" value="search">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <input type="text" name="keyword" class="form-control search-box" 
                       placeholder="Tìm theo tiêu đề..." 
                       value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select search-box" onchange="this.form.submit()">
                    <option value="">-- Tất cả danh mục --</option>
                    <?php
                    $categories = [];
                    foreach($courses as $c){
                        if (!isset($categories[$c['category_id']])) {
                            $categories[$c['category_id']] = $c['category_name'];
                        }
                    }
                    foreach($categories as $id => $name): ?>
                        <option value="<?= $id ?>" <?= (isset($_GET['category']) && $_GET['category']==$id)?'selected':'' ?>>
                            <?= htmlspecialchars($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-search w-100">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </form>

    <!-- Course Table -->
    <div class="table-responsive">
        <table class="table table-hover course-table">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Mô tả</th>
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
                <?php if (!empty($courses)): ?>
                    <?php foreach($courses as $course): ?>
                        <tr>
                            <td>
                                <a href="<?= BASE_URL ?>courses?id=<?= $course['id'] ?>" 
                                   class="text-decoration-none fw-bold text-primary">
                                    <?= htmlspecialchars($course['title']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars(strlen($course['description']) > 80 
                                ? substr($course['description'], 0, 80).'...' 
                                : $course['description']) ?>
                            </td>
                            <td><?= htmlspecialchars($course['instructor_name']) ?></td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <?= htmlspecialchars($course['category_name']) ?>
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                <?= $course['price'] == 0 ? 'Miễn phí' : number_format($course['price']).'đ' ?>
                            </td>
                            <td><?= $course['duration_weeks'] ?> tuần</td>
                            <td>
                                <span class="badge bg-<?= 
                                    $course['level']=='Beginner' ? 'success' : 
                                    ($course['level']=='Intermediate' ? 'warning' : 'danger') 
                                ?>">
                                    <?= $course['level'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if(!empty($course['image'])): ?>
                                    <img src="<?= htmlspecialchars($course['image']) ?>" 
                                         alt="<?= htmlspecialchars($course['title']) ?>" 
                                         class="course-img">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted small">
                                <?= date('d/m/Y', strtotime($course['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-courses">
                            <i class="bi bi-emoji-frown display-1 text-muted d-block mb-3"></i>
                            Không tìm thấy khóa học nào phù hợp
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>