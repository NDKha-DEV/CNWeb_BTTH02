<?php
require_once 'AuthController.php';
require_once 'models/Lesson.php';
require_once 'models/Course.php';
require_once 'config/Database.php';

class LessonController {
    private $db;
    private $lessonModel;
    private $courseModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->lessonModel = new Lesson($this->db);
        $this->courseModel = new Course($this->db);
    }

    // Hàm phụ trợ: Kiểm tra quyền sở hữu khóa học
    private function checkCourseOwner($courseId) {
        if(!AuthController::isInstructorOrAdmin()) return false;
        
        $this->courseModel->id = $courseId;
        if($this->courseModel->readOne()) {
            $currentUserId = AuthController::getCurrentUserId();
            // Nếu là chủ khóa học hoặc là Admin (role 2)
            if($this->courseModel->instructor_id == $currentUserId || AuthController::getCurrentUserRole() == 2) {
                return true;
            }
        }
        return false;
    }

    // 1. Xem danh sách bài học của 1 khóa học
    public function index() {
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        
        if(!$course_id || !$this->checkCourseOwner($course_id)) {
            die("Bạn không có quyền truy cập khóa học này.");
        }

        $lessons = $this->lessonModel->readAllByCourse($course_id);
        $courseTitle = $this->courseModel->title; // Lấy tên khóa học để hiển thị
        
        require_once 'views/instructor/lesson/manage.php';
    }

    // 2. Form tạo bài học
    public function create() {
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;

        if(!$course_id || !$this->checkCourseOwner($course_id)) {
            die("Lỗi: Khóa học không tồn tại hoặc bạn không có quyền.");
        }

        require_once 'views/instructor/lesson/create.php';
    }

    // 3. Xử lý lưu bài học mới
    public function store() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $course_id = $_POST['course_id'];

            if(!$this->checkCourseOwner($course_id)) die("Không có quyền.");

            $this->lessonModel->setCourseId($course_id) = $course_id;
            $this->lessonModel->setTitle($_POST['title']);
            $this->lessonModel->setContent($_POST['content']);
            $this->lessonModel->setVideoUrl($_POST['video_url']);
            $this->lessonModel->setLessonOrder($_POST['lesson_order']);

            if($this->lessonModel->create()) {
                header("Location: " . BASE_URL . "lesson/manage?course_id=" . $course_id);
            } else {
                echo "Lỗi khi tạo bài học.";
            }
        }
    }

    // 4. Form sửa bài học
    public function edit() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $this->lessonModel->setCourseId($id) = $id;

        if($this->lessonModel->readOne()) {
            // Kiểm tra quyền với khóa học chứa bài học này
            if(!$this->checkCourseOwner($this->lessonModel->getCourseId())) die("Không có quyền.");
            
            require_once 'views/instructor/lesson/edit.php';
        } else {
            echo "Không tìm thấy bài học.";
        }
    }

    // 5. Cập nhật bài học
    public function update() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $id) {
            $this->lessonModel->setId($id);
            
            // Lấy thông tin cũ để biết course_id
            $this->lessonModel->readOne();
            $course_id = $this->lessonModel->getCourseId();

            if(!$this->checkCourseOwner($course_id)) die("Không có quyền.");

            // Gán dữ liệu mới
            $this->lessonModel->setTitle($_POST['title']);
            $this->lessonModel->setContent($_POST['content']);
            $this->lessonModel->setVideoUrl($_POST['video_url']);
            $this->lessonModel->setLessonOrder($_POST['lesson_order']);

            if($this->lessonModel->update()) {
                header("Location: " . BASE_URL . "lesson/manage?course_id=" . $course_id);
            } else {
                echo "Lỗi cập nhật.";
            }
        }
    }

    // 6. Xóa bài học
    public function delete() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $this->lessonModel->setId($id) ;
        
        if($this->lessonModel->readOne()) {
            $course_id = $this->lessonModel->getCourseId();
            if(!$this->checkCourseOwner($course_id)) die("Không có quyền.");

            if($this->lessonModel->delete()) {
                header("Location: " . BASE_URL . "lesson/manage?course_id=" . $course_id);
            }
        }
    }
}
?>