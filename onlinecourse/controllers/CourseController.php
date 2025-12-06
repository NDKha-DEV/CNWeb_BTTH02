<?php 
require_once 'AuthController.php';
require_once '../models/Course.php';
require_once '../models/Category.php';
require_once '../config/Database.php';

class CourseController{
    private $db;
    private $course;
    private $catergory;

    private function __construct(){
        $database = new Database();
        $this->db = $database;
        $this->course = new Course($this->db);
        $this->catergory = new Category($this->db);
    }

    // Chặn truy cập nếu không có quyền truy cập
    public function requirePermission(){
        if(AuthController::isInstructorOrAdmin()){
            echo "Bạn không có quyền truy cập chức năng này";
            exit();
        }
    }

    // Kiểm tra quyền sở hữu khóa học 
    public function checkOwnership($courseIntructorId){
        $currentUserId = AuthController::getCurrentUserId();
        $currentUserRole = AuthController::getCurrentUserRole();

        if($currentUserRole == 2) return true;
        if($currentUserId == 1 && $currentUserId == $courseIntructorId) return true;

        return false;
    }

    // Chức năng Create
    public function create(){
        $this->requirePermission();

        $categories = $this->catergory->readAll();
        require_once '../views/instructor/course/create.php';
    }

    public function store() {
        $this->requirePermission();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->course->title = $_POST['title'];
            $this->course->description = $_POST['discription'];
            $this->course->
        }
    }
}