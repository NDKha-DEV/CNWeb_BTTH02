CREATE DATABASE onlinecourse;
USE onlinecourse;
-- bảng user
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    fullname VARCHAR(255),
    role INT DEFAULT 0,              -- 0: học viên
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	status TINYINT(1) NOT NULL DEFAULT 1
);
-- bảng categories
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- bảng course
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    description TEXT,
    instructor_id INT,            -- FK users
    category_id INT,              -- FK categories
    price DECIMAL(10,2),
    duration_weeks INT,
    level VARCHAR(50),
    image VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (instructor_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
-- bảng enrollments
CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    student_id INT,
    enrolled_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50),
    progress INT DEFAULT 0,

    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (student_id) REFERENCES users(id)
);
-- bảng lessons
CREATE TABLE lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT,
    title VARCHAR(255),
    content LONGTEXT,
    video_url VARCHAR(255),
    lesson_order INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (course_id) REFERENCES courses(id)
);
-- bảng materials
CREATE TABLE materials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    filename VARCHAR(255),
    file_path VARCHAR(255),
    file_type VARCHAR(50),
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (lesson_id) REFERENCES lessons(id)
);

