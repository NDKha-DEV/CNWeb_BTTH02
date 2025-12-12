<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Enrollment.php";

class EnrollmentController {

	private $db;
	private $enrollmentModel;

	public function __construct() {
		$database = new Database();
		$this->db = $database->getConnection();
		$this->enrollmentModel = new Enrollment($this->db);
	}

	// 1. ĐĂNG KÝ KHÓA HỌC

	public function register() {
		if (!isset($_SESSION['user_id'])) {
			echo "Bạn cần đăng nhập để đăng ký khóa học!";
			exit;
		}

		if (!isset($_POST['course_id'])) {
			echo "Thiếu thông tin khóa học!";
			exit;
		}

		$course_id = $_POST['course_id'];
		$student_id = $_SESSION['user_id'];

		// Gán vào model
		$this->enrollmentModel->course_id = $course_id;
		$this->enrollmentModel->student_id = $student_id;

		// Kiểm tra đã đăng ký chưa
		$check = $this->enrollmentModel->checkEnrollment();

		if ($check->rowCount() > 0) {
			header('Location: '.BASE_URL.'lessons/student?course_id='.$course_id);
			exit;
		}

		// Đăng ký
		if ($this->enrollmentModel->enrollCourse()) {
			header('Location: '.BASE_URL.'lesson/student?lesson_id='.$course_id);
			exit;
		} else {
			echo "Lỗi hệ thống! Không thể đăng ký khóa học.";
		}
	}

	// =======================================================
	// 2. LẤY DANH SÁCH KHÓA HỌC ĐÃ ĐĂNG KÝ
	// =======================================================
	public function myCourses() {
		if (!isset($_SESSION['user_id'])) {
			echo "Bạn cần đăng nhập để xem khóa học!";
			exit;
		}

		$student_id = $_SESSION['user_id'];

		$result = $this->enrollmentModel->getEnrolledCourses($student_id);
		$enrollments  = $result->fetchAll(PDO::FETCH_ASSOC);

		include __DIR__ . "/../views/student/dashboard.php";
	}
}