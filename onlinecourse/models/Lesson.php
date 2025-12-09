<?php

class Lesson {

    private $conn;
    private $table = "lessons";

    // Các thuộc tính đúng như bảng
    public $id;
    public $course_id;
    public $title;
    public $content;
    public $video_url;
    public $order;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách bài học theo khóa học
    public function getLessonById($lesson_id) {
        $query = "SELECT * FROM " . $this->table . " 
                WHERE id = :id 
                LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $lesson_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}
