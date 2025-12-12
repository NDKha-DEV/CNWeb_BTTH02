<?php 
// views/reports/statistics.php

$page_title = "Thống kê Lượt truy cập (Top Views)";
$css_files = ['admin-statistics.css']; // CSS riêng đẹp
include './views/layouts/header.php';
?>

<div class="statistics-container">
    <div class="page-header">
        <div>
            <h1><?= $page_title ?></h1>
            <p class="subtitle">Theo dõi các trang được truy cập nhiều nhất trên hệ thống</p>
        </div>
        <a href="<?= BASE_URL ?>admin/dashboard" class="btn-back">
            Dashboard
        </a>
    </div>

    <!-- Tổng quan nhanh -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">Total Views</div>
            <div class="stat-value"><?= number_format(array_sum(array_column($top_views ?? [], 'total_views'))) ?></div>
            <div class="stat-label">Tổng lượt truy cập</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">Unique Pages</div>
            <div class="stat-value"><?= count($top_views ?? []) ?></div>
            <div class="stat-label">Trang được theo dõi</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">Most Popular</div>
            <div class="stat-value">
                <?= !empty($top_views) ? htmlspecialchars($top_views[0]['path']) : '—' ?>
            </div>
            <div class="stat-label">Trang hot nhất</div>
        </div>
    </div>

    <!-- Bảng Top Views -->
    <?php if (!empty($top_views)): ?>
        <div class="table-card">
            <div class="table-header">
                <h2>Top 50 Trang được truy cập nhiều nhất</h2>
                <span class="table-info">Cập nhật: <?= date('d/m/Y H:i') ?></span>
            </div>

            <div class="table-responsive">
                <table class="statistics-table">
                    <thead>
                        <tr>
                            <th width="8%">#</th>
                            <th width="60%">Đường dẫn trang</th>
                            <th width="20%">Lượt xem</th>
                            <th width="12%">Tỉ lệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalAll = array_sum(array_column($top_views, 'total_views'));
                        $rank = 1;
                        foreach ($top_views as $view): 
                            $percentage = $totalAll > 0 ? ($view['total_views'] / $totalAll) * 100 : 0;
                            $barWidth = $percentage;
                        ?>
                            <tr>
                                <td class="rank">
                                    <?php if ($rank === 1): ?>Gold Medal
                                    <?php elseif ($rank === 2): ?>Silver Medal
                                    <?php elseif ($rank === 3): ?>Bronze Medal
                                    <?php else: ?><?= $rank ?><?php endif; ?>
                                </td>
                                <td class="path">
                                    <code class="path-code"><?= BASE_URL ?><?= htmlspecialchars($view['path']) ?></code>
                                </td>
                                <td class="views">
                                    <strong><?= number_format($view['total_views']) ?></strong>
                                </td>
                                <td class="percentage">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= $barWidth ?>%"></div>
                                    </div>
                                    <span class="percent-text"><?= number_format($percentage, 1) ?>%</span>
                                </td>
                            </tr>
                        <?php $rank++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">No Data</div>
            <h3>Chưa có dữ liệu lượt truy cập</h3>
            <p>Hệ thống chưa ghi nhận lượt xem nào. Vui lòng chờ người dùng truy cập.</p>
        </div>
    <?php endif; ?>
</div>

<?php include './views/layouts/footer.php'; ?>
