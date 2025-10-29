# ⚡ Quick Reference - MAGNET Project

> **Cheat sheet untuk command yang sering digunakan**

---

## 🚀 Development Workflow

### Start Development Server
```bash
# Laravel server
php artisan serve
# atau
.\scripts\testing\start-server.bat

# Frontend build (development)
npm run dev

# Frontend build (production)
npm run build
```

### Database Operations
```bash
# Run migrations
php artisan migrate

# Fresh migrate + seed
php artisan migrate:fresh --seed

# Run specific seeder
php artisan db:seed --class=MahasiswaSeeder

# Rollback last migration
php artisan migrate:rollback

# Check migration status
php artisan migrate:status
```

### Clear Cache
```bash
# Clear all cache
php artisan optimize:clear

# Clear specific cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 🧪 Testing Commands

### Playwright E2E Tests
```bash
# Run all E2E tests (Chromium only - default)
npx playwright test

# Run specific test file
npx playwright test tests/e2e/mahasiswa-login-real.spec.js

# Run with UI mode (debugging)
npx playwright test --ui

# Run in headed mode (see browser)
npx playwright test --headed

# Quick script (mahasiswa login test)
.\scripts\testing\run-mahasiswa-login-test.bat
```

**Note:** Testing hanya menggunakan **Chromium** untuk menghindari masalah kompatibilitas.
Firefox, WebKit, dan Mobile testing sudah disabled di config.

### PHP Tests (Pest/PHPUnit)
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=LoginTest

# Run with coverage
php artisan test --coverage
```

---

## 🔧 Laravel Artisan Commands

### Generate Files
```bash
# Controller
php artisan make:controller MahasiswaController

# Model + Migration + Factory + Seeder
php artisan make:model Mahasiswa -mfs

# Livewire component
php artisan make:livewire mahasiswa/profile

# Migration
php artisan make:migration create_lowongan_table

# Seeder
php artisan make:seeder MahasiswaSeeder

# Request validation
php artisan make:request StoreMahasiswaRequest
```

### Livewire Commands
```bash
# Create Livewire component
php artisan make:livewire mahasiswa.dashboard

# List all components
php artisan livewire:list

# Delete component
php artisan livewire:delete mahasiswa.dashboard
```

### Routing
```bash
# List all routes
php artisan route:list

# Filter routes by name
php artisan route:list --name=mahasiswa

# Filter routes by URI
php artisan route:list --path=api
```

### Queue & Jobs
```bash
# Run queue worker
php artisan queue:work

# List failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry {id}
```

---

## 📦 Dependency Management

### Composer (PHP)
```bash
# Install dependencies
composer install

# Add package
composer require vendor/package

# Update packages
composer update

# Dump autoload
composer dump-autoload
```

### npm (Node.js)
```bash
# Install dependencies
npm install

# Add package
npm install package-name

# Add dev dependency
npm install --save-dev package-name

# Update packages
npm update

# Audit security
npm audit
```

---

## 🐛 Debugging & Logs

### View Logs
```bash
# Tail Laravel log
Get-Content storage/logs/laravel.log -Tail 50 -Wait

# Clear log file
Clear-Content storage/logs/laravel.log
```

### Debug Tools
```bash
# Laravel Tinker (REPL)
php artisan tinker

# Check environment
php artisan env

# List all Artisan commands
php artisan list
```

### Common Issues
```bash
# Fix "Class not found"
composer dump-autoload

# Fix "Mix file not found"
npm run build

# Fix permission issues (Laragon Windows)
# Run as Administrator:
icacls "storage" /grant "Users:(OI)(CI)F" /T
icacls "bootstrap\cache" /grant "Users:(OI)(CI)F" /T
```

---

## 🔍 Code Search & Navigation

### Find Files
```bash
# Search for file by name
Get-ChildItem -Recurse -Filter "*Mahasiswa*"

# Search in specific directory
Get-ChildItem -Path app/Models -Filter "*.php"
```

### Find Content
```bash
# Search in all files
Select-String -Pattern "loginAsMahasiswa" -Path .\* -Recurse

# Search in PHP files only
Select-String -Pattern "Mahasiswa" -Include *.php -Path .\app -Recurse

# Search in Blade files
Select-String -Pattern "x-slot" -Include *.blade.php -Path .\resources\views -Recurse
```

---

## 🎨 Frontend Development

