# TailAdmin Template - GL System Edition

Modern Laravel admin template with fetch API-based authentication, department-based permissions, and sticky notes feature. Inspired by GL Dashboard architecture with flexible database support.

## Features

- ✅ **Fetch API Authentication** - All authentication uses modern fetch API instead of traditional PHP POST
- ✅ **Department-Based Permissions** - Hierarchical permission system (Admin → User-specific → Department → Deny)
- ✅ **Dynamic Menu System** - Hierarchical menu with parent-child relationships
- ✅ **Sticky Notes** - Drag-and-drop, resizable notes with auto-save (6 colors available)
- ✅ **Multi-Database Support** - Works with MySQL, PostgreSQL, SQLite, SQL Server (single database, no forced PostgreSQL)
- ✅ **MVC Architecture** - Clean Model-View-Controller structure
- ✅ **Modern UI** - Clean and responsive TailAdmin design
- ✅ **User Tracking** - All records track who created/updated them
- ✅ **Activity Logs** - Audit trail for user actions

## Database Structure

### Core Tables

1. **sys_departments** - Department/groups for organizing users and permissions
2. **sys_users** - System users with department assignment
3. **sys_menus** - Hierarchical menu structure with sticky note support
4. **sys_department_menu_permissions** - Department-level permissions
5. **sys_user_menu_permissions** - User-specific permission overrides
6. **sys_sticky_notes** - User sticky notes (drag-drop, resize, 6 colors)
7. **sys_companies** - Multi-company database configurations (optional)
8. **sys_user_company_access** - User-company access control
9. **sys_activity_logs** - Audit trail

### Permission System

**Evaluation Priority (Highest to Lowest)**:
1. Admin Override (`admin@local` has full access)
2. User-Specific Permissions (`sys_user_menu_permissions`)
3. Department Permissions (`sys_department_menu_permissions`)
4. Deny by Default

**Granular Permissions**:
- `can_view` - View access
- `can_create` - Create records
- `can_update` - Update records
- `can_delete` - Delete records
- `can_export` - Export data
- `can_approve` - Approve actions

## Requirements

- PHP >= 8.1
- Composer
- Database (MySQL, PostgreSQL, SQLite, or SQL Server)

## Installation

### 1. Clone the repository

```bash
git clone <your-repo-url>
cd TailAdminTemplate
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

### 4. Set up your database

Edit `.env` file and configure your database connection:

#### For MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tailadmin
DB_USERNAME=root
DB_PASSWORD=
```

#### For PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tailadmin
DB_USERNAME=postgres
DB_PASSWORD=
```

#### For SQLite:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

#### For SQL Server:
```env
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=tailadmin
DB_USERNAME=sa
DB_PASSWORD=
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Seed the database

```bash
php artisan db:seed
```

This will create:
- Default departments (system, finance, hr, sales)
- Default menus (dashboard, admin panel with sub-menus)
- Admin user (`admin@local` / `password`)
- Test user (`test@example.com` / `password`)

### 8. Start development server

```bash
php artisan serve
```

Visit `http://localhost:8000` and login with `admin@local` / `password`

## Project Structure

```
TailAdminTemplate/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/
│   │   │   └── AuthController.php         # Authentication logic
│   │   ├── Admin/                         # Admin controllers (future)
│   │   ├── DashboardController.php
│   │   └── StickyNoteController.php       # Sticky notes API
│   └── Models/
│       ├── User.php                       # User model (sys_users)
│       ├── Department.php                 # Department model
│       ├── Menu.php                       # Menu model
│       ├── DepartmentMenuPermission.php   # Dept permissions
│       ├── UserMenuPermission.php         # User permissions
│       ├── StickyNote.php                 # Sticky notes
│       ├── Company.php                    # Companies (optional)
│       └── ActivityLog.php                # Activity logs
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_sys_departments_table.php
│   │   ├── 2024_01_01_000002_create_sys_users_table.php
│   │   ├── 2024_01_01_000003_create_sys_menus_table.php
│   │   ├── 2024_01_01_000004_create_sys_permission_tables.php
│   │   ├── 2024_01_01_000005_create_sys_companies_table.php
│   │   ├── 2024_01_01_000006_create_sys_user_company_access_table.php
│   │   ├── 2024_01_01_000007_create_sys_sticky_notes_table.php
│   │   ├── 2024_01_01_000008_create_sys_activity_logs_table.php
│   │   └── 2024_01_01_000009_create_laravel_infrastructure_tables.php
│   └── seeders/
│       ├── DepartmentSeeder.php
│       ├── MenuSeeder.php
│       ├── UserSeeder.php
│       └── DatabaseSeeder.php
├── public/
│   └── assets/
│       ├── css/
│       │   └── tailadmin.css              # TailAdmin styles
│       └── js/
│           └── auth.js                    # Fetch API authentication
├── resources/views/
│   ├── auth/                              # Authentication pages
│   ├── layouts/                           # Layouts
│   ├── dashboard.blade.php
│   └── profile.blade.php
└── routes/
    ├── web.php                            # Web routes
    └── api.php                            # API routes (auth + sticky notes)
```

