# Hospital Management System (HMS)

## Overview
This is a Hospital Management System built with CodeIgniter 3 PHP framework. The system appears to be designed for managing hospital operations including patient appointments, doctor schedules, and administrative functions.

## Project Information
- **Framework**: CodeIgniter 3
- **Language**: PHP 8.2
- **Original Database**: MySQL/MariaDB (database name: `hms`)
- **Frontend**: Bootstrap-based responsive design with multiple theme options

## Current Setup Status
- ✅ PHP 8.2 installed and running
- ✅ Web server configured on port 5000
- ✅ Base URL configured for Replit environment
- ✅ Development mode enabled
- ⚠️ **Database not configured** - Requires MySQL/PostgreSQL setup

## Important Notes

### Database Setup Required
The application expects a MySQL database named `hms`. To get the application fully functional:

1. **Option 1: Use Replit PostgreSQL Database** (Recommended)
   - Click on the "Database" tool in the left sidebar
   - Create a new PostgreSQL database
   - The system will auto-configure connection variables
   - Update `application/config/database.php` to use PostgreSQL driver and environment variables

2. **Option 2: Provide MySQL Database**
   - Configure external MySQL database credentials
   - Update `application/config/database.php` with connection details
   - Import database schema (SQL file not included in repository)

### PHP Deprecation Warnings
The application shows PHP 8.2 deprecation warnings for dynamic properties. These are warnings from CodeIgniter 3 (designed for PHP 7.x) running on PHP 8.2. The application will still function but you may see deprecation notices in development mode.

## Project Structure
- `/application` - CodeIgniter application code (models, views, controllers)
- `/system` - CodeIgniter framework core
- `/backend` - Admin panel assets and plugins
- `/uploads` - User uploaded files
- `/backup` - Backup directory

## Theme Options
The system includes multiple themes:
- Material Pink
- Sky Blue
- Turquoise Blue
- White Gray

## Recent Changes (Oct 4, 2025)
- Configured for Replit environment
- Updated base_url to work with dynamic hosting
- Set to development mode for debugging
- Created .gitignore for PHP/CodeIgniter projects
- Configured PHP built-in server on port 5000

## Next Steps for Full Functionality
1. Set up database (MySQL or PostgreSQL)
2. Import database schema
3. Configure database credentials in `application/config/database.php`
4. Test all functionality with database connected
