# 📂 MAGNET - Project Structure

> **Panduan lengkap struktur folder dan file dalam project MAGNET**

---

## 🏗️ Root Directory Structure

```
MAGNET-Magang-Network-And-Tracking/
│
├── 📁 app/                      # Laravel application core
├── 📁 bootstrap/                # Laravel bootstrap files
├── 📁 config/                   # Configuration files
├── 📁 database/                 # Database migrations, seeders, factories
├── 📁 docs/                     # Project documentation
├── 📁 public/                   # Publicly accessible files
├── 📁 resources/                # Views, assets (CSS, JS)
├── 📁 routes/                   # Application routes
├── 📁 scripts/                  # Helper scripts
├── 📁 storage/                  # Logs, cache, uploaded files
├── 📁 tests/                    # Test files
├── 📁 vendor/                   # Composer dependencies (gitignored)
├── 📁 node_modules/             # npm dependencies (gitignored)
│
├── 📄 .env                      # Environment variables (gitignored)
├── 📄 .env.example              # Environment template
├── 📄 .gitignore                # Git ignore rules
├── 📄 artisan                   # Laravel CLI
├── 📄 composer.json             # PHP dependencies
├── 📄 package.json              # Node.js dependencies
├── 📄 playwright.config.js      # Playwright configuration
├── 📄 vite.config.js            # Vite build configuration
├── 📄 README.md                 # Main documentation
└── 📄 CONTRIBUTING.md           # Contribution guidelines
```

---

## 📁 Detailed Folder Structure

### `/app` - Application Logic

```
app/
├── Console/
│   ├── Commands/                # Custom Artisan commands
│   └── Kernel.php               # Console kernel
│
├── Events/                      # Event classes
│   ├── LowonganMagangCreatedOrUpdated.php
│   └── MahasiswaPreferenceUpdated.php
│
├── Exceptions/
│   └── Handler.php              # Exception handling
│
├── Helpers/                     # Helper functions
│
├── Http/
│   ├── Controllers/             # ⭐ Route controllers
│   │   ├── AdminController.php
│   │   ├── MahasiswaController.php
│   │   ├── PerusahaanController.php
│   │   └── ...
│   │
│   ├── Middleware/              # HTTP middleware
│   │   └── ...
│   │
│   └── Requests/                # Form request validation
│       └── ...
│
├── Livewire/                    # ⭐ Livewire components
│   ├── Auth/
│   │   ├── Login.php
│   │   └── Register.php
│   │
│   ├── Admin/
│   ├── Mahasiswa/
│   └── Perusahaan/
│
├── Models/                      # ⭐ Eloquent models
│   ├── Admin.php
│   ├── Mahasiswa.php
│   ├── Perusahaan.php
│   ├── LowonganMagang.php
│   └── ...
│
├── Providers/                   # Service providers
│   ├── AppServiceProvider.php
│   └── ...
│
├── Repositories/                # Repository pattern implementation
│   └── ...
│
└── Traits/                      # Reusable traits
    └── ...
```

**Key Points:**
- **Controllers:** Handle HTTP requests, delegate to services/repositories
- **Livewire:** Full-page components dengan interactivity
- **Models:** Represent database tables, relationships
- **Repositories:** Data access layer (optional pattern)

---

### `/resources` - Frontend Resources

```
resources/
├── css/
│   └── app.css                  # Main CSS (Tailwind + DaisyUI)
│
├── js/
│   ├── app.js                   # Main JavaScript entry
│   └── bootstrap.js             # Bootstrap dependencies
│
└── views/                       # ⭐ Blade templates
    ├── layouts/
    │   └── app.blade.php        # Main layout
    │
    ├── components/              # Reusable components
    │   ├── navbar.blade.php
    │   └── ...
    │
    ├── livewire/                # Livewire component views
    │   ├── auth/
    │   ├── admin/
    │   ├── mahasiswa/
    │   └── perusahaan/
    │
    ├── pages/
    │   ├── guest/               # Public pages
    │   ├── admin/               # Admin pages
    │   ├── mahasiswa/           # Student pages
    │   └── perusahaan/          # Company pages
    │
    └── welcome.blade.php        # Homepage
```

**Key Points:**
- **layouts/:** Base templates dengan `@yield` sections
- **components/:** Reusable Blade components (`<x-component>`)
- **livewire/:** Views untuk Livewire components
- **pages/:** Role-specific pages

---

### `/database` - Database Related

```
database/
├── factories/                   # Model factories for testing
│   ├── MahasiswaFactory.php
│   ├── PerusahaanFactory.php
│   └── ...
│
├── migrations/                  # ⭐ Database migrations
│   ├── 2024_01_01_create_mahasiswa_table.php
│   ├── 2024_01_02_create_perusahaan_table.php
│   └── ...
│
└── seeders/                     # ⭐ Database seeders
    ├── DatabaseSeeder.php       # Main seeder
    ├── AdminSeeder.php
    ├── MahasiswaSeeder.php
    └── ...
```

**Key Points:**
- **migrations/:** Version control untuk database schema
- **seeders/:** Populate database dengan test/initial data
- **factories/:** Generate fake data untuk testing

**Common Commands:**
```bash
# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback

# Fresh migrate + seed
php artisan migrate:fresh --seed

# Run specific seeder
php artisan db:seed --class=MahasiswaSeeder
```

---

### `/tests` - Testing Files

