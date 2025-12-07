<?php
require_once "controllers/CourseController.php";

// Tạo controller
$controller = new CourseController();

// Kiểm tra action
if (isset($_GET['action']) && $_GET['action'] === 'search') {
    // Gọi hàm search riêng
    $controller->search();
} elseif (isset($_GET['id'])) {
    // Xem chi tiết khóa học
    $controller->show($_GET['id']);
} else {
    // Trang danh sách khóa học mặc định
    $controller->index();
}