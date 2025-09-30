-- Create the database if it does not already exist
CREATE DATABASE IF NOT EXISTS market_app_db;

-- Use the newly created or existing database
USE market_app_db;

-- Create the users table with basic information
-- It includes columns for nom, prenom, email, password, and timestamps
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    verify_code VARCHAR(100) DEFAULT NULL,
    verified_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Create the email_queue table with relevant fields
CREATE TABLE email_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    to_address VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    status ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sent_at DATETIME NULL
);

-- Create the products table with detailed product information
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    product_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    product_description VARCHAR(255) DEFAULT NULL, -- courte description
    product_specification TEXT DEFAULT NULL,       -- longue description
    category ENUM('Vedettes', 'Nouveau', 'Promotionel', 'Luxe', 'Classique') NOT NULL,
    product_image VARCHAR(255) DEFAULT NULL,       -- chemin ou nom de fichier de l’image
    slug VARCHAR(191) UNIQUE,                      -- URL friendly
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);