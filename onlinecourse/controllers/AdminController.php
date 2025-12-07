<?php
// onlinecourse/controllers/AdminController.php

require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'models/Category.php';
// require_once 'models/Course.php'; // Cần để duyệt khóa học

class AdminController {
    private $userModel;
    private $categoryModel;
    // private $courseModel; // Thêm CourseModel để duyệt khóa học

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new User($db);
        $this->categoryModel = new Category($db);
        // $this->courseModel = new Course($db); // Khởi tạo
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
    
    // ===================================
    // 4. DUYỆT KHÓA HỌC
    // ===================================
    
    public function pendingCourses() {
        $this->checkAdmin();
        // Cần thêm phương thức readPending() vào Course.php
        // $stmt = $this->courseModel->readPending(); 
        // $pending_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // require 'views/admin/courses/pending.php';
    }
    
    public function approveCourse() {
        $this->checkAdmin();
        // Cần thêm phương thức approve() vào Course.php
        // Xử lý logic phê duyệt khóa học tại đây
    }
}