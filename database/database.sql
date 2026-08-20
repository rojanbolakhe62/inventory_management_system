CREATE DATABASE IF NOT EXISTS inventory_management_system;

USE inventory_management_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, full_name, role)
VALUES
('admin', 'admin123', 'System Administrator', 'admin'),
('staff', 'staff123', 'Staff Member', 'staff');

ALTER TABLE users
MODIFY role ENUM('admin', 'user') NOT NULL;

UPDATE users
SET role = 'user'
WHERE username = 'staff';



<!---table for catogries-->
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);