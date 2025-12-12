<?php
// onlinecourse/index.php
// FRONT CONTROLLER

// ------------------------------------
// 1. THIẾT LẬP MÔI TRƯỜNG & BIẾN TOÀN CỤC
// ------------------------------------

// Khởi tạo Session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// session_destroy(); // Xóa session hiện tại
// session_start();

// Định nghĩa thư mục gốc của ứng dụng trên URL (quan trọng cho chuyển hướng)
// Thay thế '/onlinecourse/' nếu thư mục ứng dụng của bạn khác.
define('BASE_URL', '/btth2/onlinecourse/'); 


// ------------------------------------
// 2. XỬ LÝ ROUTING (ĐỊNH TUYẾN)
// ------------------------------------

// Lấy đường dẫn yêu cầu (URI) từ server
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Loại bỏ thư mục gốc (BASE_URL) khỏi URI để có đường dẫn sạch
$base_path = BASE_URL; 
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

// Đảm bảo đường dẫn trống là '/'
if (empty($request_uri)) {
    $request_uri = '/';
}

// ------------------------------------
// 3. YÊU CẦU CONTROLLER
// ------------------------------------

// Yêu cầu file AuthController cho Nhóm 1
require_once 'controllers/AuthController.php';
// require_once 'controllers/CourseController.php';
require_once 'controllers/AdminController.php';
// Yêu cầu Model cho Log
require_once 'config/Database.php'; // Cần Database để khởi tạo Model
require_once 'models/ViewLog.php';
// Khởi tạo Database (Nếu chưa có)
$database = new Database();
$db = $database->getConnection();

// Khởi tạo Controller
$authController = new AuthController();
// $courseController = new CourseController();
$adminController = new AdminController();
// Khởi tạo Model Log Mới
$viewLog = new ViewLog($db);

require_once 'controllers/CourseController.php';
$course = new CourseController();

require_once 'controllers/EnrollmentController.php';
$enroll = new EnrollmentController();

require_once 'controllers/LessonControler.php';
$lessonController = new LessonController();

require_once 'controllers/HomeController.php';
$homeController = new HomeController();

// ------------------------------------
// 4. CHUYỂN PHÁT YÊU CẦU (DISPATCH)
// ------------------------------------

// Lấy User ID hiện tại hoặc NULL nếu là khách
$current_user_id = $_SESSION['user_id'] ?? NULL;

// Ghi Log lượt xem trước khi thực thi Controller
// Chỉ ghi log nếu không phải là yêu cầu tài nguyên tĩnh (css, js, images)
if (!preg_match('/\.(css|js|png|jpg|jpeg|gif|ico)$/i', $request_uri)) {
    // Dùng $request_uri để lưu đường dẫn đã làm sạch
    // Chỉ log nếu database connection thành công
    if ($db !== null) {
        $viewLog->logView($current_user_id, $request_uri);
    }
}

