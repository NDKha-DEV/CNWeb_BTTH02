<?php 
require_once 'AuthController.php';
require_once '../models/Course.php';
require_once '../models/Category.php';
require_once '../config/Database.php';

class CourseController{
    private $db;
    private $course;
    private $category;

    public function __construct(){
        $database = new Database();
        $this->db = $database;
        $this->course = new Course($this->db);
        $this->catergory = new Category($this->db);
    }

    // Chặn truy cập nếu không có quyền truy cập
    private function requirePermission(){
        if(!AuthController::isInstructorOrAdmin()){
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

        $categories = $this->category->readAll();
        require_once '../views/instructor/course/create.php';
    }

    public function store() {
        $this->requirePermission();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->course->title = $_POST['title'];
            $this->course->description = $_POST['discription'];
            $this->course->price = $_POST['price'];
            $this->course->category_id = $_POST['category_id'];
            $this->course->duration_weeks = $_POST['duration_weeks'];
            $this->course->level = $_POST['level'];

            //Lấy instructor_id từ session hiện tại 
            $this->course->instructor_id = AuthController::getCurrentUserId();

            //Xử lý load ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

                // Cấu hình thư mục và giới hạn
                $target_dir = "assets/uploads/courses/";
                $max_size = 2 * 1024 * 1024; // 2MB
                $allowed_extensions = ['jpeg', 'jpg', 'png'];

                // Kiểm tra và tạo thư mục nếu chưa tồn tại
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                // Lấy thông tin file
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_name_original = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];

                // Lấy đuôi file an toàn hơn bằng pathinfo
                $file_ext = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

                // Mảng chứa lỗi
                $errors = [];

                // Validate (Kiểm tra)
                // Kiểm tra định dạng
                if (!in_array($file_ext, $allowed_extensions)) {
                    $errors[] = "Chỉ hỗ trợ upload file định dạng: " . implode(', ', $allowed_extensions);
                }

                // Kiểm tra kích thước
                if ($file_size > $max_size) {
                    $errors[] = 'Kích thước file không được lớn hơn 2MB.';
                }

                // Xử lý upload
                if (empty($errors)) {
                    // Tạo tên file mới: time + random string + ext để đảm bảo KHÔNG BAO GIỜ trùng
                    $new_file_name = time() . '_' . uniqid() . '.' . $file_ext;
                    $target_file = $target_dir . $new_file_name;

                    if (move_uploaded_file($file_tmp, $target_file)) {
                        // Upload thành công
                        echo "Success";
                        
                    } else {
                        echo "Lỗi khi di chuyển file (Check permissions).";
                    }
                } else {
                    // Xuất lỗi
                    foreach ($errors as $error) {
                        echo $error . "<br>";
                    }
                }
            } else {
                // Xử lý trường hợp có lỗi từ phía server hoặc chưa chọn file
                if (isset($_FILES['image']['error']) && $_FILES['image']['error'] !== 4) {
                    echo "Có lỗi xảy ra khi upload. Mã lỗi: " . $_FILES['image']['error'];
                }
            }

            if($this->course->create()){
                header("location: index.php?controller=course&action=index");
            }else{
                echo "Lỗi tạo khóa học";
            }
        }
    }

    // Các hàm hỗ trợ
    private function hanldeImageUpload($file) {
        // Config
        $target_dir = "assets/uploads/courses/";
        $max_size = 2 *1024 * 1024;
        $allowed_extentions = ['jpeg', 'jpg', 'png', 'webp'];

        $result = ['success' => false, 'fileName' => '', 'errors' => []];

        if(!isset($file) || $file['error'] !== 0){
            $result['errors'][] = "Chưa chọn file hoặc lỗi server (Code: {$file['errors']})";
            return $result;
        }

        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        //validate
        if(!in_array($file, $allowed_extentions)){
            $result['errors'][] = "Chỉ hỗ trợ file: ". implode(', ', $allowed_extentions);
        }
        if($file['size'] > $max_size){
            $result['errors'][] = "File quá lớn (>2MB).";
        }

        if(empty($result['errors'])){
            // Đặt tên file ngẫu nnhieen
            $new_file_name = time() . "__" . uniqid() . "." . $file_ext;

            if(move_uploaded_file($file['tmp_name'], $target_dir. $new_file_name)){
                $result['success'] = true;
                $result['fileName'] = $new_file_name;
            }
            else{
                $result['errors'][] = "Không thể di chuyển được file vào thư mục đích.";
            }
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
}