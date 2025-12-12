# 🎓 HỆ THỐNG KHÓA HỌC TRỰC TUYẾN (ONLINE COURSE PLATFORM)

Dự án phát triển một hệ thống quản lý khóa học trực tuyến (LMS - Learning Management System) đơn giản, cho phép Giảng viên tạo/quản lý khóa học, Học viên đăng ký/học tập, và Admin quản lý hệ thống.

---

## 🚀 Công nghệ và Môi trường Yêu cầu

- **Ngôn ngữ:** PHP (>= 7.4)
- **Database:** MySQL/MariaDB
- **Môi trường:** XAMPP, WAMP, hoặc Docker/LEMP Stack.
- **Kiến trúc:** PHP thuần (Pure PHP) với mô hình Front Controller (MVC đơn giản).

## ⚙️ Hướng dẫn Cài đặt

Thực hiện các bước sau để chạy ứng dụng trên môi trường XAMPP:

### A. Chuẩn bị

1.  **Clone/Tải mã nguồn:**
    ```bash
    git clone [https://github.com/NDKha-DEV/CNWeb_BTTH02.git] onlinecourse
    ```
2.  **Di chuyển thư mục:** Đặt thư mục `onlinecourse` vào thư mục `htdocs` của XAMPP.
    - `C:\xampp\htdocs\onlinecourse`

### B. Cấu hình Database

1.  **Khởi động XAMPP:** Đảm bảo Apache và MySQL đang chạy.
2.  **Tạo Database:** Truy cập `http://localhost/phpmyadmin` và tạo một database mới, ví dụ: `onlinecourse_db`.
3.  **Import Schema:**
    - Bạn cần phải chạy các file SQL tạo bảng (`users`, `courses`, `categories`, `enrollments`, `lessons`, `view_logs`).
    - _(Ghi chú: Nếu có file `.sql` tổng hợp, hãy hướng dẫn import tại đây.)_
    - \_Sử dụng file CreateTable_TH02.sql để tạo ra cơ sở dữ liệu và các bảng dữ liệu
    - \_Sử dụng InsertDB_TH02.sql để import các dòng dữ liệu mẫu của các bảng

### C. Cấu hình Ứng dụng

1.  **Cấu hình Database Connection:** Mở file `config/Database.php` và cập nhật thông tin kết nối nếu cần (thường chỉ cần sửa tên DB):
    ```php
    // Ví dụ: config/Database.php
    private $host = "localhost";
    private $db_name = "onlinecourse"; # Sửa tên DB nếu khác
    private $username = "root";
    private $password = "";
    ```
2.  **Cấu hình BASE_URL:** Mở file `index.php` và xác nhận hằng số `BASE_URL` chính xác:
    ```php
    // index.php (khoảng dòng 12)
    define('BASE_URL', '/onlinecourse/');
    ```

### D. Truy cập Hệ thống

- Mở trình duyệt và truy cập: `http://localhost/onlinecourse/`

## 🛣️ Các Route và Tính năng Chính

Hệ thống được thiết kế dựa trên mô hình MVC với 3 vai trò chính: Học viên (Role 0), Giảng viên (Role 1) và Quản trị viên (Role 2).

### A. Chức năng Học viên (Role 0)

| Tính năng               | Đường dẫn (URL)             | Controller             | Phương thức | Mô tả                                           |
| :---------------------- | :-------------------------- | :--------------------- | :---------- | :---------------------------------------------- |
| **Danh sách Khóa học**  | `/courses`                  | `CourseController`     | GET         | Xem, tìm kiếm và lọc khóa học đã duyệt.         |
| **Chi tiết Khóa học**   | `/courses?id=X`             | `CourseController`     | GET         | Xem mô tả, nội dung, và thông tin giảng viên.   |
| **Đăng ký Khóa học**    | `/enrollment/register`      | `EnrollmentController` | POST        | Ghi danh vào khóa học.                          |
| **Khóa học đã Đăng ký** | `/enrollment`               | `EnrollmentController` | GET         | Danh sách các khóa học mà học viên đã ghi danh. |
| **Xem Bài học**         | `/lesson/student?id=X`      | `LessonController`     | GET         | Xem nội dung (video/tài liệu) của từng bài học. |
| **Theo dõi Tiến độ**    | (Trong trang `/enrollment`) | `EnrollmentController` | GET         | Hiển thị tiến độ học tập.                       |

