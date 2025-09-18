-- Create the database if it does not already exist
CREATE DATABASE IF NOT EXISTS market_app_db;

-- Use the newly created or existing database
USE market_app_db;

-- Create the users table with basic information
-- It includes columns for nom, prenom, email, password, and timestamps
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(32) NOT NULL,
    prenom VARCHAR(32) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
