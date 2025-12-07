<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Course.php";

class CourseController {

    private $db;
    private $courseModel;

    public function __construct() {
        // Kết nối DB
        $database = new Database();
        $this->db = $database->getConnection();

        // Khởi tạo model
        $this->courseModel = new Course($this->db);
    }

    public function index() {

        // Lấy keyword
        if (isset($_GET['keyword']) && $_GET['keyword'] !== "") {
            $keyword = $_GET['keyword'];
        } else {
            $keyword = null;
        }

        // Lấy category
        if (isset($_GET['category']) && $_GET['category'] !== "") {
            $category_id = $_GET['category'];
        } else {
            $category_id = null;
        }

        // --------- XỬ LÝ LOGIC ----------

        if ($keyword !== null && $category_id !== null) {
            // Tìm + lọc kết hợp
            $result = $this->courseModel->combinedSearchFilter($keyword, $category_id);
        } elseif ($keyword !== null) {
            // Chỉ tìm theo keyword
            $result = $this->courseModel->searchByKeyword($keyword);
        } elseif ($category_id !== null) {
            // Chỉ lọc theo danh mục
            $result = $this->courseModel->filterByCategory($category_id);
        } else {
            //Không tìm, không lọc → lấy tất cả
            $result = $this->courseModel->getAll();
        }

        // Lấy dữ liệu mảng
        $courses = $result->fetchAll(PDO::FETCH_ASSOC);

        // Gọi view
        include __DIR__ . "/../views/courses/index.php";

    }
}