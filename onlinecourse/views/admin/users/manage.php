<?php 
// views/admin/users/index.php

// Kiểm tra quyền admin (role = 2)
if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_role'] !== 2) {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

$page_title = "Quản lý Người dùng";
$css_files = ['admin-users.css'];
include './views/layouts/header.php';
?>

<div class="users-container">
    <div class="page-header">
        <div>
            <h1><?= $page_title ?></h1>
            <p class="subtitle">Quản lý tài khoản Admin, Giảng viên và Học viên</p>
        </div>
        <div class="header-actions">
            <a href="<?= BASE_URL ?>admin/users/create-instructor" class="btn-create">
                Tạo tài khoản Giảng viên
            </a>
            <a href="<?= BASE_URL ?>admin/dashboard" class="btn-back">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'status_updated'): ?>
        <div class="alert alert-success">Cập nhật trạng thái người dùng thành công!</div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'status_failed'): ?>
        <div class="alert alert-error">Cập nhật trạng thái thất bại. Vui lòng thử lại!</div>
    <?php endif; ?>

    <!-- Bảng người dùng -->
    <div class="table-card">
        <div class="table-header">
            <h2>Danh sách người dùng (<?= count($users ?? []) ?>)</h2>
        </div>

        <?php if (!empty($users)): ?>
            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th width="6%">#</th>
                            <th width="18%">Tên đăng nhập</th>
                            <th width="22%">Email</th>
                            <th width="12%">Vai trò</th>
                            <th width="12%">Trạng thái</th>
                            <th width="15%">Ngày tạo</th>
                            <th width="15%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): 
                            $status = (int)$user['status'];
                            $role = (int)$user['role'];
                        ?>
                            <tr>
                                <td><strong>#<?= $index + 1 ?></strong></td>
                                <td class="username">
                                    <div class="user-info">
                                        <strong><?= htmlspecialchars($user['username']) ?></strong>
                                        <?php if ($role == 2): ?>
                                            <span class="badge badge-admin">Admin</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php if ($role == 2): ?>
                                        <span class="badge badge-admin">Admin</span>
                                    <?php elseif ($role == 1): ?>
                                        <span class="badge badge-instructor">Giảng viên</span>
                                    <?php else: ?>
                                        <span class="badge badge-student">Học viên</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($status === 1): ?>
                                        <span class="status status-active">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="status status-inactive">Vô hiệu hóa</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                                </td>
                                <td class="actions">
                                    <form method="POST" action="<?= BASE_URL ?>admin/users/toggle-status" class="toggle-form">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $status === 1 ? 0 : 1 ?>">

                                        <?php if ($status === 1): ?>
                                            <button type="submit" class="btn-status btn-deactivate"
                                                    onclick="return confirm('Bạn có chắc chắn muốn VÔ HIỆU HÓA tài khoản này?\n\nNgười dùng sẽ không thể đăng nhập.');">
                                                Vô hiệu hóa
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn-status btn-activate"
                                                    onclick="return confirm('Bạn có chắc chắn muốn KÍCH HOẠT lại tài khoản này?');">
                                                Kích hoạt
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Placeholder phân trang (khi có nhiều user) -->
            <!-- <div class="pagination">...</div> -->

        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">No Users</div>
                <h3>Chưa có người dùng nào</h3>
                <p>Hãy tạo tài khoản giảng viên đầu tiên!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include './views/layouts/footer.php'; ?>