<?php
// onlinecourse/controllers/AuthController.php

// Định nghĩa BASE_URL để chuyển hướng an toàn trên XAMPP
define('BASE_URL', '/onlinecourse/');

require_once 'config/Database.php';
require_once 'models/User.php';
class AuthController{
    private $userModel;

    public function __construct() {
        // Khởi tạo session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new User($db);
    }

    // Phương thức hiển thị Form Đăng nhập
    public function login() {
        // Nếu người dùng đã đăng nhập, chuyển hướng ngay lập tức
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'welcome');
            exit;
        }
        // Gọi View bằng đường dẫn tương đối (từ vị trí của index.php)
        require 'views/auth/login.php'; 
    }

    /**
     * Phương thức xử lý logic đăng nhập (nhận POST request)
     */
    public function processLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Lấy và gán email cho Model
            $this->userModel->email = $_POST['email'];
            $user = $this->userModel->findByEmail(); // Gọi Model

            // 2. Xác minh người dùng và mật khẩu
            if ($user && password_verify($_POST['password'], $user['password'])) {
                
                // Đăng nhập thành công:
                
                // 3. Tạo Session (Quan trọng cho bảo mật và duy trì trạng thái)
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = (int)$user['role']; // 0: Student, 1: Instructor, 2: Admin
                $_SESSION['username'] = $user['username'];
                
                // 4. Chuyển hướng thành công (đến trang chào mừng)
                header('Location: ' . BASE_URL . 'welcome');
                exit;
            } else {
                
                // Đăng nhập thất bại:
                $error = "Email hoặc mật khẩu không chính xác.";
                
                // 5. Tải lại View đăng nhập với thông báo lỗi
                require 'views/auth/login.php';
            }
        }
    }

    public function register() {
        // Gọi View bằng đường dẫn tương đối (từ vị trí của index.php)
        require 'views/auth/register.php';
    }

    // Phương thức xử lý logic đăng ký (POST request)
    public function processRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Lấy dữ liệu từ form
            $this->userModel->username = $_POST['username'] ?? '';
            $this->userModel->email = $_POST['email'] ?? '';
            $this->userModel->password = $_POST['password'] ?? '';
            $this->userModel->fullname = $_POST['fullname'] ?? '';
            
            // 2. Gọi Model để tạo người dùng mới
            if ($this->userModel->create()) {
                
                // Đăng ký thành công, chuyển hướng đến trang đăng nhập
                header('Location: ' . BASE_URL . 'login?success=registered');
                exit;
            } else {
                
                // Đăng ký thất bại (ví dụ: trùng email/username)
                $error = "Đăng ký không thành công. Tên người dùng hoặc Email đã tồn tại.";
                
                // Tải lại View đăng ký với thông báo lỗi
                require 'views/auth/register.php';
            }
        }
    }
    public function welcome() {
        // 1. Kiểm tra quyền truy cập: Nếu chưa đăng nhập, chuyển hướng về trang login
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        // 2. Nếu đã đăng nhập, tải trang chào mừng
        // Sử dụng đường dẫn tương đối từ thư mục gốc (nơi index.php chạy)
        require 'views/auth/welcome.php';
    }
    public function logout() {
        // Hủy toàn bộ session
        session_destroy();
        
        // Chuyển hướng về trang chủ
        // Sử dụng BASE_URL để chuyển hướng an toàn: http://localhost/onlinecourse/
        header('Location: ' . BASE_URL);
        exit;
    }
    // ... (Các phương thức khác như welcome() và logout() đã được hướng dẫn trước) ...
    //Kiểm tra đã đăng nhập hay chưa;
    public static function isLoggedIn(){
        return isset($_SESSION['user_id']);
    }

    //Kiểm tra có phải giảng viên (1) hoặc Amin (2) không
    public static function isInstructorOrAdmin(){
        if(!self::isLoggedIn()) return false;
        $role = $_SESSION['role'];
        return ($role == 1 || $role == 2);
    }

    //Lấy ID người dung hiện tại 
    public static function getCurrentUserId(){
        return $_SESSION['user_id'] ?? null;
    }

    //Lấy Role người dung hiện tại
    public static function getCurrentUserRole(){
        return $_SESSION['role'] ?? null;
    }
}
?>




