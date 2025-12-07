<?php
// controllers/HomeController.php

class HomeController {
    
    public function index() {
        // Đơn giản là hiển thị view trang chủ
        // Lưu ý: Đường dẫn tính từ file index.php gốc
        require_once 'views/home/index.php';
    }
}
?>