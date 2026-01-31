# Contact Management System

A simple Contact Management System built using **PHP, MySQL, HTML, CSS**, and **JavaScript**.
This application allows users to register, log in, and perform full **CRUD operations** (Create, Read, Update, Delete) on their personal contacts.

---

## Setup Steps

Follow the steps below to run the project locally:

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/your-repo-name.git
```

### 2. Move Project to Server Directory

* Place the project folder inside:

```
xampp/htdocs/
```

### 3. Start XAMPP

* Start **Apache**
* Start **MySQL**

### 4. Create Database

* Open **phpMyAdmin**
* Create a database named:

```
contact_manager
```

### 5. Create Tables

Run the following SQL queries:

```sql
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
```

### 6. Configure Database Connection

* Open `config/db.php`
* Update credentials if required:

```php
$conn = mysqli_connect("localhost", "root", "", "contact_manager");
```

### 7. Run the Project

Open browser and visit:

```
http://localhost/your-project-folder
```

---
