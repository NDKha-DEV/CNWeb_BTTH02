<?php 
// views/reports/statistics.php

// Giả định bạn có header/sidebar
// include 'views/layouts/header.php';
// include 'views/layouts/sidebar.php';

$page_title = "Thống kê Lượt truy cập (Top Views)";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
</head>
<body>

<div class="container py-4">
    <h2 class="h3 mb-4 text-primary">📊 <?= $page_title ?></h2>
    
    <?php if (!empty($top_views)): ?>
        <table class="admin-table" border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Đường dẫn (Route)</th>
                    <th>Tổng số lượt xem</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                <?php foreach ($top_views as $view): ?>
                    <tr>
                        <td><?= $stt++ ?></td>
                        <td>/onlinecourse/<?= htmlspecialchars($view['path']) ?></td>
                        <td>**<?= number_format($view['total_views']) ?>**</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có dữ liệu lượt truy cập nào được ghi lại.</p>
    <?php endif; ?>
    
    <p style="margin-top: 20px;">Quay lại <a href="<?= BASE_URL ?>admin/dashboard">Dashboard</a></p>
</div>

</body>
</html>