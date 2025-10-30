# TailAdmin Template

Modern Laravel admin template with JavaScript-based authentication system. Built with TailAdmin design and MVC architecture.

## Features

- ✅ **JavaScript/AJAX Authentication** - All authentication uses JavaScript/AJAX instead of traditional PHP POST
- ✅ **Multi-Database Support** - Works with MySQL, PostgreSQL, SQLite, SQL Server, and all Laravel-supported databases
- ✅ **MVC Architecture** - Clean Model-View-Controller structure
- ✅ **Modern UI** - Clean and responsive TailAdmin design
- ✅ **Easy to Debug** - JavaScript-based requests make debugging easier
- ✅ **Web App Experience** - Feels like a modern single-page application

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

### 7. Start development server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Project Structure

```
TailAdminTemplate/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   └── AuthController.php      # Authentication logic
│   │       └── DashboardController.php     # Dashboard logic
│   └── Models/
│       └── User.php                        # User model
├── config/
│   ├── app.php                            # Application configuration
│   ├── auth.php                           # Authentication configuration
│   └── database.php                       # Database configuration
├── database/
│   └── migrations/
│       └── create_users_table.php         # Users table migration
├── public/
│   ├── assets/
│   │   ├── css/
│   │   │   └── tailadmin.css             # TailAdmin styles
│   │   └── js/
│   │       └── auth.js                   # JavaScript authentication
│   └── index.php                         # Entry point
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php           # Login page
│       │   ├── register.blade.php        # Registration page
│       │   └── forgot-password.blade.php # Forgot password page
│       ├── layouts/
│       │   ├── app.blade.php             # Main layout
│       │   └── dashboard.blade.php       # Dashboard layout
│       ├── dashboard.blade.php           # Dashboard page
│       └── profile.blade.php             # Profile page
└── routes/
    ├── web.php                           # Web routes
    └── api.php                           # API routes
```

## Authentication System

### How It Works

1. **Frontend (JavaScript)**:
   - Forms submit via JavaScript/AJAX (no traditional POST)
   - Uses `auth.js` class for all authentication requests
   - Provides real-time validation and error handling
   - Shows loading states and notifications

2. **Backend (Laravel)**:
   - API routes handle authentication logic
   - Returns JSON responses
   - Uses Laravel's built-in authentication
   - Works with any Laravel-supported database

### Available API Endpoints

```
POST   /api/auth/login              - User login
POST   /api/auth/register           - User registration
POST   /api/auth/logout             - User logout
POST   /api/auth/forgot-password    - Forgot password
GET    /api/auth/user               - Get current user (protected)
PUT    /api/auth/update-profile     - Update user profile (protected)
```

### JavaScript Authentication Manager

The `AuthManager` class in `/public/assets/js/auth.js` provides:

- `login(formData)` - Handle login
- `register(formData)` - Handle registration
- `logout()` - Handle logout
- `forgotPassword(formData)` - Handle forgot password
- `getUser()` - Get current user
- `updateProfile(formData)` - Update user profile
- `showErrors(errors, formId)` - Display validation errors
- `showNotification(message, type)` - Show notifications

### Example Usage

```javascript
// Login example
const formData = {
    email: 'user@example.com',
    password: 'password123',
    remember: true
};

try {
    const response = await auth.login(formData);
    if (response.success) {
        window.location.href = response.redirect;
    }
} catch (error) {
    auth.showErrors(error.errors, 'loginForm');
    auth.showNotification(error.message, 'error');
}
```

## Database Support

This template supports all Laravel-compatible databases:

### MySQL
- Most popular choice
- Good performance
- Wide support

### PostgreSQL
- Advanced features
- Great for complex queries
- ACID compliant

### SQLite
- File-based database
- Perfect for development
- No server required

### SQL Server
- Enterprise-grade
- Windows integration
- Advanced features

## Customization

### Changing Styles

Edit `/public/assets/css/tailadmin.css` to customize the design.

### Adding New Pages

1. Create controller in `app/Http/Controllers/`
2. Add route in `routes/web.php`
3. Create view in `resources/views/`

### Adding Authentication Logic

Edit `app/Http/Controllers/Auth/AuthController.php` to add custom authentication logic.

## Security Features

- ✅ CSRF protection on all API requests
- ✅ Password hashing with bcrypt
- ✅ Session-based authentication
- ✅ Input validation
- ✅ SQL injection protection (Eloquent ORM)
- ✅ XSS protection

## Development Tips

### Debugging AJAX Requests

Open browser developer tools (F12) and check:
- **Network tab** - See all AJAX requests and responses
- **Console tab** - View JavaScript errors and logs

### Common Issues

**Problem**: "CSRF token mismatch"
**Solution**: Make sure you have `<meta name="csrf-token" content="{{ csrf_token() }}">` in your layout

**Problem**: "Class not found"
**Solution**: Run `composer dump-autoload`

**Problem**: "Database connection error"
**Solution**: Check your `.env` file and verify database credentials

## License

MIT License - Feel free to use this template for your projects.

## Support

For issues and questions, please create an issue on GitHub.

---

**Built with ❤️ using Laravel and TailAdmin**
