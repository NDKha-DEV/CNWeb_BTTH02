<?php
// index.php - Home Page (visible to everyone)
$page_title = "Best Online Courses";
$css_files  = ['home.css']; // optional: create assets/css/home.css for custom styles

include './views/layouts/header.php';
?>

<!-- HERO SECTION -->
<section class="bg-primary text-white py-5">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold">Welcome to <span class="text-warning">OnlineCourse</span></h1>
        <p class="lead mb-4">Learn from the best instructors, anytime, anywhere.</p>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Guest sees big CTA buttons -->
            <div class="mt-4">
                <a href="<?= BASE_URL ?>login" class="btn btn-light btn-lg px-5 me-3">Login</a>
                <a href="<?= BASE_URL ?>register" class="btn btn-outline-light btn-lg px-5">Join for Free</a>
            </div>
        <?php else: ?>
            <!-- Logged-in users go straight to courses -->
            <div class="mt-4">
                <a href="<?= BASE_URL ?>courses" class="btn btn-warning btn-lg px-5">
                    Browse All Courses
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- FEATURES -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="bg-light p-4 rounded shadow-sm">
                    <i class="bi bi-book display-1 text-primary"></i>
                    <h3 class="mt-3">1000+ Courses</h3>
                    <p>From programming to design, business, photography, and more.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="bg-light p-4 rounded shadow-sm">
                    <i class="bi bi-award display-1 text-success"></i>
                    <h3 class="mt-3">Expert Instructors</h3>
                    <p>Learn from industry leaders and top professionals.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="bg-light p-4 rounded shadow-sm">
                    <i class="bi bi-infinity display-1 text-warning"></i>
                    <h3 class="mt-3">Lifetime Access</h3>
                    <p>Enroll once, learn forever. No monthly fees.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- POPULAR CATEGORIES -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Popular Categories</h2>
        <div class="row row-cols-2 row-cols-md-4 g-4">
            <?php
            $categories = ['Web Development', 'Python', 'JavaScript', 'Data Science', 'Graphic Design', 'Business', 'Photography', 'Marketing'];
            foreach ($categories as $cat):
            ?>
                <div class="col">
                        <div class="card h-100 text-center border-0 shadow-sm hover-shadow">
                            <div class="card-body">
                                <i class="bi bi-code-slash display-4 text-primary"></i>
                                <h5 class="mt-3"><?= htmlspecialchars($cat) ?></h5>
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CALL TO ACTION -->
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-5">
        <h2>Ready to Start Learning?</h2>
        <p class="lead">Join thousands of students already learning on LearnHub</p>
        <a href="<?= BASE_URL ?>courses" class="btn btn-warning btn-lg px-5 mt-3">
            <i class="bi bi-arrow-right"></i> Explore All Courses
        </a>
    </div>
</section>

<?php include './views/layouts/footer.php'; ?>