<?php
class Category{
    private $conn;
    private $table_name = "categories";
    private $id;
    private $name;

    public function __construct($db){
        $this->conn = $db;
    }

    // Lấy tất cả các danh mục
    public function readAll(){
        $query = "Select id , name From " . $this->table_name ." Order By name";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute();
    }
}