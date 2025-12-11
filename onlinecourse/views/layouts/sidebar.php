<?php
// components/navbar.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user role (default = guest if not logged in)
$role = $_SESSION['user_role'] ?? -1;
$username = $_SESSION['username'] ?? null;
$is_logged_in = ($role !== -1);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">OnlineCourse</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                <?php if ($role === 2): ?>
                    <!-- ADMIN MENU -->
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/users">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/categories">Manage Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>admin/courses/pending">Pending Courses</a></li>

                <?php elseif ($role === 1): ?>
                    <!-- INSTRUCTOR MENU -->
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>instructor/dashboard">Manage Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>course/create">New Course</a></li>

                <?php elseif ($role === 0): ?>
                    <!-- STUDENT MENU -->
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>enrollment">My Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>courses">All Courses</a></li>

                <?php endif; ?>

            </ul>

            <!-- Right side: Login or User menu -->
            <ul class="navbar-nav ms-auto">
                <?php if (!$is_logged_in): ?>
                    <!-- GUEST -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light px-4" href="<?= BASE_URL ?>login">Login</a>
                    </li>
                <?php else: ?>
                    <!-- LOGGED IN USER -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($username) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>logout">Logout</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>