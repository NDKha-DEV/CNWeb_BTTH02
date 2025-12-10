<?php

class Material {

    private $conn;
    private $table = "materials";

    // Thuộc tính đúng theo bảng
    public $id;
    public $lesson_id;
    public $filename;
    public $file_path;
    public $file_type;
    public $uploaded_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách tài liệu theo bài học
    public function getMaterialsByLesson($lesson_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE lesson_id = :lesson_id
                  ORDER BY uploaded_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":lesson_id", $lesson_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
    
}








