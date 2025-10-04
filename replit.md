# Hospital Management System (HMS)

## Overview
This project contains a Hospital Management System with two implementations:
1. **Original CodeIgniter 3 application** (root directory)
2. **Laravel 12 migration example** (laravel-hms directory)

## Project Information

### CodeIgniter 3 (Original)
- **Framework**: CodeIgniter 3
- **Language**: PHP 8.2
- **Database**: MySQL/MariaDB (database name: `hms`)
- **Frontend**: Bootstrap-based responsive design with multiple theme options
- **Location**: Root directory (`/application`, `/system`, `/backend`)

### Laravel 12 (Migration Example)
- **Framework**: Laravel 12
- **Language**: PHP 8.2
- **Database**: MySQL (configured in `.env`)
- **Location**: `/laravel-hms/` directory
- **Purpose**: Comprehensive migration example and pattern guide

## Current Setup Status

### CodeIgniter (Original)
- ✅ PHP 8.2 installed and running
- ✅ Web server configured on port 5000
- ✅ Base URL configured for Replit environment
- ✅ Development mode enabled
- ⚠️ **Database not configured** - Requires MySQL/PostgreSQL setup

### Laravel (Migration)
- ✅ Laravel 12 installed
- ✅ Database configuration migrated to .env
- ✅ Example controllers, models, views, and routes created
- ✅ Comprehensive migration guide included
- ✅ Working examples without database dependency

## Laravel Migration Guide

### What's Included
The `/laravel-hms/` directory contains a complete migration example:

1. **Controllers** (`app/Http/Controllers/`)
   - `WelcomeController.php` - Shows CI to Laravel controller patterns

2. **Models** (`app/Models/`)
   - `Patient.php` - Demonstrates Eloquent ORM migration from CI models

3. **Views** (`resources/views/`)
   - Blade layout system (`layouts/app.blade.php`)
   - Welcome page (`welcome/index.blade.php`)
   - Appointment form (`appointment/form.blade.php`)
   - Page template (`pages/page.blade.php`)

4. **Routes** (`routes/web.php`)
   - Examples of CI route to Laravel route conversion

5. **Documentation**
   - `CODEIGNITER_TO_LARAVEL_MIGRATION_GUIDE.md` - Complete migration guide

### Migration Patterns Covered
- ✅ Controllers (CI to Laravel conversion)
- ✅ Models (Query Builder to Eloquent ORM)
- ✅ Views (PHP views to Blade templates)
- ✅ Routes (CI routes to Laravel routes)
- ✅ Form validation
- ✅ Session management
- ✅ Assets migration
- ✅ Helpers migration

### Testing the Laravel Example
```bash
cd laravel-hms
php artisan serve --host=0.0.0.0 --port=8000
```

Then visit:
- `/` - Home page
- `/appointment` - Appointment form (with validation)
- `/page/test` - Page example

## Database Setup

### For CodeIgniter (Original)
The application expects a MySQL database named `hms`:

1. **Option 1: Use Replit PostgreSQL Database** (Recommended)
   - Click on the "Database" tool in the left sidebar
   - Create a new PostgreSQL database
   - Update `application/config/database.php` to use PostgreSQL

2. **Option 2: Provide MySQL Database**
   - Configure external MySQL database credentials
   - Update `application/config/database.php` with connection details
   - Import database schema (SQL file not included in repository)

### For Laravel (Migration)
Update `/laravel-hms/.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hms
DB_USERNAME=root
DB_PASSWORD=
```

## Project Structure

### CodeIgniter Structure
```
/application      - CodeIgniter application code
  /controllers    - Controllers
  /models         - Models  
  /views          - Views
  /config         - Configuration
/system           - CI framework core
/backend          - Admin panel assets
/uploads          - User uploaded files
```

### Laravel Structure
```
/laravel-hms
  /app
    /Http/Controllers - Controllers
    /Models           - Eloquent Models
  /config             - Configuration
  /database           - Migrations & Seeders
  /resources/views    - Blade templates
  /routes             - Route definitions
  /public             - Public assets
```

## Theme Options (CodeIgniter)
- Material Pink
- Sky Blue
- Turquoise Blue
- White Gray

## PHP Deprecation Warnings
The CodeIgniter application shows PHP 8.2 deprecation warnings for dynamic properties. These are warnings from CodeIgniter 3 (designed for PHP 7.x) running on PHP 8.2. The application will still function but you may see deprecation notices in development mode.

## Recent Changes (Oct 4, 2025)

### CodeIgniter Setup
- Configured for Replit environment
- Updated base_url to work with dynamic hosting
- Set to development mode for debugging
- Created .gitignore for PHP/CodeIgniter projects
- Configured PHP built-in server on port 5000

### Laravel Migration Created
- Installed Laravel 12 with Composer
- Created example migration files (controllers, models, views, routes)
- Developed comprehensive migration guide
- Implemented working examples without database dependency
- Documented all major migration patterns

## Migration Strategy

### Recommended Approach
1. **Review the Laravel examples** in `/laravel-hms/`
2. **Read the migration guide** (`CODEIGNITER_TO_LARAVEL_MIGRATION_GUIDE.md`)
3. **Start with core models** (Patient, Appointment, Staff)
4. **Convert controllers** one by one following the patterns
5. **Migrate views** to Blade templates
6. **Update routes** using Laravel routing
7. **Test thoroughly** after each migration

### Quick Start Commands
```bash
# CodeIgniter (original)
php -S 0.0.0.0:5000 -t .

# Laravel (migration example)
cd laravel-hms && php artisan serve --host=0.0.0.0 --port=8000
```

## Next Steps

### For CodeIgniter
1. Set up database (MySQL or PostgreSQL)
2. Import database schema
3. Configure database credentials
4. Test all functionality with database connected

### For Laravel Migration
1. Review example files in `/laravel-hms/`
2. Follow migration guide for your specific needs
3. Set up database and create migrations
4. Migrate controllers, models, and views incrementally
5. Test each component as you migrate
