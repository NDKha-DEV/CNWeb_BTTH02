<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Course - <?= $page_title ?? 'Home' ?></title>

    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <!-- Optional: Page-specific CSS -->
    <!-- $css_files = ['dashboard.css', 'charts.css', 'datatables.css']; -->
    <?php if (isset($css_files) && is_array($css_files)): ?>
        <?php foreach ($css_files as $css): ?>
            <link href="<?= BASE_URL ?>assets/css/<?= $css ?>" rel="stylesheet">
        <?php endforeach; ?>
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<?php include 'sidebar.php'; ?>