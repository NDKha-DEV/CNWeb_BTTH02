<?php
class Course{
    private $conn;
    private $table_name ="courses";
    public $id;
    public $title;
    public $description;
    public $instructor_id;
    public $category_id;
    public $price;
    public $duration_weeks;
    public $level;
    public $image;
    public $status;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }
    
    

    //CỤM CHỨC NĂNG 1: XEM DANH SÁCH KHÓA HỌC (CÓ TÌM KIẾM VÀ LỌC THEO DANH MỤC)
    
    //TRUY VẤN LẤY TẤT CẢ KHÓA HỌC PHỤC VỤ XEM KHÓA HỌC

     public function getAll() {
        $query = "SELECT c.*, u.fullname AS instructor_name, cat.name AS category_name
                  FROM " . $this->table_name . " c
                  LEFT JOIN users u ON u.id = c.instructor_id
                  LEFT JOIN categories cat ON cat.id = c.category_id
                  WHERE c.status = 2
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    //TRUY VẤN LẤY TẤT CẢ KHÓA HỌC THEO TỪ KHÓA PHỤ THUỘC VÀO TÊN TIÊU ĐỀ KHÓA HỌC

    public function searchByKeyword($keyword) {
        $query = "SELECT c.*, u.fullname AS instructor_name, cat.name AS category_name
                FROM " . $this->table_name . " c
                LEFT JOIN users u ON u.id = c.instructor_id
                LEFT JOIN categories cat ON cat.id = c.category_id
                WHERE c.title LIKE :keyword AND c.status = 2
                ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->execute();
        return $stmt;
    }

    //TRUY VẤN TẤT CẢ KHÓA HỌC LỌC THEO LOẠI DANH MỤC

    public function filterByCategory($category_id) {
        $query = "SELECT c.*, u.fullname AS instructor_name, cat.name AS category_name
                FROM " . $this->table_name . " c
                LEFT JOIN users u ON u.id = c.instructor_id
                LEFT JOIN categories cat ON cat.id = c.category_id
                WHERE c.category_id = :category_id AND c.status = 2
                ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        return $stmt;
    }

    //TRUY VẤN TẤT CẢ KHÓA HỌC THEO TỪ KHÓA PHỤ THUỘC VÀO TÊN TIÊU ĐỀ KHÓA HỌC 
    // KHI ĐÃ ĐƯỢC LỌC THEO THEO LOẠI DANH MỤC

    public function combinedSearchFilter($keyword, $category_id) {
        $query = "SELECT c.*, u.fullname AS instructor_name, cat.name AS category_name
                FROM " . $this->table_name . " c
                LEFT JOIN users u ON u.id = c.instructor_id
                LEFT JOIN categories cat ON cat.id = c.category_id
                WHERE c.title LIKE :keyword AND c.category_id = :category_id AND c.status = 2
                ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(":keyword", $kw);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        return $stmt;
    }

    //CHỨC NĂNG 2: TRUY VẤN CỤ THỂ TỪNG KHÓA HỌC

    public function getById($id) {
        $query = "SELECT c.*, u.fullname AS instructor_name, cat.name AS category_name
                FROM " . $this->table_name . " c
                LEFT JOIN users u ON u.id = c.instructor_id
                LEFT JOIN categories cat ON cat.id = c.category_id
                WHERE c.id = :id AND c.status = 2
                LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 mảng
    }
    public function readAll(){
            $query = "Select * From ". $this->table_name. " WHERE status = 2 ORDER BY created_at DESC;";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }


    // Hàm lấy tất cả khóa học của một giảng viên cụ thể
    public function readAllByInstructor($instructor_id) {
        // 1. Chuẩn bị câu lệnh SQL
        $query = "SELECT * FROM " . $this->table_name . " WHERE instructor_id = ? ORDER BY created_at DESC";

        // 2. Prepare statement
        $stmt = $this->conn->prepare($query);

        // 3. Gán giá trị ID vào dấu ?
        $stmt->bindParam(1, $instructor_id);

        // 4. Thực thi
        $stmt->execute();

        // 5. Trả về kết quả
        return $stmt;
    }
    public function create(){
        $query = "Insert Into " . $this->table_name . " 
                    (title, description, instructor_id, category_id, price, duration_weeks, level, image, status)
                    values (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image, :status);";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':instructor_id', $this->instructor_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':duration_weeks', $this->duration_weeks);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readOne() {
        $query = "Select * From " . $this->table_name ." where id = ? Limit 0,1;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row){
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->instructor_id = $row['instructor_id'];
            $this->category_id = $row['category_id'];
            $this->price = $row['price'];
            $this->duration_weeks = $row['duration_weeks'];
            $this->level = $row['level'];
            $this->image = $row['image'];
            $this->status = $row['status'];
            return true;
        }
        return false;
    }

    public function readPending() {
        $query = "SELECT 
                    c.id, c.title, c.description, c.created_at, c.instructor_id,
                    u.fullname as instructor_name, u.email as instructor_email
                FROM " . $this->table_name . " c
                LEFT JOIN users u ON c.instructor_id = u.id
                WHERE c.status = 3
                ORDER BY c.created_at ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function updateStatus($course_id, $new_status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':status', $new_status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $course_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "Update " . $this->table_name . 
                    " Set title = :title,
                        description = :description,
                        category_id = :category_id,
                        price = :price,
                        duration_weeks = :duration_weeks,
                        level = :level,
                        image = :image,
                        updated_at = NOW()
                    Where id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':duration_weeks', $this->duration_weeks);
        $stmt->bindParam(':level', $this->level);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) return true;

        return false;
    }

    public function delete(){
        $query = "Delete From " . $this->table_name ." Where id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    public function getStudentsByCourse($course_id) {
        // Kết nối bảng users và enrollments
        $query = "SELECT u.id, u.username, u.email, u.fullname, e.enrolled_date, e.progress
                FROM users u
                JOIN enrollments e ON u.id = e.student_id
                WHERE e.course_id = :course_id
                ORDER BY e.enrolled_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":course_id", $course_id);
        $stmt->execute();
        return $stmt;
    }
    /**
     * Đếm tổng số khóa học (đã được duyệt và chưa duyệt)
     */
    public function countTotalCourses() {
        // Giả định bảng là 'courses'
        $query = "SELECT COUNT(id) as total FROM courses WHERE status >= 2";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    /**
     * Đếm số khóa học đang chờ duyệt (status = 0)
     */
    public function countPendingCourses() {
        // Giả định cột trạng thái là 'status', 3 là chờ duyệt, 2 là đã duyệt
        $query = "SELECT COUNT(id) as total FROM courses WHERE status = 3";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }
}
