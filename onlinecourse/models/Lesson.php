<?php

class Lesson {

    private $con;
    private $table_name = "lessons";

    // Các thuộc tính đúng như bảng
    public $id;
    public $course_id;
    public $title;
    public $content;
    public $video_url;
    public $lesson_order;
    public $created_at;


    // ======================================
    // 🔹 GETTER & SETTER
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getCourseId() {
        return $this->course_id;
    }
    public function setCourseId($course_id) {
        $this->course_id = $course_id;
        return $this;
    }
    
    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    public function getContent() {
        return $this->content;
    }
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    
    public function getVideoUrl() {
        return $this->video_url;
    }
    public function setVideoUrl($video_url) {
        $this->video_url = $video_url;
        return $this;
    }
    
    public function getLessonOrder() {
        return $this->lesson_order;
    }
    public function setLessonOrder($lesson_order) {
        $this->lesson_order = $lesson_order;
        return $this;
    }
    
    public function getCreateAt() {
        return $this->create_at;
    }
    public function setCreateAt($create_at) {
        $this->create_at = $create_at;
        return $this;
    }
    // ======================================

    public function __construct($db){
        $this->con = $db;
    }

    // Lấy tất cả bài học thuộc về 1 khóa học
    public function getByCourseId($course_id) {
        $query = "SELECT * FROM " . $this->table_name. " WHERE course_id = :course_id ORDER BY lesson_order ASC";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->course_id = $row['course_id'];
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->video_url = $row['video_url'];
            $this->lesson_order = $row['lesson_order'];
            return true;
        }
        return false;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET course_id=:course_id, title=:title, content=:content, 
                      video_url=:video_url, lesson_order=:lesson_order";
        
        $stmt = $this->con->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = $this->content; // Content có thể chứa HTML nên hạn chế strip_tags quá mạnh nếu dùng editor
        $this->video_url = htmlspecialchars(strip_tags($this->video_url));

        $stmt->bindParam(':course_id', $this->course_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':video_url', $this->video_url);
        $stmt->bindParam(':lesson_order', $this->lesson_order);

        if($stmt->execute()) return true;
        return false;
    }
    // 4. Cập nhật bài học
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET title=:title, content=:content, video_url=:video_url, lesson_order=:lesson_order
                  WHERE id=:id";
        
        $stmt = $this->con->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->video_url = htmlspecialchars(strip_tags($this->video_url));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':video_url', $this->video_url);
        $stmt->bindParam(':lesson_order', $this->lesson_order);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) return true;
        return false;
    }
    // 5. Xóa bài học
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()) return true;
        return false;
    }

    // Lấy danh sách bài học theo khóa học
    public function getLessonById($lesson_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                WHERE id = :id 
                LIMIT 1";

        $stmt = $this->con->prepare($query);
        $stmt->bindParam(":id", $lesson_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }
}?>