## Authentication System

### Fetch API Manager

The `AuthManager` class in `/public/assets/js/auth.js` provides:

```javascript
// Available methods
auth.login(formData)              // Login
auth.register(formData)           // Register
auth.logout()                     // Logout
auth.forgotPassword(formData)     // Forgot password
auth.getUser()                    // Get current user
auth.updateProfile(formData)      // Update profile
auth.showErrors(errors, formId)   // Display errors
auth.showNotification(msg, type)  // Show notifications
```

### API Endpoints

#### Authentication
```
POST   /api/auth/login              - User login
POST   /api/auth/register           - User registration
POST   /api/auth/logout             - User logout
POST   /api/auth/forgot-password    - Forgot password
GET    /api/auth/user               - Get current user (protected)
PUT    /api/auth/update-profile     - Update user profile (protected)
```

#### Sticky Notes
```
GET    /api/sticky-notes            - List user's notes for menu/company
POST   /api/sticky-notes            - Create new note
PUT    /api/sticky-notes/{id}       - Update note
DELETE /api/sticky-notes/{id}       - Soft delete note (move to trash)
POST   /api/sticky-notes/{id}/restore - Restore deleted note
POST   /api/sticky-notes/bulk-update  - Bulk update positions
```

## Usage Examples

### Check User Permission

```php
// In controller
if (!$user->hasMenuPermission('admin.users', 'can_create')) {
    return response()->json(['error' => 'Unauthorized'], 403);
}

// Check by menu ID
if ($user->hasMenuPermission($menuId, 'can_view')) {
    // Show content
}
```

### Create Sticky Note

```javascript
// JavaScript fetch example
const noteData = {
    menu_id: 1,
    company_id: null,
    content: 'My note content',
    color: 'yellow',
    position_x: 100,
    position_y: 100,
    width: 300,
    height: 180
};

const response = await fetch('/api/sticky-notes', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(noteData)
});

const result = await response.json();
```

### Query Menus with Permissions

```php
// Get all root menus with children
$menus = Menu::roots()
    ->active()
    ->with('children')
    ->get();

// Get department menus
$menus = Menu::where('department_id', $deptId)
    ->active()
    ->get();
```

## Key Differences from GL Dashboard

| Feature | GL Dashboard | TailAdmin Template |
|---------|--------------|-------------------|
| Database | Dual (PostgreSQL + SQL Server) | Single (any Laravel-supported) |
| Connection | Forced PostgreSQL for system | Flexible (user chooses) |
| Company Switching | Dynamic DB connection switching | Optional, no forced switching |
| Cheque System | Included | Not included |
| Trial Balance | Included | Not included |
| Views | Livewire + Volt | Blade + Fetch API |
| Frontend | AJAX (mixed) | Fetch API (consistent) |

## Security Features

- ✅ CSRF protection on all API requests
- ✅ Password hashing with bcrypt
- ✅ Session-based authentication
- ✅ Input validation
- ✅ SQL injection protection (Eloquent ORM)
- ✅ XSS protection
- ✅ Soft delete for sticky notes
- ✅ User-specific data isolation

## Development Tips

### Debugging Fetch Requests

Open browser developer tools (F12) and check:
- **Network tab** - See all fetch requests and responses
- **Console tab** - View JavaScript errors and logs

### Adding New Menu

```php
Menu::create([
    'key' => 'reports',
    'label' => 'รายงาน',
    'icon' => 'file',
    'route' => 'reports.index',
    'parent_id' => null,
    'sort_order' => 10,
    'department_id' => $deptId,
    'is_active' => true,
    'is_system' => false,
    'has_sticky_note' => true,
]);
```

### Setting Department Permissions

```php
DepartmentMenuPermission::create([
    'department_id' => $deptId,
    'menu_id' => $menuId,
    'can_view' => true,
    'can_create' => true,
    'can_update' => true,
    'can_delete' => false,
    'can_export' => true,
    'can_approve' => false,
]);
```

## Common Issues

**Problem**: "CSRF token mismatch"
**Solution**: Make sure you have `<meta name="csrf-token" content="{{ csrf_token() }}">` in your layout

**Problem**: "Class not found"
**Solution**: Run `composer dump-autoload`

**Problem**: "Database connection error"
**Solution**: Check your `.env` file and verify database credentials

**Problem**: "Sticky notes not saving"
**Solution**: Check that the menu has `has_sticky_note = true` and user has `can_view` permission

## License

MIT License - Feel free to use this template for your projects.

## Credits

- Inspired by [GL Dashboard](https://github.com/realzkupti/gl) architecture
- Based on TailAdmin design
- Built with Laravel 11

---

**Built with ❤️ using Laravel, TailAdmin, and Fetch API**
