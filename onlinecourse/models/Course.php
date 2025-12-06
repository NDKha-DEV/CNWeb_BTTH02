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
    
    public function readAll(){
        $query = "Select * From ". $this->table_name ;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
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
?>