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
* Create a database named: "contact_manager"

Run the following SQL query:

```sql
CREATE DATABASE contact_manager;
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

## Approach & Design Explanation

* **Authentication System**

  * User registration and login implemented using Core PHP.
  * Secure password storage using hashing.

* **Authorization**

  * Each user can access only their own contacts.
  * Session validation on all protected pages.

* **CRUD Operations**

  * Create contacts using a dedicated form.
  * View contacts in a tabular format.
  * Update existing contact details.
  * Delete contacts with confirmation alert.

* **Security Measures**

  * Prepared statements to prevent SQL Injection.
  * Password hashing using `password_hash()` and verification using `password_verify()`.
  * Session-based access control.

* **User Interface**

  * Simple and clean UI using HTML and CSS.
  * Dashboard with clickable cards for CRUD actions.
  * JavaScript alert for delete confirmation.

---

## Test Cases

### Authentication

* Register with valid details → Registration success message displayed
* Register with existing email → Error message displayed
* Login with valid credentials → Redirect to dashboard
* Login with invalid credentials → Error message displayed

### Contacts Management

* Add contact with valid data → Contact saved successfully
* Add contact without name or phone → Validation error shown
* View contacts → Only logged-in user’s contacts displayed
* Edit contact details → Updated successfully
* Delete contact → Confirmation alert and deletion

### Security & Session

* Access dashboard without login → Redirect to login page
* Access another user’s contact → Not permitted
* Logout → Session destroyed and redirected to login page

### UI Verification

* All dashboard cards are fully clickable
* Buttons and links function correctly
* Proper success and error messages displayed

---

## Technologies Used

* PHP (Core PHP)
* MySQL
* HTML5
* CSS3
* JavaScript
* Git & GitHub

---

## 👤 Author

**Ashutosh Prajapati**

Trainee Software Developer Applicant