### Tailwind CSS
```bash
# Watch for changes (development)
npm run dev

# Build for production (minified)
npm run build

# Check Tailwind config
npx tailwindcss --help
```

### Vite
```bash
# Development server with HMR
npm run dev

# Build production assets
npm run build

# Preview production build
npm run preview
```

---

## 🗃️ Database Queries (Tinker)

```bash
# Start Tinker
php artisan tinker

# Examples:
> App\Models\Mahasiswa::count()
> App\Models\Mahasiswa::where('nim', '6705300038')->first()
> App\Models\LowonganMagang::latest()->take(5)->get()
> DB::table('mahasiswa')->where('email', 'test@example.com')->update(['status' => 'active'])
```

---

## 🔐 Authentication

### User Management
```bash
# Create admin user (Tinker)
php artisan tinker
> App\Models\Admin::factory()->create(['email' => 'admin@magnet.com'])

# Update user password (Tinker)
> $user = App\Models\Mahasiswa::find(1)
> $user->password = Hash::make('newpassword')
> $user->save()
```

---

## 📊 Performance & Optimization

### Optimization
```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoload
composer install --optimize-autoloader --no-dev

# Clear all optimizations
php artisan optimize:clear
```

### Database Optimization
```bash
# Database backup
mysqldump -u root -p magnet > backup.sql

# Restore database
mysql -u root -p magnet < backup.sql

# Check database size
php artisan tinker
> DB::select("SELECT table_name, ROUND((data_length + index_length) / 1024 / 1024, 2) AS size_mb FROM information_schema.tables WHERE table_schema = 'magnet'")
```

---

## 🌐 Git Workflow

### Daily Commands
```bash
# Check status
git status

# Add files
git add .
git add -p  # Interactive staging

# Commit
git commit -m "feat: add mahasiswa login test"

# Push
git push origin feature/your-branch

# Pull latest
git pull origin main

# Create branch
git checkout -b feature/new-feature
```

### Undo Changes
```bash
# Unstage file
git restore --staged <file>

# Discard changes
git restore <file>

# Reset to last commit (keep changes)
git reset --soft HEAD~1

# Reset to last commit (discard changes)
git reset --hard HEAD~1
```

---

## 🆘 Emergency Commands

### Server Won't Start
```bash
# Kill process on port 8000
netstat -ano | findstr :8000
taskkill /PID <PID> /F

# Clear all cache
php artisan optimize:clear
composer dump-autoload
npm run build

# Check PHP version
php -v

# Check Laravel version
php artisan --version
```

### Database Connection Issues
```bash
# Test database connection (Tinker)
php artisan tinker
> DB::connection()->getPdo()

# Check .env file
Get-Content .env | Select-String "DB_"

# Restart Laragon MySQL
# Open Laragon > Stop All > Start All
```

### Test Failures
```bash
# Clear test database
php artisan migrate:fresh --seed --env=testing

# Run single test with debug
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug

# Check test logs
Get-Content storage/logs/laravel.log -Tail 100
```

---

## 📞 Quick Help

### Documentation Links
- **Laravel:** https://laravel.com/docs
- **Livewire:** https://livewire.laravel.com
- **Playwright:** https://playwright.dev/docs/intro
- **Tailwind CSS:** https://tailwindcss.com/docs
- **DaisyUI:** https://daisyui.com/components

### Project Documentation
- [README.md](README.md) - Main documentation
- [CONTRIBUTING.md](CONTRIBUTING.md) - Contribution guide
- [PROJECT_STRUCTURE.md](PROJECT_STRUCTURE.md) - Folder structure
- [docs/testing/README.md](docs/testing/README.md) - Testing guide

### Contact
- **Project Manager:** [Your Name]
- **Tech Lead:** [Your Name]
- **Repo:** https://github.com/your-org/magnet

---

## 💡 Pro Tips

1. **Always run `php artisan optimize:clear` after changing config files**
2. **Run `npm run build` after changing CSS/JS**
3. **Check `storage/logs/laravel.log` when errors occur**
4. **Use `php artisan tinker` for quick database queries**
5. **Run tests before pushing: `php artisan test && npx playwright test`**
6. **Create feature branches: `git checkout -b feature/your-feature`**
7. **Keep dependencies updated: `composer update && npm update`**

---

**Last Updated:** 2024-01-XX  
**Version:** 1.0.0
