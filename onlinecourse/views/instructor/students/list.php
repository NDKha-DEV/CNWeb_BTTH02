<?php include 'views/layouts/header.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">👨‍🎓 Danh sách học viên</h3>
            <small class="text-muted">Khóa học: <strong><?php echo htmlspecialchars($course_title); ?></strong></small>
        </div>
        <a href="<?php echo BASE_URL; ?>instructor/dashboard" class="btn btn-secondary">
            &larr; Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Tên học viên</th>
                        <th width="25%">Email</th>
                        <th width="20%">Ngày đăng ký</th>
                        <th width="15%">Tiến độ học tập</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($students->rowCount() > 0): ?>
                        <?php $i = 1; while ($stu = $students->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td class="fw-bold">
                                    <i class="bi bi-person-circle text-secondary me-2"></i>
                                    <?php echo htmlspecialchars($stu['fullname']); ?>
                                </td>
                                <td><?php echo htmlspecialchars($stu['email']); ?></td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?php echo date('d/m/Y H:i', strtotime($stu['enrolled_date'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($stu['progress'])?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                Chưa có học viên nào đăng ký khóa học này.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>