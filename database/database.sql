CREATE DATABASE IF NOT EXISTS inventory_management_system;

USE inventory_management_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, full_name, role)
VALUES
('admin', 'admin123', 'System Administrator', 'admin'),
('staff', 'staff123', 'Staff Member', 'user');

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (category_name, description, status)
VALUES
('Electronics', 'Electronic items', 'active'),
('Stationery', 'Office stationery', 'active'),
('Furniture', 'Home and office furniture', 'inactive');

/* =========================
   Products Table
========================= */

USE inventory_management_system;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(150) NOT NULL,
    category_id INT NOT NULL,
    quantity INT DEFAULT 0,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    /* Connect product with category */
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

/* Sample product data */
INSERT INTO products
(product_name, category_id, quantity, price, description, status)
VALUES
('Dell Mouse', 1, 25, 850.00, 'Wireless optical mouse', 'active'),
('Notebook A4', 2, 100, 120.00, '200 pages notebook', 'active'),
('Office Chair', 3, 10, 5500.00, 'Comfortable office chair', 'active');