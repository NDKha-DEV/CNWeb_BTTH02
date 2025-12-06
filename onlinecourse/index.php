<?php
session_start();
require_once 'controllers/CourseController.php';
// ... require các controller khác

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action']) ? $_GET['action'] : 'index';
$id         = isset($_GET['id']) ? $_GET['id'] : null;

switch ($controller) {
    case 'course':
        $courseController = new CourseController();
        switch ($action) {
            case 'create':
                $courseController->create(); // Gọi hàm hiển thị form
                break;
            case 'store':
                $courseController->store(); // Gọi hàm xử lý lưu
                break;
            case 'edit':
                $courseController->edit($id); // Gọi hàm sửa
                break;
            case 'update':
                $courseController->update($id); // Gọi hàm cập nhật
                break;
            case 'delete':
                $courseController->delete($id); // Gọi hàm xóa
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