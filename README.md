# UserHub - Laravel Admin & User Management System

A robust and minimalist User & Admin Management Panel built with Laravel, featuring multi-role authentication, soft deletes, user impersonation, activity logging, and Super Admin protection.

---

## 🚀 Key Features

### 1. Authentication & Role Management
- **Separate Authentication Portals**: Distinct login flows for Administrators (`/admin/login`) and Regular Users (`/login`).
- **Role-Based Access Control (RBAC)**: Custom middlewares (`IsAdmin`, `IsUser`) enforcing route protection.
- **Super Administrator Key**: Root administrator account protected against deletion, impersonation, tampering, or password reset by other administrators.

### 2. Admin Dashboard & User Management
- **Dashboard Metrics**: Summary cards displaying total users, active/inactive counts, and admin distribution with recent activity logs.
- **Full User CRUD**: Create, read, update, and manage accounts.
- **Search & Filters**: Instant multi-field search (Name, Email, Mobile) with role and status filtering.
- **Soft Deletes & Trash Management**: Move users to trash, restore deleted records, or permanently delete accounts.
- **One-Click Status Toggle**: Instantly activate/deactivate accounts directly from the table.
- **User Impersonation**: Admin can log in as any user to inspect their interface, with a sticky exit banner to return to the admin panel.

### 3. User Portal & Profile
- **User Dashboard**: Clean personal overview with account statistics.
- **Profile & Password Management**: Self-service profile updates and password change with validation of current password.

### 4. System Audit Logs
- Comprehensive audit trail capturing user registrations, profile changes, logins, status toggles, deletions, and impersonations with IP addresses and timestamps.

---

## 🛠️ Technology Stack

- **Framework**: Laravel 11.x / 12.x
- **PHP Version**: 8.2+ (PHP 8.3 recommended)
- **Database**: SQLite (Self-contained application database, zero external database setup required) / MySQL
- **Frontend**: Blade, Tailwind CSS, Alpine.js, FontAwesome 6

---

## 📦 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <repository-url> userhub
   cd userhub
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *By default, the project uses SQLite (`DB_CONNECTION=sqlite`), making deployment instant without an external database server.*

4. **Run Database Migrations & Seeders:**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start the Development Server:**
   ```bash
   php artisan serve
   ```
   The application will be accessible at `http://localhost:8000`.

---

## 🔑 Default Credentials

| Role | Portal URL | Email | Password | Status | Notes |
|---|---|---|---|---|---|
| **Super Admin** | `/admin/login` | `admin@yopmail.com` | `password123` | Active | Root protected administrator |
| **Admin** | `/admin/login` | `vikram.admin@yopmail.com` | `password123` | Active | Standard Administrator |
| **Normal User** | `/login` | `user@yopmail.com` | `password123` | Active | Regular User portal |
| **Deactivated User** | `/login` | `inactive@yopmail.com` | `password123` | Inactive | Account blocked demo |

---

## 📁 Project Architecture

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
This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).