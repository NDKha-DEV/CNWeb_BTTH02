<?php
// views/admin/categories/edit.php

// Nếu không có danh mục → chuyển hướng về danh sách
if (!isset($category) || empty($category)) {
    header('Location: ' . BASE_URL . 'admin/categories?error=not_found');
    exit;
}

$page_title = "Chỉnh sửa Danh mục: " . htmlspecialchars($category['name']);
$css_files = ['admin-categories-edit.css'];  // Đường dẫn tới CSS đẹp
include './views/layouts/header.php';
?>

<div class="edit-container">
    <h1>Chỉnh sửa Danh mục</h1>
    <p class="category-id">
        ID danh mục: <strong><?= htmlspecialchars($category['id']) ?></strong>
    </p>

    <!-- Flash messages (nếu bạn dùng session flash sau này) -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash-message flash-<?= $_SESSION['flash']['type'] ?? 'error' ?>">
            <?= htmlspecialchars($_SESSION['flash']['message'] ?? '') ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>admin/categories/update" novalidate>
        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

        <div class="form-group">
            <label for="name">Tên danh mục <span class="required">*</span></label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="<?= htmlspecialchars($category['name']) ?>" 
                required 
                autocomplete="off"
                placeholder="Ví dụ: Điện thoại, Laptop, Phụ kiện..."
            >
            <?php if (isset($errors['name'])): ?>
                <small class="error-text"><?= htmlspecialchars($errors['name']) ?></small>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-update">
                Cập nhật danh mục
            </button>
            <a href="<?= BASE_URL ?>admin/categories" class="btn-cancel">
                Hủy bỏ
            </a>
        </div>
    </form>

    <p class="back-link">
        ← Quay lại <a href="<?= BASE_URL ?>admin/dashboard">Dashboard</a>
    </p>
</div>

<?php include './views/layouts/footer.php'; ?>