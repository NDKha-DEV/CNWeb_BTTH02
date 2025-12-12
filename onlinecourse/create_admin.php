<?php
// onlinecourse/create_admin.php

// 1. Cấu hình
require_once 'config/Database.php';

// Thay đổi thông tin Admin bạn muốn tạo
$admin_data = [
    'username' => 'admin',
    'email'    => 'admin@gmail.com',
    'password' => '123456', // Mật khẩu dạng văn bản
    'fullname' => 'Quản Trị Viên',
    'role'     => 2, // 2: Quản trị viên
    'status'=> 1  // 1: Kích hoạt
];

// 2. Kết nối CSDL
$database = new Database();
$conn = $database->getConnection();

// 3. Băm mật khẩu
$hashed_password = password_hash($admin_data['password'], PASSWORD_BCRYPT);
$admin_data['password'] = $hashed_password;

// 4. Chuẩn bị câu lệnh SQL
$query = "INSERT INTO users 
          SET username=:username, email=:email, password=:password, fullname=:fullname, role=:role, status=:status, created_at=NOW()";

$stmt = $conn->prepare($query);

// 5. Ràng buộc dữ liệu (Binding)
$stmt->bindParam(':username', $admin_data['username']);
$stmt->bindParam(':email', $admin_data['email']);
$stmt->bindParam(':password', $admin_data['password']); // Đã được băm
$stmt->bindParam(':fullname', $admin_data['fullname']);
$stmt->bindParam(':role', $admin_data['role']);
$stmt->bindParam(':status', $admin_data['status']);

// 6. Thực thi
try {
    if($stmt->execute()) {
        echo "Tạo tài khoản Admin thành công! Tên đăng nhập: " . $admin_data['email'] . "\n";
    } else {
        echo "Lỗi: Không thể tạo tài khoản Admin. (Có thể do email hoặc username đã tồn tại)\n";
    }
} catch (PDOException $e) {
    echo "Lỗi CSDL: " . $e->getMessage() . "\n";
}
?>