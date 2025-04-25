# 📚 Project Documentation

## 1. Project Overview

This project is a **Learning Management System (LMS) Dashboard** built using **Laravel 11.44.2** and **PHP 8.2.12**.  
The dashboard displays **courses, lessons, quizzes, and certificates** for a sample employee. It is publicly accessible (no authentication required) and designed as a web application.

### 🎯 Objectives

- Provide a user-friendly dashboard to view enrolled courses, recent lessons, upcoming quizzes, and earned certificates.
- Ensure the dashboard is accessible without login.
- Seed the database with sample data for testing.

### 🔑 Key Features

- Display list of courses with progress and completion status.
- Show recent lessons with their completion status.
- List upcoming or taken quizzes with scores.
- Display earned certificates with a placeholder for downloading PDFs.

---

## 2. Project Structure

The project follows the standard Laravel structure with additional customizations for the dashboard:

- routes/web.php: Defines web routes for the dashboard and login page.
- routes/api.php: Contains API routes (not used for the dashboard in this case).
- app/Http/Controllers/DashboardController.php: Handles the logic for displaying the dashboard.
- resources/views/layouts/app.blade.php: The main layout template with a sidebar.
- resources/views/dashboard.blade.php: The dashboard view displaying courses, lessons, quizzes, and certificates.
- database/seeders/DatabaseSeeder.php: Seeds the database with sample data.


## 3. Setup Instructions

### ✅ Prerequisites

- PHP 8.2.12 or higher  
- Composer  
- Laravel 11.44.2  
- MySQL (or any supported database)  
- Node.js and NPM (optional for assets)

### 🛠️ Steps

**Clone the Project**
```bash
git clone <repository-url>
cd laravel_test1

Install Dependencies

composer install
Configure Environment

Update .env with your database credentials

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

## Code Documentation

4.1. 🧭 Routes (routes/web.php)
GET / → Redirect to dashboard

GET /dashboard → Display dashboard

GET /login → Login placeholder (not used)


4.2. 🧠 Controller (DashboardController.php)
Handles dashboard logic:

index() → Gathers and passes data to the view

Helpers: getEmployeeCourses, getEmployeeLessons, etc.


4.3. 📄 Views
app.blade.php: Main layout with sidebar navigation (uses Bootstrap 5.3)

dashboard.blade.php:

Courses: list of enrolled courses with progress

Lessons: recent lessons with completion status

Quizzes: quizzes with scores or pending status

Certificates: earned certificates with issuance dates


4.4. 🌱 Seeder (DatabaseSeeder.php)
Seeds test data:

Employee (test@example.com)

Course: Laravel Basics

Lesson: Introduction to Laravel

Quiz: Laravel Quiz

Associations for completion and certificate display


5. Usage
Open the dashboard: http://127.0.0.1:8000/dashboard

No login required

Sample data is preloaded for testing


6. Future Improvements
Add login & auth middleware

Implement:

View details for courses

Quiz-taking functionality

PDF download for certificates (e.g., using mpdf)

RTL & Arabic support

Separate certificates table for scalability


7. Troubleshooting
❌ 404 Not Found
Ensure /dashboard exists in routes/web.php

Run: php artisan route:clear

Check: php artisan route:list

❌ View Not Found
Ensure dashboard.blade.php and app.blade.php exist

Run: php artisan view:clear

❌ Database Errors
Check .env configuration

Run: php artisan migrate && php artisan db:seed