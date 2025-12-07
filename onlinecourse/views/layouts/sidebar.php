<?php

$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : 'guest';
$name = $isLoggedIn ? $_SESSION['user']['name'] : '';
?>

<aside class="sidebar">

    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="/index.php" class="<?= $currentPage ?? '' === 'home' ? 'active' : '' ?>">
                    Trang chủ
                </a>
            </li>
            <li>
                <a href="/courses/index.php" class="<?= $currentPage ?? '' === 'courses' ? 'active' : '' ?>">
                    Tất cả khóa học
                </a>
            </li>

            <?php if (!$isLoggedIn): ?>
                <li>
                    <a href="/auth/login.php">
                        Đăng nhập
                    </a>
                </li>
                <li>
                    <a href="/auth/register.php">
                        Đăng ký
                    </a>
                </li>

            <?php else: ?>
                <li>
                    <a href="/auth/logout.php">
                        Đăng xuất
                    </a>
                </li>
                <hr>

                <?php if ($role === 'student'): ?>
                    <li><strong>Học viên</strong></li>
                    <li>
                        <a href="/student/dashboard.php" class="<?= $currentPage ?? '' === 'student_dashboard' ? 'active' : '' ?>">
                            Dashboard</a>
                    </li>
                    <li>
                        <a href="/student/my_courses.php">
                            Khóa học của tôi
                        </a>
                    </li>
                    <li>
                        <a href="/student/course_progress.php">
                            Tiến độ học tập
                        </a>
                    </li>

                <?php elseif ($role === 'instructor'): ?>
                    <li><strong> Giảng viên</strong></li>
                    <li>
                        <a href="/instructor/dashboard.php">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/instructor/my_courses.php">
                            Khóa học của tôi
                        </a>
                    </li>
                    <li>
                        <a href="/instructor/course/create.php">
                            Tạo khóa học mới
                        </a>
                    </li>
                    <li>
                        <a href="/instructor/students/list.php">
                            Học viên đăng ký
                        </a>
                    </li>

                <?php elseif ($role === 'admin'): ?>
                    <li><strong>️ Quản trị viên</strong></li>
                    <li>
                        <a href="/admin/dashboard.php">
                            Admin Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/admin/users/manage.php">
                            Quản lý người dùng
                        </a>
                    </li>
                    <li>
                        <a href="/admin/categories/list.php">
                            Quản lý danh mục
                        </a>
                    </li>
                    <li>
                        <a href="/admin/reports/statistics.php">
                            Thống kê hệ thống
                        </a>
                    </li>
                    <li>
                        <a href="/courses/index.php?pending=1">
                            Duyệt khóa học mới
                        </a>
                    </li>
                <?php endif; ?>

            <?php endif; ?>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <small>© 2025 Online Course</small>
    </div>
</aside>