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
        $this->db = $database->getConnection();
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
            $this->bindCourseData($_POST);

            //Lấy instructor_id từ session hiện tại 
            $this->course->instructor_id = AuthController::getCurrentUserId();

            // Xử lý upload ảnh
            $uploadResult = $this->hanldeImageUpload($_FILES['image']);
                
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
        if($this->course->readOne($id)){
            if(!$this->checkOwnership($this->course->instructor_id)){
                die("Bạn không có quyền chỉnh sửa khóa học của người khác");
            }

            $categories = $this->category->readAll();
            require_once '../views/instructor/course/edit.php';
        }else{
            echo "Không tìm thấy khóa học";
        }
    }

    public function update($id) {
        $this->requirePermission();

        $this->course->id = $id;
        if(!$this->checkOwnership($this->course->instructor_id)){
            die("Hành động bị từ chối.");
        }

        $oldImageName = $this->course->image;

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $this->bindCourseData($_POST);

            $this->course->id = $id;

            if(!empty($_FILES['image']['name']))
            {   
                $uploadResult = $this->hanldeImageUpload($_FILES['image']);

                if($uploadResult['success']){
                    $this->course->image = $uploadResult['fileName'];

                    $this->deleteOldImage($uploadResult['fileName']);
                }else{
                    die("Lỗi upload: " . implode(', ', $uploadResult['errors']));
                }
            }else
            {
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

    private function deleteOldImage($fileName) {
        $target_dir = "assets/uploads/courses/";
        if(!empty($fileName) && !$fileName != 'default.jpg' && file_exists($target_dir . $fileName)){
            unlink($target_dir . $fileName);
        }
    }
}