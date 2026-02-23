# Leon SmartLeave System

A PHP-based web application for managing staff leave requests.

## Prerequisites

Before running the system, ensure you have the following installed:
- **XAMPP / WAMP / MAMP**: A local server environment containing Apache, MySQL, and PHP.
- **PHP 7.4+** (Recommended)
- **MySQL / MariaDB**

## Setup Instructions

### 1. Project Placement
Move the `LeaveManager` folder to your local server's web root directory:
- **XAMPP**: `C:\xampp\htdocs\LeaveManager`
- **WAMP**: `C:\wamp64\www\LeaveManager`

### 2. Database Configuration

#### Create Database
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a new database named **`leave_manager`**.

#### Create Database User
1. Go to the **User accounts** tab in phpMyAdmin.
2. Create a new user with the following details:
   - **User name**: `groupone`
   - **Host name**: `Local` (localhost)
   - **Password**: `12345678`
3. Grant **all privileges** to this user for the `leave_manager` database.

*Alternatively, you can update the credentials in `LeaveManager/connection.php` to match your existing database user.*

#### Import Schema
1. Select the `leave_manager` database in phpMyAdmin.
2. Click the **Import** tab.
3. Choose the file located at `LeaveManager/db/leave_manager.sql`.
4. Click **Go** to import the tables and sample data.

### 3. Running the Application
1. Start the **Apache** and **MySQL** services in your XAMPP/WAMP control panel.
2. Open your web browser and navigate to:
   `http://localhost/LeaveManager/index.php`

---

## 🔑 Login Credentials

### 👨‍💼 Staff (Normal User)
- **Username**: `staff`
- **Password**: `staff123`

### 🧑‍🏫 Supervisor
- **Username**: `supervisor`
- **Password**: `supervisor123`

### 🛡️ Admin
- **Navigate to**: `http://localhost/LeaveManager/admin.php`
- **Username**: `admin`
- **Password**: `admin123`

---

## 🛠️ Key Files
- `connection.php`: Database connection settings.
- `index.php`: Staff/Supervisor login and dashboard entry.
- `admin.php`: Admin login page.
- `new-request.php`: Page to submit a new leave request.
- `db/leave_manager.sql`: Database schema and initial data.
