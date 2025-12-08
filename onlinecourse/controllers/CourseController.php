<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Course.php";

class CourseController {
    private $db;
    private $courseModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->courseModel = new Course($this->db);
    }

    // 1. index(): lấy tất cả khóa học
    public function index() {
        $courses = $this->courseModel->getAll()->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . "/../views/courses/index.php";
    }

    // 2. show($id): xem chi tiết khóa học
    public function show($id) {
        $course = $this->courseModel->getById($id);
        if (!$course) {
            echo "Khóa học không tồn tại!";
            exit;
        }
        include __DIR__ . "/../views/courses/detail.php";
    }

    // 3. search(): xử lý tìm kiếm + lọc category
    public function search() {
        $keyword = !empty($_GET['keyword']) ? $_GET['keyword'] : null;
        $category_id = !empty($_GET['category']) ? $_GET['category'] : null;

        if ($keyword !== null && $category_id !== null) {
            $result = $this->courseModel->combinedSearchFilter($keyword, $category_id);
        } elseif ($keyword !== null) {
            $result = $this->courseModel->searchByKeyword($keyword);
        } elseif ($category_id !== null) {
            $result = $this->courseModel->filterByCategory($category_id);
        } else {
            $result = $this->courseModel->getAll();
        }

        $courses = $result->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . "/../views/courses/search.php";
    }
}