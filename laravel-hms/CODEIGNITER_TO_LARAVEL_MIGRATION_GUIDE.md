# CodeIgniter to Laravel Migration Guide
## Hospital Management System (HMS) Conversion

This guide provides practical examples and patterns for migrating the CodeIgniter 3 HMS project to Laravel 12.

---

## Table of Contents
1. [Project Structure Mapping](#project-structure-mapping)
2. [Database Configuration](#database-configuration)
3. [Routes Migration](#routes-migration)
4. [Controllers Migration](#controllers-migration)
5. [Models Migration](#models-migration)
6. [Views Migration](#views-migration)
7. [Assets Migration](#assets-migration)
8. [Helpers Migration](#helpers-migration)
9. [Form Validation](#form-validation)
10. [Session Management](#session-management)

---

## 1. Project Structure Mapping

### CodeIgniter Structure
```
/application
  /config        → Configuration files
  /controllers   → Controllers
  /models        → Models
  /views         → Views
  /helpers       → Helper functions
  /libraries     → Custom libraries
/system          → CI framework core
/backend         → Assets (CSS, JS, images)
```

### Laravel Structure
```
/app
  /Http
    /Controllers → Controllers
  /Models        → Eloquent Models
/config          → Configuration files
/database
  /migrations    → Database migrations
/resources
  /views         → Blade templates
/public          → Public assets (CSS, JS, images)
/routes          → Route definitions
```

---

## 2. Database Configuration

### CodeIgniter (`application/config/database.php`)
```php
$db['default'] = array(
    'hostname' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'database' => 'hms',
    'dbdriver' => 'mysqli',
);
```

### Laravel (`.env`)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hms
DB_USERNAME=root
DB_PASSWORD=
```

---

## 3. Routes Migration

### CodeIgniter (`application/config/routes.php`)
```php
$route['default_controller'] = 'welcome/index';
$route['page/(:any)'] = 'welcome/page/$1';
$route['form/appointment'] = 'welcome/appointment';
$route['user/resetpassword/([a-z]+)/(:any)'] = 'site/resetpassword/$1/$2';
```

### Laravel (`routes/web.php`)
```php
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SiteController;

// Home route
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Page routes
Route::get('/page/{slug}', [WelcomeController::class, 'page'])->name('page.show');

// Appointment routes
Route::get('/appointment', [WelcomeController::class, 'showAppointmentForm'])->name('appointment.form');
Route::post('/appointment', [WelcomeController::class, 'storeAppointment'])->name('appointment.store');

// Password reset
Route::get('/user/resetpassword/{type}/{token}', [SiteController::class, 'resetPassword'])->name('password.reset');

// Admin routes (with auth middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('patients', PatientController::class);
});
```

**Key Differences:**
- Laravel uses named routes for better maintainability
- Middleware for authentication/authorization
- Resource controllers for CRUD operations
- Route grouping for common prefixes/middleware

---

## 4. Controllers Migration

### CodeIgniter Controller
```php
class Welcome extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('patient_model');
        $this->load->helper('url');
        $this->load->library('session');
    }
    
    public function index() {
        $data['patients'] = $this->patient_model->get_all();
        $this->load->view('welcome', $data);
    }
    
    public function page($slug) {
        $data['page'] = $this->cms_page_model->getBySlug($slug);
        if (!$data['page']) {
            show_404();
        }
        $this->load->view('page', $data);
    }
}
```

### Laravel Controller
```php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class WelcomeController extends Controller {
    
    public function index() {
        $patients = Patient::all();
        return view('welcome.index', compact('patients'));
    }
    
    public function page($slug) {
        $page = CmsPage::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }
}
```

**Key Differences:**
- No need to manually load models (use `use` statements)
- Helpers and services auto-loaded or dependency injected
- `return view()` instead of `$this->load->view()`
- `compact()` or array for passing data
- `firstOrFail()` automatically handles 404

---

## 5. Models Migration

### CodeIgniter Model
```php
class Patient_model extends CI_Model {
    
    public function get_all() {
        return $this->db->get('patients')->result();
    }
    
    public function get($id) {
        return $this->db->get_where('patients', ['id' => $id])->row();
    }
    
    public function add($data) {
        $this->db->insert('patients', $data);
        return $this->db->insert_id();
    }
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('patients', $data);
    }
    
    public function delete($id) {
        $this->db->delete('patients', ['id' => $id]);
    }
    
    public function getWithAppointments($id) {
        $this->db->select('patients.*, appointments.*');
        $this->db->from('patients');
        $this->db->join('appointments', 'patients.id = appointments.patient_id');
        $this->db->where('patients.id', $id);
        return $this->db->get()->result();
    }
}
```

### Laravel Eloquent Model
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model {
    use SoftDeletes;
    
    protected $fillable = [
        'patient_name', 'age', 'gender', 'phone', 'email', 'address'
    ];
    
    protected $casts = [
        'admission_date' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    // Relationships (replaces complex joins)
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
    
    public function opdDetails() {
        return $this->hasMany(OpdDetail::class);
    }
    
    // Scopes (reusable queries)
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
    
    // Accessors (computed attributes)
    public function getFullNameAttribute() {
        return "{$this->patient_name} ({$this->patient_unique_id})";
    }
}

// Usage Examples:
// Get all: Patient::all();
// Get one: Patient::find($id);
// Create: Patient::create($data);
// Update: $patient->update($data);
// Delete: $patient->delete();
// With relations: Patient::with('appointments')->find($id);
// Scopes: Patient::active()->get();
// Accessor: $patient->full_name;
```

**Key Advantages:**
- Automatic CRUD operations
- Built-in relationships (no manual joins)
- Query scopes for reusability
- Accessors/Mutators for data transformation
- Soft deletes built-in

---

## 6. Views Migration

### CodeIgniter View (`application/views/welcome.php`)
```php
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
</head>
<body>
    <?php $this->load->view('header'); ?>
    
    <h1><?php echo $heading; ?></h1>
    
    <?php if (!empty($patients)): ?>
        <ul>
            <?php foreach ($patients as $patient): ?>
                <li><?php echo $patient->name; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No patients found.</p>
    <?php endif; ?>
    
    <?php $this->load->view('footer'); ?>
</body>
</html>
```

### Laravel Blade Template (`resources/views/welcome/index.blade.php`)
```blade
@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $heading }}</h1>
    
    @if($patients->count())
        <ul>
            @foreach($patients as $patient)
                <li>{{ $patient->name }}</li>
            @endforeach
        </ul>
    @else
        <p>No patients found.</p>
    @endif
@endsection
```

### Laravel Layout (`resources/views/layouts/app.blade.php`)
```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - HMS</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.partials.footer')
    
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
```

**Blade Directives:**
- `{{ }}` - Echo escaped content (safe)
- `{!! !!}` - Echo raw HTML (unescaped)
- `@if`, `@foreach`, `@while` - Control structures
- `@extends` - Extend layout
- `@section`, `@yield` - Define/output sections
- `@include` - Include partial
- `@auth`, `@guest` - Authentication checks
- `@csrf` - CSRF token
- `@method` - HTTP method spoofing

---

## 7. Assets Migration

### CodeIgniter
```html
<link href="<?php echo base_url('backend/themes/material_pink/css/style.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('backend/js/jquery.min.js'); ?>"></script>
```

### Laravel
```blade
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.min.js') }}"></script>

{{-- Or use Vite for modern asset bundling --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

**Migration Steps:**
1. Move `/backend/` assets to `/public/` in Laravel
2. Update paths in views to use `{{ asset() }}`
3. Consider using Laravel Mix or Vite for compilation

---

## 8. Helpers Migration

### CodeIgniter (`application/helpers/custom_helper.php`)
```php
if (!function_exists('format_date')) {
    function format_date($date) {
        return date('d-m-Y', strtotime($date));
    }
}
```

### Laravel

**Option 1: Create Helper File**
1. Create `app/Helpers/helpers.php`
2. Add to `composer.json`:
```json
"autoload": {
    "files": [
        "app/Helpers/helpers.php"
    ]
}
```
3. Run: `composer dump-autoload`

**Option 2: Use Service Class**
```php
// app/Services/DateService.php
namespace App\Services;

class DateService {
    public static function format($date) {
        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }
}

// Usage
use App\Services\DateService;
DateService::format($date);
```

---

## 9. Form Validation

### CodeIgniter
```php
$this->load->library('form_validation');
$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
$this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');

if ($this->form_validation->run() == FALSE) {
    $this->load->view('form');
} else {
    // Process form
}
```

### Laravel
```php
public function store(Request $request) {
    $validated = $request->validate([
        'email' => 'required|email',
        'name' => 'required|min:3',
    ]);
    
    // Process form with $validated data
}

// Display errors in Blade
@error('email')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
```

---

## 10. Session Management

### CodeIgniter
```php
// Set session
$this->session->set_userdata('user_id', $user->id);

// Get session
$user_id = $this->session->userdata('user_id');

// Check session
if ($this->session->userdata('logged_in')) {
    // User is logged in
}

// Destroy session
$this->session->sess_destroy();
```

### Laravel
```php
// Set session
session(['user_id' => $user->id]);
// or
$request->session()->put('user_id', $user->id);

// Get session
$user_id = session('user_id');
// or
$request->session()->get('user_id');

// Check session
if (session()->has('logged_in')) {
    // User is logged in
}

// Laravel Auth (preferred for user authentication)
auth()->check(); // Check if authenticated
auth()->user(); // Get current user
auth()->id(); // Get current user ID
auth()->login($user); // Log user in
auth()->logout(); // Log user out
```

---

## Migration Strategy

### Recommended Approach:

1. **Setup Laravel Project** ✓
   - Install Laravel
   - Configure database
   - Set up .env

2. **Database Migration**
   - Create migrations from existing schema
   - Or use existing database

3. **Create Models**
   - Start with core models (Patient, Appointment, Staff)
   - Define relationships
   - Add scopes and accessors

4. **Convert Routes**
   - Map CI routes to Laravel routes
   - Use route groups and middleware

5. **Migrate Controllers**
   - Start with main controllers
   - Convert to Laravel patterns
   - Implement validation

6. **Convert Views**
   - Create Blade layouts
   - Convert views one by one
   - Use Blade directives

7. **Move Assets**
   - Copy to `/public`
   - Update paths

8. **Test Thoroughly**
   - Test each feature
   - Fix bugs
   - Optimize queries

---

## Next Steps

1. Review the example files created:
   - `app/Http/Controllers/WelcomeController.php`
   - `app/Models/Patient.php`
   - `resources/views/welcome/index.blade.php`
   - `resources/views/layouts/app.blade.php`

2. Use these as templates for migrating other components

3. Consider using Laravel's built-in features:
   - Authentication scaffolding
   - API resources
   - Job queues
   - Broadcasting
   - Notifications

4. Leverage Laravel packages for common functionality

---

## Useful Laravel Commands

```bash
# Create controller
php artisan make:controller PatientController

# Create model
php artisan make:model Patient

# Create migration
php artisan make:migration create_patients_table

# Create everything at once
php artisan make:model Patient -mcr
# -m: migration, -c: controller, -r: resource controller

# Run migrations
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Start development server
php artisan serve
```

---

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laracasts](https://laracasts.com) - Video tutorials
- [Laravel News](https://laravel-news.com)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
