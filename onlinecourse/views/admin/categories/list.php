<?php
// views/admin/categories/list.php

if (!isset($categories)) {
    $categories = [];
}

$page_title = "Quản lý Danh mục Khóa học";
$css_files = ['admin-categories-list.css']; // CSS mới đẹp hơn
include './views/layouts/header.php';
?>

<div class="category-container">
    <div class="page-header">
        <h1><?= $page_title ?></h1>
        <a href="<?= BASE_URL ?>admin/dashboard" class="back-dashboard">
            Dashboard
        </a>
    </div>

    <!-- Flash Messages (thành công / lỗi) -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            $messages = [
                'created' => 'Tạo danh mục thành công!',
                'updated' => 'Cập nhật danh mục thành công!',
                'deleted' => 'Xóa danh mục thành công!'
            ];
            echo $messages[$_GET['success']] ?? 'Thao tác thành công!';
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?php
            $errors = [
                'delete_failed' => 'Xóa thất bại! Có khóa học đang sử dụng danh mục này.',
                'update_failed' => 'Cập nhật thất bại. Vui lòng thử lại.',
                'not_found'     => 'Danh mục không tồn tại.'
            ];
            echo $errors[$_GET['error']] ?? 'Đã xảy ra lỗi.';
            ?>
        </div>
    <?php endif; ?>

    <!-- Form tạo danh mục mới -->
    <div class="create-section">
        <h2>Thêm Danh mục Mới</h2>
        <form method="POST" action="<?= BASE_URL ?>admin/categories" class="create-form">
            <div class="input-group">
                <input 
                    type="text" 
                    name="name" 
                    placeholder="Nhập tên danh mục (ví dụ: Lập trình Web, Tiếng Anh)" 
                    required 
                    autocomplete="off"
                >
                <button type="submit" class="btn-create">
                    Thêm
                </button>
            </div>
        </form>
    </div>

    <hr class="divider">

    <!-- Bảng danh sách danh mục -->
    <div class="table-section">
        <div class="table-header">
            <h2>Danh sách Danh mục</h2>
            <span class="count-badge"><?= count($categories) ?> danh mục</span>
        </div>

        <?php if (!empty($categories)): ?>
            <div class="table-responsive">
                <table class="category-table">
                    <thead>
                        <tr>
                            <th width="10%">ID</th>
                            <th width="65%">Tên Danh mục</th>
                            <th width="25%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><strong>#<?= htmlspecialchars($category['id']) ?></strong></td>
                                <td><?= htmlspecialchars($category['name']) ?></td>
                                <td class="actions">
                                    <a href="<?= BASE_URL ?>admin/categories/edit?id=<?= $category['id'] ?>" 
                                       class="btn-edit" title="Chỉnh sửa">
                                        Sửa
                                    </a>

                                    <!-- Nút XÓA (bật lại khi cần) -->
                                    <!-- <form method="POST" 
                                          action="<?= BASE_URL ?>admin/categories/delete" 
                                          style="display:inline;" 
                                          onsubmit="return confirm('Bạn có CHẮC muốn xóa danh mục «<?= htmlspecialchars($category['name']) ?>»?\n\n⚠️ Nếu có khóa học đang dùng danh mục này, sẽ bị lỗi!');">
                                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                        <button type="submit" class="btn-delete" title="Xóa danh mục">
                                            Xóa
                                        </button>
                                    </form> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="empty-state">
                Chưa có danh mục nào. Hãy tạo danh mục đầu tiên!
            </p>
        <?php endif; ?>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>