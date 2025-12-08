<?php
// index.php
session_start();

// --- 1. CẤU HÌNH ĐƯỜNG DẪN GỐC (RẤT QUAN TRỌNG) ---
// Hãy thay '/onlinecourse/' bằng đúng tên thư mục dự án của bạn trong htdocs
// Nếu dự án nằm trong htdocs/Project/CNWeb_BTTH02/onlinecourse/ thì điền y hệt vậy vào.
define('BASE_URL', '/Project/CNWeb_BTTH02/onlinecourse/'); 

// Load file
require_once 'config/Database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/HomeController.php';

// --- 2. XỬ LÝ URL ---
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Xóa BASE_URL để lấy phần đuôi. VD: /course/edit/5
$path = str_replace(BASE_URL, '', $request_uri);
$segments = explode('/', trim($path, '/'));

// Gán biến: segments[0] = Controller, segments[1] = Action, segments[2] = ID
$controllerName = isset($segments[0]) && $segments[0] != '' ? $segments[0] : 'home';
$actionName     = isset($segments[1]) && $segments[1] != '' ? $segments[1] : 'index';
$id             = isset($segments[2]) ? $segments[2] : null;

// --- 3. ĐIỀU HƯỚNG ---
switch ($controllerName) {
    case 'home':
        $home = new HomeController();
        $home->index();
        break;

    case 'auth':
        $auth = new AuthController();
        if ($actionName == 'login') {
            ($_SERVER['REQUEST_METHOD'] === 'POST') ? $auth->processLogin() : $auth->login();
        } elseif ($actionName == 'register') {
            ($_SERVER['REQUEST_METHOD'] === 'POST') ? $auth->processRegister() : $auth->register();
        } elseif ($actionName == 'welcome') {
            $auth->welcome();
        } elseif ($actionName == 'logout') {
            $auth->logout();
        }
        break;

    case 'course':
        $course = new CourseController();
        switch ($actionName) {
            case 'index': $course->index(); break;
            case 'create': $course->create(); break;
            case 'store': $course->store(); break;
            case 'edit': $course->edit($id); break;
            case 'update': $course->update($id); break;
            case 'delete': $course->delete($id); break;
            case 'detail': $course->detail($id); break;
            default: $course->index(); break;
        }
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Không tìm thấy trang</h1>";
        echo "<p>Bạn đang tìm: $controllerName / $actionName</p>";
        echo "<a href='".BASE_URL."home'>Quay về trang chủ</a>";
        break;
}
?>

