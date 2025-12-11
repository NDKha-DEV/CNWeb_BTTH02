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

    // Hàm lưu thông tin file vào database
    public function createMaterial() {
        $query = "INSERT INTO materials (lesson_id, filename, file_path, file_type) 
                  VALUES (:lesson_id, :filename, :file_path, :file_type)";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $this->filename = htmlspecialchars(strip_tags($this->filename));
        $this->file_path = htmlspecialchars(strip_tags($this->file_path));
        $this->file_type = htmlspecialchars(strip_tags($this->file_type));

        // Bind dữ liệu
        $stmt->bindParam(':lesson_id', $this->lesson_id);
        $stmt->bindParam(':filename', $this->filename);
        $stmt->bindParam(':file_path', $this->file_path);
        $stmt->bindParam(':file_type', $this->file_type);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    
}