switch ($request_uri) {
    case '/':
    case 'home':
        // Trang chủ
        $homeController->index();
        break;
        
    // --- ĐĂNG KÝ ---
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->processRegister();
        } else {
            $authController->register(); // Hiển thị form
        }
        break;
        
    // --- ĐĂNG NHẬP ---
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->processLogin();
        } else {
            $authController->login(); // Hiển thị form
        }
        break;

    // --- TRANG CHÀO MỪNG ---
    case 'welcome':
        $authController->welcome(); 
        break;
        
    // --- ĐĂNG XUẤT ---
    case 'logout':
        $authController->logout();
        break;
    // --- ADMIN DASHBOARD ---
    case 'admin':
    case 'admin/dashboard':
        $adminController->dashboard();
        break;

    // --- ADMIN: QUẢN LÝ NGƯỜI DÙNG ---
    case 'admin/users':
        $adminController->manageUsers();
        break;
    case 'admin/users/toggle-status':
        $adminController->toggleUserStatus();
        break;
    // Trong index.php (phần GET)
    case 'admin/users/create-instructor':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý POST (Khi người dùng bấm Submit)
            $adminController->handleCreateInstructor();
        } else {
            // Xử lý GET (Hiển thị form)
            $adminController->createInstructor();
        }
        break;
    // --- ADMIN: THỐNG KÊ LƯỢT XEM ---
    case 'admin/statistics/views':
        $adminController->viewStatistics();
        break;

    // --- ADMIN: QUẢN LÝ DANH MỤC ---
    case 'admin/categories':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminController->createCategory(); // Xử lý tạo mới
        } else {
            $adminController->manageCategories(); // Hiển thị danh sách
        }
        break;

    case 'admin/categories/update':
        $adminController->updateCategory();
        break;

    case 'admin/categories/edit':
        $adminController->editCategory();
        break;
    // case 'admin/categories/delete':
    //     $adminController->deleteCategory();
    //     break;

    // --- ADMIN: DUYỆT KHÓA HỌC ---
    case 'admin/courses/pending':
        $adminController->pendingCourses();
        break;

    case 'admin/courses/approve':
         // Tác vụ này cần thêm ID khóa học (ví dụ: /admin/courses/approve?id=123)
         // Tạm thời xử lý qua POST hoặc GET đơn giản
         $adminController->approveCourse(); 
         break;
         
    case 'admin/courses/review':
            // Phương thức AdminController::approveCourse() xử lý cả Phê duyệt và Từ chối
            $adminController->approveCourse(); 
            break;
    // --- Hiển thị Courses cho học sinh --- //
    case 'courses':

        if (isset($_GET['action']) && $_GET['action'] === 'search') {
            // /onlinecourse/courses?action=search
            $course->search();

        } elseif (isset($_GET['id'])) {
            // /onlinecourse/courses?id=10
            $course->show($_GET['id']);

        } else {
            // /onlinecourse/courses
            $course->index();
        }
        break;
    case 'instructor/dashboard':
        $course->dashboardOfInstructor();
        break;
    case 'course/manage':
        $course->manageCoursesInstructor();
        break;

    // 2. Tạo khóa học mới
    case 'course/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nếu submit form (POST) -> Lưu data
            $course->store();
        } else {
            // Nếu truy cập bình thường (GET) -> Hiển thị form
            $course->create();
        }
        break;

    // 3. Sửa khóa học
    case 'course/edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Submit form sửa -> Cập nhật
                $course->update($id);
            } else {
                // Hiển thị form sửa
                $course->edit($id);
            }
        } else {
            echo "Lỗi: Không tìm thấy ID khóa học để sửa.";
        }
        break;

    // 4. Xóa khóa học
    case 'course/delete':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $course->delete($id);
        } else {
            echo "Lỗi: Không tìm thấy ID khóa học để xóa.";
        }
        break;
    
    case 'course/submit-review':
        $course->submitForReview(); // Phương thức mới sẽ được tạo
        break;
    // --- QUẢN LÝ BÀI HỌC (LESSON) ---

    case 'lesson':
        $lessonController->index();
        break;

    // --- Thực hiện hiển thị bài học ---
    case 'lesson/student':
        $lessonController->show();
        break;

    // --- Hiển thị các khóa học đã đăng ký ---
    case 'enrollment':
        $enroll->myCourses();
        break;
    // --- Thực hiện đăng ký khóa học---
    case 'enrollment/register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $enroll->register();
        }
        break;

    
    // --- QUẢN LÝ BÀI HỌC (LESSON) ---

    case 'lesson/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonController->store();
        } else {
            $lessonController->create();
        }
        break;

    case 'lesson/edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonController->update();
        } else {
            $lessonController->edit();
        }
        break;

    case 'lesson/delete':
        $lessonController->delete();
        break;
    
    case 'lesson/uploadForm':
        $lessonController->uploadForm();
        break;
    
    case 'lesson/upload':
        $lessonController->upload();
        break;
    
        case 'course/students': 
        $course->listStudents();
        break;
    // --- 404 NOT FOUND ---
    default:
        http_response_code(404);
        echo "<h1>404 - Không tìm thấy trang</h1><p>Đường dẫn yêu cầu: " . htmlspecialchars($request_uri) . "</p>";
        break;
}

