# UserHub - Laravel Admin & User Management System

[![GitHub Repository](https://img.shields.io/badge/GitHub-whosatyambarnwal%2FUserHub-blue?logo=github)](https://github.com/whosatyambarnwal/UserHub)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

**UserHub** is a clean, robust, and minimalist Admin & User Management Panel built with Laravel. It features multi-role authentication, soft deletes, user impersonation, activity audit logging, inline validation feedback, smart routing, and root Super Admin account protection.

🔗 **GitHub Repository**: [https://github.com/whosatyambarnwal/UserHub](https://github.com/whosatyambarnwal/UserHub)

---

## 🚀 Key Features

### 1. Authentication & Multi-Role Access Control (RBAC)
- **Separate Portals**: Dedicated authentication flows for Administrators (`/admin/login`) and Regular Users (`/login`).
- **Smart URL Redirects**:
  - Direct `/admin` URL shortcut automatically redirects to `/admin/dashboard` (if authenticated) or `/admin/login`.
  - Already logged-in users visiting `/login` or `/admin/login` are seamlessly redirected to their respective dashboard.
- **Super Administrator Protection**: Root admin account (`is_super_admin`) is strictly protected against deletion, impersonation, tampering, or password changes by other administrators.
- **Role & Status Middlewares**: Custom `IsAdmin` and `IsUser` route protection, including instant blocking of deactivated accounts.

### 2. User Management & Admin Dashboard
- **Analytics & Metrics**: Real-time summary statistics for Total Users, Active Users, Inactive Users, and Admins alongside recent activity feeds.
- **Full User CRUD**: Create, read, edit, and manage accounts with inline field-level validation and error indicators.
- **Live Search & Multi-Filters**: Instant search by Name, Email, or Mobile, with combined filtering by Role and Status.
- **Soft Deletes & Trash Management**: Safely trash accounts, view deleted records, restore accounts with one click, or perform permanent deletions.
- **Instant Status Toggle**: Activate or deactivate accounts directly from the user table without page reloads.
- **User Impersonation**: Administrators can safely impersonate any user to view the portal from their perspective, with an exit bar to return immediately.

### 3. User Portal & Self-Service Profile
- **Personal Dashboard**: Account overview and activity history.
- **Profile & Password Management**: Update personal info and change password with verification of current password and tab persistence.

### 4. Audit Logging & System Activity
- Full audit log tracking account registrations, profile updates, logins/logouts, status changes, soft/force deletes, and admin impersonations with timestamps and actor tracking.

### 5. Minimalist Light UI
- Clean, developer-friendly light theme across all layouts, sidebars, modals, tables, and pagination components.

---

## 🛠️ Technology Stack

- **Backend**: Laravel 11.x / 12.x (PHP 8.2+)
- **Database**: SQLite (Self-contained application database, zero external server configuration required) / MySQL compatible
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js, FontAwesome 6

---

## 📦 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/whosatyambarnwal/UserHub.git
   cd UserHub
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *By default, the project is configured with SQLite (`DB_CONNECTION=sqlite`), enabling instant local and cloud deployment without setting up a separate database server.*

4. **Run Migrations & Seed Database:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start the Local Development Server:**
   ```bash
   php artisan serve
   ```
   Access the application at `http://localhost:8000`.

---

## 🔑 Default Credentials

| Role | Portal URL | Name | Email | Password | Status | Notes |
|---|---|---|---|---|---|---|
| **Super Admin** | [`/admin/login`](http://localhost:8000/admin/login) | Rajesh Sharma | `admin@yopmail.com` | `password123` | **Active** | Root Super Admin (Protected) |
| **Admin** | [`/admin/login`](http://localhost:8000/admin/login) | Vikram Malhotra | `vikram.admin@yopmail.com` | `password123` | **Active** | Standard Administrator |
| **Normal User** | [`/login`](http://localhost:8000/login) | Priya Patel | `user@yopmail.com` | `password123` | **Active** | Regular User Portal |
| **Deactivated User** | [`/login`](http://localhost:8000/login) | Amit Verma | `inactive@yopmail.com` | `password123` | **Inactive** | Blocked account demonstration |

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── ActivityLogController.php
│   │   │   ├── DashboardController.php
│   │   │   └── UserController.php
│   │   ├── Auth/
│   │   │   ├── AdminAuthController.php
│   │   │   └── UserAuthController.php
│   │   └── User/
│   │       ├── DashboardController.php
│   │       └── ProfileController.php
│   └── Middleware/
│       ├── IsAdmin.php
│       └── IsUser.php
└── Models/
    ├── ActivityLog.php
    └── User.php
```

---

## 📄 License

This project is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).