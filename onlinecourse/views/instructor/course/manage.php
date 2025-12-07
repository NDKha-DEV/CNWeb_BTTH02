<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khóa học</title>
    <style>
        /* CSS cơ bản cho bảng và nút bấm */
        body { font-family: sans-serif; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        /* Style cho bảng */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: middle; }
        th { background-color: #f4f4f4; }
        tr:hover { background-color: #f9f9f9; }

        /* Style cho ảnh */
        .thumb-img { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc; }

        /* Style cho nút bấm */
        .btn { text-decoration: none; padding: 6px 12px; border-radius: 4px; color: white; font-size: 14px; margin-right: 5px; display: inline-block; }
        .btn-add { background-color: #28a745; padding: 10px 20px; font-weight: bold; } /* Xanh lá */
        .btn-edit { background-color: #ffc107; color: black; } /* Vàng */
        .btn-delete { background-color: #dc3545; } /* Đỏ */
        .btn-detail { background-color: #17a2b8; } /* Xanh dương */
    </style>
</head>
<body>

    <div class="header">
        <h2>📂 Danh sách khóa học của tôi</h2>
        <a href="<?php echo BASE_URL; ?>course/create" class="btn btn-add">+ Thêm khóa học mới</a>
    </div>

    <hr>

    <table>
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="12%">Ảnh bìa</th>
                <th width="35%">Tên khóa học</th>
                <th width="15%">Giá / Trình độ</th>
                <th width="20%">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Kiểm tra biến $courses được truyền từ Controller->index()
            if(isset($courses) && $courses->rowCount() > 0): 
                while ($row = $courses->fetch(PDO::FETCH_ASSOC)): 
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>

                    <td>
                        <?php 
                            // Nếu có tên ảnh thì nối đường dẫn, nếu không thì dùng ảnh mặc định
                            $imgName = !empty($row['image']) ? $row['image'] : 'default.jpg';
                            $imgPath = "assets/uploads/courses/" . $imgName;
                            
                            // Kiểm tra file có thật trên ổ cứng không
                            if (file_exists($imgPath)) {
                                echo '<img src="'.$imgPath.'" class="thumb-img">';
                            } else {
                                echo '<span style="color:red; font-size:12px">Ảnh lỗi</span>';
                            }
                        ?>
                    </td>

                    <td>
                        <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                        <br>
                        <small style="color: #666;">
                            Thời lượng: <?php echo $row['duration_weeks']; ?> tuần
                        </small>
                    </td>

                    <td>
                        <div style="font-weight: bold; color: #d9534f;">
                            $<?php echo number_format($row['price']); ?>
                        </div>
                        <small><?php echo $row['level']; ?></small>
                    </td>

                    <td>
                        <a href="<?php echo BASE_URL; ?>course/edit/<?php echo $row['id']; ?>" class="btn btn-edit">
                            ✏️ Sửa
                        </a>

                        <a href="<?php echo BASE_URL; ?>course/delete/<?php echo $row['id']; ?>" 
                           class="btn btn-delete"
                           onclick="return confirm('⚠️ CẢNH BÁO:\nBạn có chắc chắn muốn xóa khóa học này?\nHành động này không thể hoàn tác!');">
                           🗑️ Xóa
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">
                        Bạn chưa tạo khóa học nào. <br><br>
                        <a href="course/create" style="color: blue;">Bấm vào đây để tạo khóa học đầu tiên</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?controller=home" style="text-decoration: none; color: #555;">← Quay về trang chủ</a>

</body>
</html>