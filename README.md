# 🏨 Grand Horizon - Hotel Management System (Laravel 13)

> **SETEC Institute — Final Project Exam Laravel 13**  
> **Topic 5:** Hotel Management System with Relational Database, Authentication & Advanced CRUD Filter/Search

---

## 📌 Project Overview
**Grand Horizon Hotel Management System** is an enterprise-grade hospitality operations web application built on **Laravel 13** and **MySQL**. It provides hotel staff and management with complete room inventory control, room category classification, real-time occupancy tracking, and guest reservation management.

---

## 🚀 Key Requirements Delivered (From Exam Specification)

| # | Exam Requirement | Implementation Status | Details |
|---|-------------------|------------------------|---------|
| **1** | **Login & Register Form** | ✅ Complete | Custom views at `views/login.blade.php` & `views/register.blade.php` matching exam UI |
| **2** | **Relational Database & Migrations** | ✅ Complete | `room_types` (PK `type_id`, `type_name`, `manager_id`, `location_id`) & `rooms` (FK `type_id`) & `reservations` (FK `room_id`) |
| **3** | **Data Seeding** | ✅ Complete | Realistic seeders with 6 luxury categories, 16 hotel rooms, and 7 guest bookings |
| **4** | **CRUD with Search & Filters** | ✅ Complete | Full Create, Read, Update, Delete with keyword search, category filter, status filter, and floor filter |
| **5** | **Responsive Luxury Interface** | ✅ Complete | Custom deep navy & gold luxury theme with Bootstrap 5.3 + Bootstrap Icons |
| **6** | **Database SQL Export** | ✅ Complete | Ready-to-import `hotel_management.sql` for dbForge Studio or phpMyAdmin |

---

## 🏛️ Database Architecture & Eloquent Relationships

### 1. `room_types` Table (Parent Table — analogous to *Departments*)
* **`type_id`** (BIGINT, PK, AUTO_INCREMENT)
* **`type_name`** (VARCHAR 255) — *e.g. Deluxe Suite, Executive King, Presidential Villa*
* **`manager_id`** (VARCHAR 150) — *e.g. MGR-101 (Michael Vance)*
* **`location_id`** (VARCHAR 150) — *e.g. North Tower - Floors 3-5*
* **`base_price`** (DECIMAL 10,2) — *Standard nightly base rate*
* **`capacity`** (INT) — *Max occupancy count*
* **`description`** (TEXT)
* **`created_at`**, **`updated_at`**

### 2. `rooms` Table (Child Table — analogous to *Students*)
* **`room_id`** (BIGINT, PK, AUTO_INCREMENT)
* **`room_number`** (VARCHAR 50, UNIQUE) — *e.g. 101, 201, PH-01*
* **`type_id`** (BIGINT, FK referencing `room_types.type_id` ON DELETE CASCADE)
* **`floor`** (VARCHAR 50) — *e.g. Floor 1, Floor 2, Penthouse*
* **`status`** (ENUM: `Available`, `Occupied`, `Reserved`, `Maintenance`)
* **`price_per_night`** (DECIMAL 10,2)
* **`bed_type`** (VARCHAR 100) — *e.g. 1 King Bed, 2 Twin Beds*
* **`description`** (TEXT)
* **`created_at`**, **`updated_at`**

### 3. `reservations` Table (Guest Bookings)
* **`booking_id`** (BIGINT, PK, AUTO_INCREMENT)
* **`room_id`** (BIGINT, FK referencing `rooms.room_id` ON DELETE CASCADE)
* **`guest_name`** (VARCHAR 255)
* **`guest_email`** (VARCHAR 255)
* **`guest_phone`** (VARCHAR 50)
* **`gender`** (ENUM: `Male`, `Female`, `Other`)
* **`check_in_date`** (DATE)
* **`check_out_date`** (DATE)
* **`total_nights`** (INT)
* **`total_amount`** (DECIMAL 10,2)
* **`status`** (ENUM: `Confirmed`, `Checked In`, `Checked Out`, `Cancelled`)
* **`special_requests`** (TEXT)
* **`created_at`**, **`updated_at`**

---

## 🔑 Demo Login Accounts

| Role | Email Address | Password |
|------|---------------|----------|
| **Exam Default (Slide 4/5)** | `adminwoman@gmail.com` | `password123` |
| **General Manager** | `admin@hotel.com` | `password123` |
| **Staff Admin** | `admin@example.com` | `password123` |

---

## 💻 Setup & Installation Guide

### Prerequisites
* **PHP >= 8.2** (Tested on PHP 8.3)
* **Composer >= 2.0**
* **MySQL >= 8.0** (Laragon, XAMPP, or standalone MySQL on port 3306)

### Quick Start Instructions

1. **Navigate to the Project Directory**:
   ```bash
   cd "d:\Class Project\Web\Final"
   ```

2. **Environment Configuration**:
   The `.env` file is already pre-configured for MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hotel_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Install Dependencies** (if cloning fresh):
   ```bash
   composer install
   ```

4. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start Laravel Development Server**:
   ```bash
   php artisan serve
   ```
   Open your browser at: `http://127.0.0.1:8000`

---

## 🧪 Running Automated Tests
The application includes a comprehensive PHPUnit test suite:
```bash
php artisan test
```
All 7 tests verify authentication, CRUD workflows, filtering, and foreign key integrity.

---

## 📤 How to Push to Your GitHub

Follow these simple commands in PowerShell or Git Bash:

```bash
cd "d:\Class Project\Web\Final"

# Add your GitHub remote repository link (replace with your personal repo URL)
git remote add origin https://github.com/<your-username>/<your-repo-name>.git

# Push to your main branch
git branch -M main
git push -u origin main
```

---

## 📁 Submission Package Checklist (Slide 3)
1. **Full Name:** [Your Name]
2. **Project Laravel 13 (*FileZip):** Compress this folder `Final.zip` (excluding `vendor/` or including if required)
3. **Database Dump:** `hotel_management.sql` (located in root directory)
4. **Video Record Demo:** Screen recording showing Login, CRUD operations, Search, and dbForge Studio tables
