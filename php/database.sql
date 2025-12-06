-- =====================================================
-- NextStep Platform - Database Schema
-- Database: nextstep
-- =====================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS nextstep CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nextstep;

-- =====================================================
-- TABLE: users
-- Store user information (students, mentors, admins)
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'mentor', 'admin') NOT NULL DEFAULT 'student',
    major VARCHAR(120),
    skills TEXT,
    linked_in VARCHAR(255),
    profile_image VARCHAR(255),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: courses
-- Store course/course information
-- =====================================================
CREATE TABLE IF NOT EXISTS courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    category VARCHAR(100),
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    description TEXT,
    thumbnail VARCHAR(255),
    instructor_id INT,
    price DECIMAL(10,2) DEFAULT 0,
    duration_hours INT DEFAULT 0,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_courses_instructor FOREIGN KEY (instructor_id) 
        REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_courses_title (title),
    INDEX idx_courses_category (category),
    INDEX idx_courses_level (level)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: modules
-- Store course modules/lessons
-- =====================================================
CREATE TABLE IF NOT EXISTS modules (
    module_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    video_url VARCHAR(255),
    duration_minutes INT DEFAULT 0,
    position INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_modules_course FOREIGN KEY (course_id) 
        REFERENCES courses(course_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_modules_course (course_id),
    INDEX idx_modules_position (position)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: enrollments
-- Store student enrollments to courses
-- =====================================================
CREATE TABLE IF NOT EXISTS enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    progress DECIMAL(5,2) DEFAULT 0,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completion_date TIMESTAMP NULL,
    status ENUM('enrolled', 'in_progress', 'completed', 'dropped', 'ongoing') DEFAULT 'enrolled',
    CONSTRAINT fk_enrollments_user FOREIGN KEY (user_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_enrollments_course FOREIGN KEY (course_id) 
        REFERENCES courses(course_id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, course_id),
    INDEX idx_enrollments_user (user_id),
    INDEX idx_enrollments_course (course_id),
    INDEX idx_enrollments_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: assessments
-- Store assessment/quiz information
-- =====================================================
CREATE TABLE IF NOT EXISTS assessments (
    assessment_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    type ENUM('quiz', 'project', 'case_study') DEFAULT 'quiz',
    passing_score DECIMAL(5,2) DEFAULT 70.00,
    time_limit_minutes INT DEFAULT 0,
    questions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_assessments_course FOREIGN KEY (course_id) 
        REFERENCES courses(course_id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_assessments_course (course_id),
    INDEX idx_assessments_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: assessment_results
-- Store student assessment results
-- =====================================================
CREATE TABLE IF NOT EXISTS assessment_results (
    result_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    assessment_id INT NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    answers TEXT,
    time_taken_minutes INT DEFAULT 0,
    status ENUM('pending', 'passed', 'failed') DEFAULT 'pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_results_user FOREIGN KEY (user_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_results_assessment FOREIGN KEY (assessment_id) 
        REFERENCES assessments(assessment_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_results_user (user_id),
    INDEX idx_results_assessment (assessment_id),
    INDEX idx_results_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: certificates
-- Store issued certificates
-- =====================================================
CREATE TABLE IF NOT EXISTS certificates (
    certificate_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT,
    assessment_id INT,
    certificate_number VARCHAR(100) UNIQUE NOT NULL,
    issue_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expiry_date TIMESTAMP NULL,
    pdf_path VARCHAR(255),
    is_valid BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_certificates_user FOREIGN KEY (user_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_certificates_course FOREIGN KEY (course_id) 
        REFERENCES courses(course_id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_certificates_assessment FOREIGN KEY (assessment_id) 
        REFERENCES assessments(assessment_id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_certificates_user (user_id),
    INDEX idx_certificates_number (certificate_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: forums
-- Store forum categories/topics
-- =====================================================
CREATE TABLE IF NOT EXISTS forums (
    forum_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_forums_creator FOREIGN KEY (created_by) 
        REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_forums_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: forum_posts
-- Store forum posts/discussions
-- =====================================================
CREATE TABLE IF NOT EXISTS forum_posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    forum_id INT,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    views INT DEFAULT 0,
    likes INT DEFAULT 0,
    is_pinned BOOLEAN DEFAULT FALSE,
    is_locked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_posts_forum FOREIGN KEY (forum_id) 
        REFERENCES forums(forum_id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_posts_user FOREIGN KEY (user_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_posts_forum (forum_id),
    INDEX idx_posts_user (user_id),
    INDEX idx_posts_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: forum_replies
-- Store replies to forum posts
-- =====================================================
CREATE TABLE IF NOT EXISTS forum_replies (
    reply_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    likes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_replies_post FOREIGN KEY (post_id) 
        REFERENCES forum_posts(post_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_replies_user FOREIGN KEY (user_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_replies_post (post_id),
    INDEX idx_replies_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: jobs
-- Store job postings
-- =====================================================
CREATE TABLE IF NOT EXISTS jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    company_name VARCHAR(200),
    location VARCHAR(200),
    job_type ENUM('fulltime', 'parttime', 'internship', 'contract') DEFAULT 'fulltime',
    category VARCHAR(100),
    description TEXT,
    requirements TEXT,
    skills_required TEXT,
    salary_min DECIMAL(10,2),
    salary_max DECIMAL(10,2),
    application_deadline DATE,
    posted_by INT,
    is_active BOOLEAN DEFAULT TRUE,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_jobs_poster FOREIGN KEY (posted_by) 
        REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_jobs_category (category),
    INDEX idx_jobs_type (job_type),
    INDEX idx_jobs_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: job_applications
-- Store job applications from students
-- =====================================================
CREATE TABLE IF NOT EXISTS job_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    job_id INT NOT NULL,
    cover_letter TEXT,
    resume_path VARCHAR(255),
    status ENUM('pending', 'reviewed', 'shortlisted', 'rejected', 'accepted') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reviewed_at TIMESTAMP NULL,
    CONSTRAINT fk_applications_user FOREIGN KEY (user_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_applications_job FOREIGN KEY (job_id) 
        REFERENCES jobs(job_id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_application (user_id, job_id),
    INDEX idx_applications_user (user_id),
    INDEX idx_applications_job (job_id),
    INDEX idx_applications_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: mentor_sessions
-- Store mentoring sessions
-- =====================================================
CREATE TABLE IF NOT EXISTS mentor_sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    mentor_id INT NOT NULL,
    student_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    session_type ENUM('career_guidance', 'portfolio_review', 'interview_prep', 'skill_consultation') DEFAULT 'career_guidance',
    scheduled_date DATETIME NOT NULL,
    duration_minutes INT DEFAULT 60,
    meeting_link VARCHAR(255),
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_sessions_mentor FOREIGN KEY (mentor_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_sessions_student FOREIGN KEY (student_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_sessions_mentor (mentor_id),
    INDEX idx_sessions_student (student_id),
    INDEX idx_sessions_status (status),
    INDEX idx_sessions_date (scheduled_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLE: notifications
-- Store user notifications
-- =====================================================
CREATE TABLE IF NOT EXISTS notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    message TEXT,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) 
        REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_notifications_user (user_id),
    INDEX idx_notifications_read (is_read),
    INDEX idx_notifications_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERT SAMPLE DATA (Optional)
-- =====================================================

-- Insert sample admin user (password: admin123)
-- Default password hash for 'admin123'
INSERT INTO users (name, email, password, role) VALUES 
('Admin NextStep', 'admin@nextstep.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON DUPLICATE KEY UPDATE email=email;

-- Insert sample mentor user (password: mentor123)
INSERT INTO users (name, email, password, role, skills, bio) VALUES 
('Mentor Professional', 'mentor@nextstep.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mentor', 'Web Development, UI/UX Design, Career Guidance', 'Experienced mentor with 10+ years in tech industry')
ON DUPLICATE KEY UPDATE email=email;

-- Insert sample forum categories
INSERT INTO forums (title, description, category) VALUES
('General Discussion', 'General topics and discussions about NextStep platform', 'general'),
('Web Development', 'Discuss web development courses, tips, and projects', 'web_dev'),
('Career Guidance', 'Share career experiences and get advice', 'career'),
('Project Showcase', 'Show off your projects and get feedback', 'projects')
ON DUPLICATE KEY UPDATE title=title;

-- =====================================================
-- END OF DATABASE SCHEMA
-- =====================================================

-- Notes:
-- 1. Password untuk sample users: 'admin123' dan 'mentor123'
--    (Hash di atas adalah contoh, sebaiknya generate baru dengan password_hash())
-- 2. Semua password harus di-hash menggunakan password_hash() sebelum insert
-- 3. Pastikan untuk mengubah password default setelah instalasi pertama
-- 4. File ini dapat diimport langsung melalui phpMyAdmin atau command line MySQL

