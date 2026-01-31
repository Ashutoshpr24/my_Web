# Contact Management System

## Description
This is a simple **Contact Management System** built with **PHP and MySQL**.  
It allows users to **register, login, and manage their personal contacts** with full CRUD functionality.
---

## Features
- **User Registration & Login**  
- **Secure Session Management**  
- **Add, View, Edit, Delete Contacts**  
- **User-specific data** (contacts are private to each user)  
- **Prepared Statements** for database security  
- **Responsive and Clean UI**  
- **Confirmation alerts** for deleting contacts  

---

## Database Schema

```sql
CREATE DATABASE contact_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);