```
tests/
├── e2e/                         # ⭐ Playwright E2E tests
│   ├── mahasiswa-login-real.spec.js
│   ├── homepage.spec.js
│   ├── auth.spec.js
│   ├── helpers.js               # Test helper functions
│   └── ...
│
├── Feature/                     # Laravel feature tests
│   ├── ExampleTest.php
│   └── ...
│
├── Unit/                        # Unit tests
│   ├── ExampleTest.php
│   └── ...
│
├── CreatesApplication.php
├── Pest.php                     # Pest PHP configuration
└── TestCase.php                 # Base test case
```

**Key Points:**
- **e2e/:** Browser automation tests dengan Playwright
- **Feature/:** Test application features (HTTP tests)
- **Unit/:** Test individual classes/methods

---

### `/routes` - Application Routes

```
routes/
├── web.php                      # ⭐ Web routes (Livewire, Blade)
├── api.php                      # API routes (JSON responses)
├── auth.php                     # Authentication routes
├── channels.php                 # Broadcasting channels
└── console.php                  # Artisan commands
```

**Example `web.php`:**
```php
Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

---

### `/public` - Public Assets

```
public/
├── index.php                    # Entry point
├── robots.txt
├── sitemap.xml
│
├── build/                       # ⭐ Compiled assets (Vite)
│   ├── assets/
│   │   ├── app-xxx.css
│   │   ├── app-xxx.js
│   │   └── ...
│   └── manifest.json
│
└── img/                         # Public images
    └── ...
```

**Key Points:**
- **build/:** Generated by `npm run build`, gitignored
- **img/:** Store public images yang tidak di-build
- Semua file di sini accessible via URL: `http://domain.com/file.ext`

---

### `/storage` - Application Storage

```
storage/
├── app/                         # Application files
│   ├── public/                  # Publicly accessible files
│   └── ...
│
├── framework/                   # Framework cache, sessions, views
│   ├── cache/
│   ├── sessions/
│   └── views/
│
└── logs/                        # ⭐ Log files
    └── laravel.log              # Application logs
```

**Key Points:**
- **logs/laravel.log:** Check untuk debugging errors
- **app/public/:** Linked ke `/public/storage` via `php artisan storage:link`

---

### `/config` - Configuration Files

```
config/
├── app.php                      # Application configuration
├── auth.php                     # Authentication configuration
├── database.php                 # Database connections
├── filesystems.php              # File storage
├── queue.php                    # Queue configuration
├── recommendation-system.php    # ⭐ Custom: DSS configuration
└── ...
```

**Key Points:**
- Config values accessible via `config('file.key')`
- Environment-specific values use `env('KEY', 'default')`

---

### `/docs` - Documentation

```
docs/
├── testing/                     # ⭐ Testing documentation
│   ├── README.md                # Testing guide
│   └── PLAYWRIGHT_TESTING.md
│
├── class-diagram/               # UML class diagrams
├── sequence-diagram/            # UML sequence diagrams
├── deployment-diagram/          # Deployment diagrams
└── web-preview/                 # Website screenshots
```

---

### `/scripts` - Helper Scripts

```
scripts/
├── testing/                     # ⭐ Testing helper scripts
│   ├── run-mahasiswa-login-test.bat
│   ├── start-server.bat
│   ├── setup-laragon.ps1
│   └── ...
│
└── data-converter.py            # Data processing scripts
```

**Usage:**
```bash
# Windows
.\scripts\testing\run-mahasiswa-login-test.bat

# PowerShell
.\scripts\testing\setup-laragon.ps1
```

---

## 🔑 Key Files Explained

### `composer.json`
PHP dependencies dan autoloading configuration.

```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^11.0",
    "livewire/livewire": "^3.0"
  }
}
```

### `package.json`
Node.js dependencies dan build scripts.

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  },
  "devDependencies": {
    "@playwright/test": "^1.40.0",
    "tailwindcss": "^4.1.0",
    "daisyui": "^5.0.0"
  }
}
```

### `vite.config.js`
Frontend build configuration (Vite).

### `playwright.config.js`
Playwright E2E test configuration.

### `.env`
Environment variables (DATABASE, APP_KEY, etc).

---

## 📊 File Count Summary

- **PHP Files:** ~200+ files
- **Blade Templates:** ~50+ files
- **JavaScript Files:** ~10+ files
- **Test Files:** ~15+ files
- **Migration Files:** ~20+ files

---

## 🎯 Most Important Directories for Development

### **Backend Development:**
1. `app/Http/Controllers/` - Add new controllers
2. `app/Models/` - Add new models
3. `app/Livewire/` - Add Livewire components
4. `database/migrations/` - Create database tables
5. `routes/web.php` - Define routes

### **Frontend Development:**
1. `resources/views/` - Create Blade templates
2. `resources/css/app.css` - Styling
3. `resources/js/` - JavaScript logic
4. `public/img/` - Static images

### **Testing:**
1. `tests/e2e/` - E2E tests
2. `tests/Feature/` - Feature tests
3. `tests/Unit/` - Unit tests

---

## 🚀 Quick Navigation Tips

### Find a Feature:
```bash
# Search for "login" in all PHP files
grep -r "login" app/

# Find Livewire component
grep -r "class Login" app/Livewire/

# Find route
grep "login" routes/web.php
```

### Find a View:
```bash
# Search for blade file
find resources/views -name "*login*"

# Search content in views
grep -r "Login Form" resources/views/
```

---

## 📚 Additional Resources

- **[Laravel Structure](https://laravel.com/docs/structure)** - Official Laravel structure docs
- **[Livewire Structure](https://livewire.laravel.com/)** - Livewire component organization
- **[Testing Guide](docs/testing/README.md)** - Testing documentation

---

**Need help navigating the codebase? Check [CONTRIBUTING.md](CONTRIBUTING.md)!**
