<?php
class AuthController{
    //Kiểm tra đã đăng nhập hay chưa;
    public static function isLoggedIn(){
        return isset($_SESSION['user_id']);
    }

    //Kiểm tra có phải giảng viên (1) hoặc Amin (2) không
    public static function isInstructorOrAdmin(){
        if(!self::isLoggedIn()) return false;
        $role = $_SESSION['role'];
        return ($role == 1 || $role == 2);
    }

    //Lấy ID người dung hiện tại 
    public static function getCurrentUserId(){
        return $_SESSION['user_id'] ?? null;
    }

    //Lấy Role người dung hiện tại
    public static function getCurrentUserRole(){
        return $_SESSION['role'] ?? null;
    }
}
?>