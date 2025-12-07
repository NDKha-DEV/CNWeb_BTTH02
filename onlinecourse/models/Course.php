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
                WHERE c.title LIKE :keyword
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
                WHERE c.category_id = :category_id
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
                WHERE c.title LIKE :keyword AND c.category_id = :category_id
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
                WHERE c.id = :id
                LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 mảng
    }

}