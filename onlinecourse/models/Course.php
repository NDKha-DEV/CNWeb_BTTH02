<?php
class Course{
    private $conn;
    private $table_name ="courses";
    private $id;
    private $title;
    private $description;
    private $instructor_id;
    private $category_id;
    private $price;
    private $duration_weeks;
    private $level;
    private $image;
    private $created_at;

    public function __construct($db){
        $this->conn = $db;
    }
        
    public function create(){
        $query = "Insert Into" . $this->table_name . "
                    (title, description, instructor_id, category_id, price, duration_weeks, level, image)
                    values (:title, :description, :instructor_id, :category_id, :price, : duration_weeks, :level, :image);";
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

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "Update " . $this->table_name . 
                    "Set title = :title,
                        description = :description,
                        category_id = :category_id,
                        price = :price,
                        duration_weeks = :duration_weeks,
                        level = :level,
                        image = :image,
                        update_at = NOW()
                    Where id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam('title', $this->title);
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

}