### B. Chức năng Giảng viên (Role 1)

| Tính năng              | Đường dẫn (URL)         | Controller         | Phương thức        | Mô tả                                                    |
| :--------------------- | :---------------------- | :----------------- | :----------------- | :------------------------------------------------------- |
| **Dashboard/Quản lý**  | `/instructor/dashboard` | `CourseController` | GET                | Trang tổng quan cho giảng viên.                          |
| **Tạo Khóa học**       | `/course/create`        | `CourseController` | GET/POST           | Hiển thị form và xử lý lưu khóa học mới.                 |
| **Chỉnh sửa Khóa học** | `/course/edit?id=X`     | GET/POST           | `CourseController` | Sửa thông tin cơ bản của khóa học.                       |
| **Xóa Khóa học**       | `/course/delete?id=X`   | GET                | `CourseController` | Xóa khóa học.                                            |
| **Gửi duyệt Khóa học** | `/course/submit-review` | POST               | `CourseController` | Đặt trạng thái khóa học thành **Chờ duyệt (3)**.         |
| **Quản lý Bài học**    | `/lesson`               | GET                | `LessonController` | Thêm, sửa, xóa các bài học/chương trong khóa học.        |
| **Danh sách Học viên** | `/course/students?id=X` | GET                | `CourseController` | Xem danh sách học viên đã đăng ký vào khóa học của mình. |

### C. Chức năng Quản trị viên (Role 2)

| Tính năng              | Đường dẫn (URL)                  | Controller        | Phương thức       | Mô tả                                                                     |
| :--------------------- | :------------------------------- | :---------------- | :---------------- | :------------------------------------------------------------------------ |
| **Dashboard**          | `/admin/dashboard`               | `AdminController` | GET               | Tổng quan thống kê hệ thống (dữ liệu động).                               |
| **Quản lý Người dùng** | `/admin/users`                   | GET               | `AdminController` | Xem danh sách, thay đổi trạng thái hoạt động.                             |
| **Tạo Giảng viên**     | `/admin/users/create-instructor` | GET/POST          | `AdminController` | Tạo tài khoản có Role 1.                                                  |
| **QL Danh mục**        | `/admin/categories`              | GET/POST          | `AdminController` | Tạo, xem danh sách, chỉnh sửa danh mục khóa học.                          |
| **Thống kê Hệ thống**  | `/admin/statistics/views`        | GET               | `AdminController` | Xem thống kê lượt truy cập theo đường dẫn (Page Views).                   |
| **Duyệt Khóa học**     | `/admin/courses/pending`         | GET               | `AdminController` | Danh sách khóa học đang **Chờ duyệt (3)**.                                |
| **Phê duyệt/Từ chối**  | `/admin/courses/review?id=X`     | GET               | `AdminController` | Thay đổi trạng thái khóa học thành **Đã duyệt (2)** hoặc **Từ chối (4)**. |

### D. Chức năng Chung (Bất kỳ vai trò nào)

| Tính năng     | Đường dẫn (URL) | Controller       | Phương thức | Mô tả                                |
| :------------ | :-------------- | :--------------- | :---------- | :----------------------------------- |
| **Đăng nhập** | `/login`        | `AuthController` | GET/POST    | Xử lý đăng nhập.                     |
| **Đăng xuất** | `/logout`       | `AuthController` | GET         | Xóa session và đăng xuất người dùng. |

---

## 👤 Tài khoản Mặc định

- Mở trình duyệt và truy cập: `http://localhost/onlinecourse/create_admin.php` để tạo ra tài khoản admin
- **Admin:** `admin@example.com` / `123456`
- **Giảng viên:** `instructor@example.com` / `123456`
- **Học viên:** `student@example.com` / `123456`

## 📝 Ghi công & Bản quyền

Dự án này được phát triển như một bài tập/đồ án.

- **Tác giả:** [NDKha-DEV,germnguyen,nganhcc,SonTuanmandosupport]
