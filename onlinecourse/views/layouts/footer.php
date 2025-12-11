    <?php if (isset($js_files) && is_array($js_files)): ?>
        <?php foreach ($js_files as $js): ?>
            <script src="<?= BASE_URL ?>assets/js/<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>