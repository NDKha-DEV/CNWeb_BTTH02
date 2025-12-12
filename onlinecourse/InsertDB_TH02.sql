USE onlinecourse;
-- Categories (ID từ 1 đến 5)
INSERT INTO categories(name, description) VALUES
('Programming', 'Learn coding from basic to advanced'),
('Design', 'Graphic, UI/UX design courses'),
('Marketing', 'Online marketing and branding'),
('Business', 'Business administration and startup'),
('Language', 'English, Japanese, Korean learning');

-- USERS (Chỉ giữ lại 3 tài khoản test)
-- Mật khẩu cho cả 3 tài khoản là '123456'
INSERT INTO users(username, email, password, fullname, role) VALUES
-- ID 1: Admin
('admin', 'admin@example.com', '$2y$10$T1U3H50h0P9Akxtb4BO1luazeq0NywQhJnxsLwKQ9s4pPfOl3JlGW', 'System Admin Test', 2),
-- ID 2: Giảng viên
('teacher_test', 'instructor@example.com', '$2y$10$Yy5xGs72RNvDN4wW9TgP6OH021vQfTG8Axk2NawL/cC1YGceZXWJ.', 'Instructor Test', 1),
-- ID 3: Học viên
('student_test', 'student@example.com', '$2y$10$xoxNLlRXgpe3omnRT3hp9.VfAOkkPTAtDbySJQn9kMtZvlEJPJmoK', 'Student Test', 0);


-- COURSES (ID Giảng viên: 2)
INSERT INTO courses(title, description, instructor_id, category_id, price, duration_weeks, level, image, status)
VALUES
-- ID 1: Giảng viên 2
('HTML & CSS Basics', 'Learn HTML/CSS from zero', 2, 1, 19.99, 4, 'Beginner', 'htmlcss.jpg', 2), -- Đã duyệt (2)
-- ID 2: Giảng viên 2
('JavaScript Mastery', 'JavaScript full guide for beginners', 2, 1, 39.99, 6, 'Intermediate', 'js.jpg', 3), -- Chờ duyệt (3)
-- ID 3: Giảng viên 2
('UI/UX Design Fundamentals', 'Design user interfaces and experience', 2, 2, 59.00, 8, 'Beginner', 'uiux.jpg', 2), -- Đã duyệt (2)
-- ID 4: Giảng viên 2
('Facebook Ads & Marketing', 'Learn how to run ads effectively', 2, 3, 79.99, 6, 'Advanced', 'fbads.jpg', 3), -- Chờ duyệt (3)
-- ID 5: Giảng viên 2
('Startup & Business Model', 'How to launch startup successfully', 2, 4, 99.99, 10, 'Advanced', 'startup.jpg', 2); -- Đã duyệt (2)


-- LESSONS (Liên kết với KH 1 đến 5)
INSERT INTO lessons(course_id, title, content, video_url, lesson_order)
VALUES
(1, 'Introduction to HTML', 'HTML basics...', 'video1.mp4', 1),
(1, 'Working with CSS', 'CSS basics...', 'video2.mp4', 2),
(2, 'Variables & Data Types', 'JS basics...', 'video3.mp4', 1),
(2, 'Functions in JS', 'Functions...', 'video4.mp4', 2),
(3, 'Design Principles', 'UI/UX theory...', 'video5.mp4', 1),
(4, 'Facebook Ads Setup', 'Prepare account...', 'video6.mp4', 1),
(5, 'Startup Mindset', 'Business mindset...', 'video7.mp4', 1);


-- MATERIALS (Liên kết với Bài học 1 đến 7)
INSERT INTO materials(lesson_id, filename, file_path, file_type)
VALUES
(1, 'html_guide.pdf', '/files/html_guide.pdf', 'pdf'),
(2, 'css_cheatsheet.pdf', '/files/css_cheatsheet.pdf', 'pdf'),
(3, 'js_datatypes.doc', '/files/js_datatypes.doc', 'doc'),
(4, 'js_functions.ppt', '/files/js_functions.ppt', 'ppt'),
(5, 'uiux_book.pdf', '/files/uiux_book.pdf', 'pdf'),
(6, 'fbads_template.xlsx', '/files/fbads_template.xlsx', 'xlsx'),
(7, 'startup_canvas.pdf', '/files/startup_canvas.pdf', 'pdf');


-- ENROLLMENTS (Chỉ sử dụng Student ID = 3)
INSERT INTO enrollments(course_id, student_id, status, progress)
VALUES
(1, 3, 'active', 20),
(2, 3, 'completed', 100),
(3, 3, 'active', 10),
(4, 3, 'dropped', 30),
(5, 3, 'active', 50),
(1, 3, 'completed', 100); -- Lỗi: UNIQUE KEY, chỉ nên có 1 bản ghi cho mỗi KH/HV.
-- SỬA LẠI ENROLLMENTS để tránh lỗi UNIQUE KEY:
-- Ghi danh 5 khóa học khác nhau cho 1 học viên (ID 3)
DELETE FROM enrollments; -- Xóa dòng lỗi trên
INSERT INTO enrollments(course_id, student_id, status, progress)
VALUES
(1, 3, 'active', 20),     -- KH 1
(2, 3, 'completed', 100),  -- KH 2
(3, 3, 'active', 10),      -- KH 3
(4, 3, 'dropped', 30),     -- KH 4
(5, 3, 'active', 50);      -- KH 5