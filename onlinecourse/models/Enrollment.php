<?php
class Enrollment {
    private $conn;
    private $table_name = "enrollments";

    public $id;
    public $course_id;
    public $student_id;
    public $enrolled_date;
    public $status;
    public $progress;

    public function __construct($db) {
        $this->conn = $db;
    }


    //CỤM CHỨC NĂNG 3: HỌC VIÊN ĐĂNG KÝ KHÓA HỌC

    public function enrollCourse() {
        $query = "INSERT INTO " . $this->table_name . "
                  (course_id, student_id, enrolled_date, status, progress)
                  VALUES (:course_id, :student_id, NOW(), 'active', 0)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":course_id", $this->course_id);
        $stmt->bindParam(":student_id", $this->student_id);

        return $stmt->execute();
    }

    // KIỂM TRA HỌC VIÊN ĐÃ ĐĂNG KÝ KHÓA NÀY CHƯA?
    public function checkEnrollment() {
        $query = "SELECT id FROM " . $this->table_name . "
                  WHERE course_id = :course_id AND student_id = :student_id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":course_id", $this->course_id);
        $stmt->bindParam(":student_id", $this->student_id);

        $stmt->execute();
        return $stmt;
    }

    // ================================
    // 2. XEM DANH SÁCH KHÓA HỌC ĐÃ ĐĂNG KÝ
    // ================================
    public function getEnrolledCourses($student_id) {
        $query = "SELECT e.*, c.title, c.description, c.image,
                         c.instructor_id, u.fullname AS instructor_name
                  FROM " . $this->table_name . " e
                  INNER JOIN courses c ON c.id = e.course_id
                  LEFT JOIN users u ON u.id = c.instructor_id
                  WHERE e.student_id = :student_id
                  ORDER BY e.enrolled_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":student_id", $student_id);
        $stmt->execute();

        return $stmt;
    }


}