<?php
require_once "controllers/CourseController.php";

// Tạo controller
$controller = new CourseController();

// Chạy action index
$controller->index();