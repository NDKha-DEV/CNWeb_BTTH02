USE onlinecourse;
-- categories
INSERT INTO categories(name, description) VALUES
('Programming', 'Learn coding from basic to advanced'),
('Design', 'Graphic, UI/UX design courses'),
('Marketing', 'Online marketing and branding'),
('Business', 'Business administration and startup'),
('Language', 'English, Japanese, Korean learning');
-- USERS — giảng viên + học viên + admin
INSERT INTO users(username, email, password, fullname, role) VALUES
('admin', 'admin@mail.com', '123456', 'System Admin', 2),
('teacher_a', 'teacher_a@mail.com', '123456', 'Nguyen Van A', 1),
('teacher_b', 'teacher_b@mail.com', '123456', 'Tran Thi B', 1),
('student_1', 'student1@mail.com', '123456', 'Le Duy Khoa', 0),
('student_2', 'student2@mail.com', '123456', 'Pham Minh Quan', 0),
('student_3', 'student3@mail.com', '123456', 'Hoang Gia Bao', 0),
('student_4', 'student4@mail.com', '123456', 'Vu Thanh Hai', 0);
-- COURSES — nhiều khóa học
INSERT INTO courses(title, description, instructor_id, category_id, price, duration_weeks, level, image)
VALUES
('HTML & CSS Basics', 'Learn HTML/CSS from zero', 2, 1, 19.99, 4, 'Beginner', 'htmlcss.jpg'),
('JavaScript Mastery', 'JavaScript full guide for beginners', 2, 1, 39.99, 6, 'Intermediate', 'js.jpg'),
('UI/UX Design Fundamentals', 'Design user interfaces and experience', 3, 2, 59.00, 8, 'Beginner', 'uiux.jpg'),
('Facebook Ads & Marketing', 'Learn how to run ads effectively', 3, 3, 79.99, 6, 'Advanced', 'fbads.jpg'),
('Startup & Business Model', 'How to launch startup successfully', 2, 4, 99.99, 10, 'Advanced', 'startup.jpg');
-- LESSONS — mỗi course vài bài học
INSERT INTO lessons(course_id, title, content, video_url, lesson_order)
VALUES
(1, 'Introduction to HTML', 'HTML basics...', 'video1.mp4', 1),
(1, 'Working with CSS', 'CSS basics...', 'video2.mp4', 2),
(2, 'Variables & Data Types', 'JS basics...', 'video3.mp4', 1),
(2, 'Functions in JS', 'Functions...', 'video4.mp4', 2),
(3, 'Design Principles', 'UI/UX theory...', 'video5.mp4', 1),
(4, 'Facebook Ads Setup', 'Prepare account...', 'video6.mp4', 1),
(5, 'Startup Mindset', 'Business mindset...', 'video7.mp4', 1);
-- MATERIALS — tài liệu cho mỗi bài
INSERT INTO materials(lesson_id, filename, file_path, file_type)
VALUES
(1, 'html_guide.pdf', '/files/html_guide.pdf', 'pdf'),
(2, 'css_cheatsheet.pdf', '/files/css_cheatsheet.pdf', 'pdf'),
(3, 'js_datatypes.doc', '/files/js_datatypes.doc', 'doc'),
(4, 'js_functions.ppt', '/files/js_functions.ppt', 'ppt'),
(5, 'uiux_book.pdf', '/files/uiux_book.pdf', 'pdf'),
(6, 'fbads_template.xlsx', '/files/fbads_template.xlsx', 'xlsx'),
(7, 'startup_canvas.pdf', '/files/startup_canvas.pdf', 'pdf');
-- ENROLLMENTS — nhiều học viên đăng ký
INSERT INTO enrollments(course_id, student_id, status, progress)
VALUES
(1, 4, 'active', 20),
(1, 5, 'completed', 100),
(2, 4, 'active', 10),
(2, 6, 'dropped', 30),
(3, 7, 'active', 50),
(4, 5, 'active', 15),
(5, 4, 'completed', 100),
(5, 6, 'active', 5);
