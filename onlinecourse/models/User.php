<?php
// onlinecourse/models/User.php

// Giả định class User đã có và có thuộc tính public $email;
class User {
    private $conn;
    private $table_name = "users";

    public $username;
    public $password;
    public $fullname;    
    public $role;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Tìm người dùng theo email. Sử dụng Prepared Statements.
     * @return array|false Thông tin người dùng (id, username, password, role) hoặc false.
     */
    public function findByEmail() {
        $query = "SELECT id, username, email, password, role , status
                  FROM " . $this->table_name . " 
                  WHERE email = ? 
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        // Bind parameter 1 với giá trị email
        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        }

        return false;
    }

    public function create() {
        // 1. Password Hashing: Băm mật khẩu trước khi lưu
        // Sử dụng thuật toán BCRYPT để bảo mật
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        
        $query = "INSERT INTO " . $this->table_name . "
                  SET username=:username, email=:email, password=:password, fullname=:fullname, role=:role";

        $stmt = $this->conn->prepare($query);

        // 2. Làm sạch và binding dữ liệu (Phòng XSS)
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":fullname", $this->fullname);
        
        // Role 0: Học viên (Mặc định cho đăng ký từ form này)
        $this->role = 0; 
        $stmt->bindParam(":role", $this->role, PDO::PARAM_INT); 

        // 3. Thực thi
        try {
            if($stmt->execute()) {
                return true;
            }
        } catch(PDOException $e) {
            // Lỗi khi email/username đã tồn tại (UNIQUE constraint)
            return false;
        }

        return false;
    }
    /**
     * Đọc tất cả người dùng
     * @return PDOStatement Danh sách người dùng
     */
    public function readAll() {
        $query = "SELECT id, username, email, role, status  , created_at FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Cập nhật trạng thái người dùng (kích hoạt/vô hiệu hóa)
     * Giả định status 1: Active, 0: Inactive
     */
    public function updateStatus($user_id, $new_status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':status', $new_status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}