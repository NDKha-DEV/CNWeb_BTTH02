<?php
require_once __DIR__ . "/../models/Lesson.php";
require_once __DIR__ . "/../models/Material.php";
require_once __DIR__ . "/../config/database.php";

class LessonController {

    private $db;
    private $lessonModel;
    private $materialModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();

        $this->lessonModel  = new Lesson($this->db);
        $this->materialModel = new Material($this->db);
    }

    // ================================================
    // HIỂN THỊ CHI TIẾT 1 BÀI HỌC + TÀI LIỆU
    // ================================================
    public function show() {
        if (!isset($_GET['lesson_id'])) {
            echo "Thiếu ID bài học!";
            exit;
        }

        $lesson_id = $_GET['lesson_id'];

        // Lấy bài học
        $lessonStmt = $this->lessonModel->getLessonById($lesson_id);
        $lesson = $lessonStmt->fetch(PDO::FETCH_ASSOC);

        if (!$lesson) {
            echo "Không tìm thấy bài học!";
            exit;
        }

        // Lấy tài liệu đính kèm
        $materialsStmt = $this->materialModel->getMaterialsByLesson($lesson_id);
        $materials = $materialsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Gọi view hiển thị
        include __DIR__ . "/../views/student/my_courses.php";
    }
}