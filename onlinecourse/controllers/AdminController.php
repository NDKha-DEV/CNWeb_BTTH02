<?php
// onlinecourse/controllers/AdminController.php

require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'models/Category.php';
require_once 'models/Course.php'; // Cần để duyệt khóa học

class AdminController {
    private $userModel;
    private $categoryModel;
    private $courseModel; // Thêm CourseModel để duyệt khóa học
    private $viewLog;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new User($db);
        $this->categoryModel = new Category($db);
        $this->courseModel = new Course($db); // Khởi tạo
        $this->viewLog = new ViewLog($db);
    }
    
    /**
     * Hàm kiểm tra quyền Admin
     */
    private function checkAdmin() {
        // Giả định role 2 là Admin
        if (!isset($_SESSION['user_id']) || (int)$_SESSION['user_role'] !== 2) {
            // Chuyển hướng hoặc báo lỗi 403 Forbidden
            header('Location: ' . BASE_URL . 'home'); 
            exit;
        }
    }

    // ===================================
    // 1. DASHBOARD & THỐNG KÊ
    // ===================================

    public function dashboard() {
        $this->checkAdmin();
        // Giả định: Có thể gọi các hàm thống kê từ Model nếu cần
        // Ví dụ: $total_users = $this->userModel->countAll();
        // Tải View Dashboard
        require 'views/admin/dashboard.php';
    }

    // ===================================
    // 2. QUẢN LÝ NGƯỜI DÙNG
    // ===================================

    public function manageUsers() {
        $this->checkAdmin();
        
        $stmt = $this->userModel->readAll();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/admin/users/manage.php';
    }

    public function toggleUserStatus() {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['status'])) {
            $user_id = $_POST['user_id'];
            $new_status = (int)$_POST['status']; 
            
            if ($this->userModel->updateStatus($user_id, $new_status)) {
                // Thành công, chuyển hướng về trang quản lý
                header('Location: ' . BASE_URL . 'admin/users?success=status_updated');
                exit;
            } else {
                // Thất bại
                header('Location: ' . BASE_URL . 'admin/users?error=status_failed');
                exit;
            }
        }
        header('Location: ' . BASE_URL . 'admin/users');
        exit;
    }

    // ===================================
    // 2.1. TẠO TÀI KHOẢN GIẢNG VIÊN (MỚI)
    // ===================================
    
    /**
     * Hiển thị Form tạo tài khoản Giảng viên
     */
    public function createInstructor() {
        $this->checkAdmin();
        require 'views/admin/users/create_instructor.php';
    }

    /**
     * Xử lý POST request để tạo tài khoản Giảng viên (Cập nhật Role = 1)
     */
    public function handleCreateInstructor() {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');
            // Thêm trim() cho mật khẩu, tuy nhiên, không nên trim() mật khẩu trước khi hash
            $password = $_POST['password'] ?? ''; 
            
            $instructor_role = 1; 
            $error_message = ''; // Biến để lưu trữ lỗi

            // 1. Kiểm tra đầu vào
            if (empty($username) || empty($email) || empty($password) || empty($fullname)) {
                $error_message = "Vui lòng điền đầy đủ các trường bắt buộc.";
            } elseif (strlen($password) < 6) {
                $error_message = "Mật khẩu phải có ít nhất 6 ký tự.";
            } elseif ($this->userModel->isExist($username, $email)) { 
                // 2. Kiểm tra trùng lặp (Yêu cầu hàm isExist() phải có trong User.php)
                $error_message = "Tên đăng nhập hoặc Email đã tồn tại.";
            } 
            
            if ($error_message) {
                // Xảy ra lỗi
                $_SESSION['error'] = $error_message;
                header("Location: " . BASE_URL . "admin/create-instructor");
                exit;
            }

            // 3. Xử lý thành công
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            if ($this->userModel->createUserByAdmin($username, $email, $fullname, $password_hashed, $instructor_role)) {
                $_SESSION['success'] = "Đã tạo tài khoản Giảng viên **{$fullname}** (Role: 1) thành công!";
                // Chuyển hướng về trang quản lý người dùng
                header("Location: " . BASE_URL . "admin/users"); 
                exit;
            } else {
                // Lỗi DB không rõ (ví dụ: lỗi kết nối, lỗi SQL)
                $_SESSION['error'] = "Lỗi hệ thống khi tạo tài khoản (Lỗi Model). Vui lòng kiểm tra log DB.";
                header("Location: " . BASE_URL . "admin/create-instructor");
                exit;
            }
        }
        
        // Nếu không phải POST, chuyển hướng về danh sách người dùng
        header('Location: ' . BASE_URL . 'admin/users');
        exit;
    }
    // ===================================
    // 3. QUẢN LÝ DANH MỤC
    // ===================================

    public function manageCategories() {
        $this->checkAdmin();
        
        $stmt = $this->categoryModel->readAll();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/admin/categories/list.php';
    }
    
    // Giả định tạo danh mục thông qua POST request
    public function createCategory() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $this->categoryModel->name = $_POST['name'];
            if ($this->categoryModel->create()) {
                 header('Location: ' . BASE_URL . 'admin/categories?success=created');
                 exit;
            }
        }
        // Nếu không phải POST hoặc tạo thất bại, hiển thị form/list
        $this->manageCategories();
    }

    /**
     * Xử lý POST request để cập nhật danh mục
     */
    public function updateCategory() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['name'])) {
            $this->categoryModel->id = $_POST['id'];
            $this->categoryModel->name = $_POST['name'];

            if ($this->categoryModel->update()) {
                header('Location: ' . BASE_URL . 'admin/categories?success=updated');
                exit;
            }
        }
        // Nếu thất bại hoặc truy cập sai, chuyển về trang list
        header('Location: ' . BASE_URL . 'admin/categories?error=update_failed');
        exit;
    }

    /**
     * Hiển thị form chỉnh sửa danh mục
     */
    public function editCategory() {
        $this->checkAdmin();
        
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: ' . BASE_URL . 'admin/categories?error=invalid_id');
            exit;
        }

        $this->categoryModel->id = $_GET['id'];
        
        if ($this->categoryModel->readOne()) {
            // Lấy dữ liệu từ thuộc tính của Model
            $category = [
                'id' => $this->categoryModel->id,
                'name' => $this->categoryModel->name
            ];
            
            require 'views/admin/categories/edit.php';
        } else {
            header('Location: ' . BASE_URL . 'admin/categories?error=not_found');
            exit;
        }
    }

    /**
     * Xử lý POST request để xóa danh mục
     */
    public function deleteCategory() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $this->categoryModel->id = $_POST['id'];
            
            if ($this->categoryModel->delete()) {
                header('Location: ' . BASE_URL . 'admin/categories?success=deleted');
                exit;
            } else {
                // Xử lý lỗi khóa ngoại nếu có khóa học đang tham chiếu
                header('Location: ' . BASE_URL . 'admin/categories?error=delete_failed');
                exit;
            }
        }
        header('Location: ' . BASE_URL . 'admin/categories');
        exit;
    }
    
    // ===================================
    // 4. DUYỆT KHÓA HỌC
    // ===================================
    
    public function pendingCourses() {
        $this->checkAdmin();
        // Gọi phương thức readPending() đã có trong Course.php
        $stmt = $this->courseModel->readPending(); 
        $pending_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require 'views/admin/courses/pending.php';
    }
    
    public function approveCourse() {
        $this->checkAdmin();
        // Cần thêm phương thức approve() vào Course.php
        // Xử lý logic phê duyệt khóa học tại đây
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id']) && isset($_POST['action'])) {
            
            $course_id = $_POST['course_id'];
            $action = $_POST['action']; // 'approve' hoặc 'reject'
            
            // 2: Published, 4: Rejected (Giả định trạng thái 0 cho từ chối)
            $new_status = ($action === 'approve') ? 2 : 4; 
            
            if ($this->courseModel->updateStatus($course_id, $new_status)) {
                header('Location: ' . BASE_URL . 'admin/courses/pending?success=' . $action);
                exit;
            } else {
                header('Location: ' . BASE_URL . 'admin/courses/pending?error=update_failed');
                exit;
            }
        }
        header('Location: ' . BASE_URL . 'admin/courses/pending');
        exit;
    }

    // ===================================
    // 5. THỐNG KÊ HỆ THỐNG (MỚI)
    // ===================================

    public function viewStatistics() {
        $this->checkAdmin();
        
        $stmt = $this->viewLog->countTopViews(20); 
        $top_views = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/admin/reports/statistics.php';
    }
}