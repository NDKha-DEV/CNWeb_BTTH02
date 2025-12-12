<?php
// onlinecourse/models/Category.php

class Category {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Tạo danh mục mới
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(":name", $this->name);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Đọc tất cả danh mục
     */
    public function readAll() {
        $query = "SELECT id, name FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // ===================================
    // PHƯƠNG THỨC MỚI BỔ SUNG CHO ADMIN
    // ===================================

    /**
     * Đọc thông tin chi tiết một danh mục theo ID
     */
    public function readOne() {
        $query = "SELECT id, name FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Gán giá trị vào thuộc tính của đối tượng
            $this->name = $row['name'];
            return true;
        }
        return false;
    }

    /**
     * Cập nhật tên danh mục
     */
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Làm sạch và binding
        $this->name = htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Xóa danh mục
     */
    // public function delete() {
    //     $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
    //     $stmt = $this->conn->prepare($query);

    //     $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

    //     // Chú ý: Cần xử lý lỗi nếu có Khóa học đang tham chiếu đến danh mục này (Khóa ngoại)!
    //     try {
    //          if ($stmt->execute()) {
    //             return true;
    //         }
    //     } catch (PDOException $e) {
    //         // Có thể ghi log lỗi hoặc trả về false nếu vi phạm khóa ngoại
    //         logError($e->getMessage());
    //         return false;
    //     }
       
    //     return false;
    // }
}