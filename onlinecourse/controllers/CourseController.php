<?php 
require_once 'AuthController.php';
require_once 'models/Course.php';
require_once 'models/Category.php';
require_once 'config/Database.php';

class CourseController{
    private $db;
    public $course;
    public $category;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
        $this->course = new Course($this->db);
        $this->category = new Category($this->db);
    }

    // Chặn truy cập nếu không có quyền truy cập
    private function requirePermission(){
        if(!AuthController::isInstructorOrAdmin()){
            echo "Bạn không có quyền truy cập chức năng này";
            exit();
        }
    }

    // Kiểm tra quyền sở hữu khóa học 
    public function checkOwnership($courseInstructorId){
        $currentUserId = AuthController::getCurrentUserId();
        $currentUserRole = AuthController::getCurrentUserRole();

        if($currentUserRole == 2) return true;
        if($currentUserRole == 1 && $currentUserId == $courseInstructorId) return true;

        return false;
    }

    // Chức năng Read (Management)
public function index() {
    // 1. Kiểm tra quyền hạn
    // $this->requirePermission();

    // 2. Lấy ID của giảng viên đang đăng nhập
    $currentUserId = AuthController::getCurrentUserId();

    // 3. Gọi Model để lấy danh sách khóa học của giảng viên này
    $courses = $this->course->readAllByInstructor($currentUserId);

    // 4. Gọi View hiển thị (Lưu ý đường dẫn không có ../)
    require_once 'views/instructor/course/manage.php';
}
    // Chức năng Create
    public function create(){
        // $this->requirePermission();

        $categories = $this->category->readAll();
        require_once 'views/instructor/course/create.php';
    }

    public function store() {
        // $this->requirePermission();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->bindCourseData($_POST);

            //Lấy instructor_id từ session hiện tại 
            $this->course->instructor_id = AuthController::getCurrentUserId();

            // Xử lý upload ảnh
            $uploadResult = $this->handleImageUpload($_FILES['image']);
                
            if($uploadResult['success'] ){
                $this->course->image = $uploadResult['fileName'];
            }else{
                $this->course->image = 'default.jpg';
            }

            // Lửu vào DB
            if($this->course->create()){
                header("location: index.php?controller=course&action=index");
            }else{
                echo "Lỗi tạo khóa học trong cở sở dữ liệu.";
            }
        }
    }


    // Chức năng chỉnh sửa
    public function edit($id) {
        $this->requirePermission();

        $this->course->id = $id;
        if($this->course->readOne()){
            if(!$this->checkOwnership($this->course->instructor_id)){
                die("Bạn không có quyền chỉnh sửa khóa học của người khác");
            }

            $categories = $this->category->readAll();
            require_once 'views/instructor/course/edit.php';
        }else{
            echo "Không tìm thấy khóa học";
        }
    }

    public function update($id) {
        $this->requirePermission();

        $this->course->id = $id;
        if(!$this->course->readOne()) {
            die("Không tìm thấy khóa học này trong CSDL.");
        }

        if(!$this->checkOwnership($this->course->instructor_id)){
            // Debug: In ra để biết tại sao sai (Xóa sau khi sửa xong)
            echo "User hiện tại: " . AuthController::getCurrentUserId();
            echo " - Chủ khóa học: " . $this->course->instructor_id;
            die(" Hành động bị từ chối. Bạn không phải là chủ khóa học này.");
        }

        $oldImageName = $this->course->image;

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $this->bindCourseData($_POST);

            $this->course->id = $id;

            if(!empty($_FILES['image']['name']))
            {   
                $uploadResult = $this->handleImageUpload($_FILES['image']);

                if($uploadResult['success']){
                    // Gán ảnh mới
                    $this->course->image = $uploadResult['fileName'];

                    // SỬA: Xóa ảnh CŨ (biến $oldImageName đã được lấy ở đầu hàm)
                    $this->deleteOldImage($oldImageName); 
                }else{
                    die("Lỗi upload: " . implode(', ', $uploadResult['errors']));
                }
            } else {
                // Nếu không up ảnh mới thì giữ nguyên ảnh cũ
                $this->course->image = $oldImageName;
            } 

            if($this->course->update())
            {
                header("Location: index.php?controller=course&action=index");
                exit();
            }else{
                echo "Lỗi khi không cập nhật cơ sở dữ liệu.";
            }
        }
    }

    // Chức năng Xóa
    public function delete($id) {
        $this->course->id = $id;
        if($this->course->delete()){
            header("Location: index.php?controller=course&action=index");
        }else{
            echo "Lỗi khi không xóa ở cơ sở dữ liệu";
        }
    }
    // Các hàm hỗ trợ
    private function handleImageUpload($file) {
       // 1. Cấu hình thư mục lưu trữ
        $target_dir = "assets/uploads/courses/";
        
        // Tự động tạo thư mục nếu chưa có (Quan trọng để không bị lỗi upload)
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $result = ['success' => false, 'fileName' => '', 'errors' => []];

        // 2. Kiểm tra lỗi cơ bản từ PHP
        // Lưu ý: Key đúng là 'error' (số ít), code cũ của bạn là 'errors' (số nhiều) gây lỗi
        if (!isset($file) || $file['error'] !== 0) {
            $result['errors'][] = "Lỗi file upload (Mã lỗi: " . ($file['error'] ?? 'Unknown') . ")";
            return $result;
        }

        // 3. Sử dụng tên file gốc (Đơn giản hóa)
        // basename() giúp loại bỏ các ký tự đường dẫn nguy hiểm, chỉ lấy tên file.extension
        $simple_file_name = basename($file['name']);
        $target_file = $target_dir . $simple_file_name;

        // 4. Di chuyển file vào thư mục
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $result['success'] = true;
            $result['fileName'] = $simple_file_name; // Trả về tên file gốc để lưu vào DB
        } else {
            $result['errors'][] = "Không thể lưu file. Hãy kiểm tra quyền ghi thư mục 'assets/uploads/courses/'";
        }

        return $result; 
    }

    private function bindCourseData($data) {
        $this->course->title          = $data['title'] ?? '';
        $this->course->description    = $data['description'] ?? '';
        $this->course->price          = $data['price'] ?? 0;
        $this->course->category_id    = $data['category_id'] ?? null;
        $this->course->duration_weeks = $data['duration_weeks'] ?? 0;
        $this->course->level          = $data['level'] ?? 'Beginner';
    }

    private function deleteOldImage($fileName) {
        $target_dir = "assets/uploads/courses/";
        if(!empty($fileName) && $fileName != 'default.jpg' && file_exists($target_dir . $fileName)){
            unlink($target_dir . $fileName);
        }
    }
}