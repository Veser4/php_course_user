CREATE USER 'php-course-app'@'%' IDENTIFIED BY 'gX5t2UUbBn';

CREATE DATABASE php_course;
GRANT ALL ON php_course.* TO 'php-course-app'@'%';

USE php_course;

CREATE TABLE post
(
  id INT UNSIGNED AUTO_INCREMENT,
  title VARCHAR(200),
  subtitle VARCHAR(200),
  content MEDIUMTEXT,
  posted_at DATETIME NOT NULL
    DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);
