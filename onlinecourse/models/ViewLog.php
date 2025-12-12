<?php
// onlinecourse/models/ViewLog.php

class ViewLog {
    private $conn;
    private $table_name = "view_logs";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Ghi lại một lượt xem trang (View Log)
     * @param int|null $user_id ID người dùng (hoặc null)
     * @param string $path Đường dẫn truy cập (ví dụ: 'admin/dashboard')
     * @return bool
     */
    public function logView($user_id, $path) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, path) 
                  VALUES (:user_id, :path)";
        
        $stmt = $this->conn->prepare($query);

        // Chuẩn bị và làm sạch dữ liệu
        $path_clean = htmlspecialchars(strip_tags($path));
        $user_id_param = $user_id ?? NULL;
        
        $stmt->bindParam(":user_id", $user_id_param, ($user_id === NULL) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindParam(":path", $path_clean);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    /**
     * Đếm tổng lượt truy cập theo từng đường dẫn (Path)
     * @param int $limit Số lượng path muốn lấy
     * @return PDOStatement
     */
    public function countTopViews($limit = 10) {
        $query = "SELECT path, COUNT(*) as total_views 
                  FROM " . $this->table_name . " 
                  GROUP BY path 
                  ORDER BY total_views DESC 
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
}
?>