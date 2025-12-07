<?php
session_start();
require_once 'models/Course.php';
require_once 'models/Category.php';
require_once 'config/Database.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/HomeController.php';
// ... require các controller khác

// Giả lập đăng nhập
if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 1;
    $_SESSION['fullname'] = "Nguyễn Minh Đức";
    $_SESSION['email'] = "techer@gmail.com";
}
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action']) ? $_GET['action'] : 'index';
$id         = isset($_GET['id']) ? $_GET['id'] : null;

switch ($controller) {
    case 'home':
        $home = new HomeController();
        switch ($action) {
            case 'index': 
                $home->index();
                break;
        }
        break;
    case 'course':
        $courseController = new CourseController();
        switch ($action) {
            case 'index':
                $courseController->index();
                break; 
            case 'create':
                $courseController->create(); // Gọi hàm hiển thị form
                break;
            case 'store':
                $courseController->store(); // Gọi hàm xử lý lưu
                break;
            case 'edit':
                $courseController->edit($id);
                break;
            case 'update':
                $courseController->update($id);
                break;
            default:
                // Mặc định gọi danh sách
                // $courseController->index(); 
                break;
        }
        break;
    // ... các case khác
}
?>