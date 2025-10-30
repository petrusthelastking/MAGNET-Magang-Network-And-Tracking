# 🚀 Development Setup Guide - MAGNET Project

Panduan lengkap untuk setup development environment di laptop baru.

---

## 📋 Table of Contents
1. [Prerequisites](#prerequisites)
2. [Software yang Dibutuhkan](#software-yang-dibutuhkan)
3. [Clone Repository](#clone-repository)
4. [Setup Laravel](#setup-laravel)
5. [Setup Database](#setup-database)
6. [Setup Testing (Playwright)](#setup-testing-playwright)
7. [Running Project](#running-project)
8. [Troubleshooting](#troubleshooting)

---

## 📦 Prerequisites

### Minimum Requirements:
- **OS:** Windows 10/11, macOS, atau Linux
- **RAM:** 8GB (16GB recommended)
- **Storage:** 5GB free space
- **Internet:** Untuk download dependencies

---

## 💻 Software yang Dibutuhkan

### 1️⃣ **PHP** (Version 8.2 atau lebih tinggi)

**Windows:**
- Download XAMPP: https://www.apachefriends.org/download.html
- Install XAMPP (include PHP, MySQL, Apache)
- Atau download PHP standalone: https://windows.php.net/download/

**macOS:**
```bash
brew install php@8.2
```

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-common php8.2-mysql php8.2-xml php8.2-curl php8.2-mbstring php8.2-zip
```

**Verify Installation:**
```bash
php --version
# Should show: PHP 8.2.x
```

---

### 2️⃣ **Composer** (PHP Dependency Manager)

**Download & Install:**
- Windows: https://getcomposer.org/Composer-Setup.exe
- macOS/Linux: https://getcomposer.org/download/

**Verify Installation:**
```bash
composer --version
# Should show: Composer version 2.x.x
```

---

### 3️⃣ **Node.js & NPM** (Version 18 atau lebih tinggi)

**Download:**
- https://nodejs.org/en/download/
- Pilih LTS version

**Verify Installation:**
```bash
node --version
# Should show: v20.x.x atau v18.x.x

npm --version
# Should show: 10.x.x atau lebih
```

---

### 4️⃣ **Git**

**Download:**
- Windows: https://git-scm.com/download/win
- macOS: Sudah include atau `brew install git`
- Linux: `sudo apt install git`

**Verify Installation:**
```bash
git --version
# Should show: git version 2.x.x
```

**Configure Git (First Time):**
```bash
git config --global user.name "Nama Anda"
git config --global user.email "email@example.com"
```

---

### 5️⃣ **Database** (MySQL atau MariaDB)

**Option A: XAMPP (Recommended untuk Windows)**
- Sudah include MySQL
- Start MySQL dari XAMPP Control Panel

**Option B: MySQL Standalone**
- Windows: https://dev.mysql.com/downloads/installer/
- macOS: `brew install mysql`
- Linux: `sudo apt install mysql-server`

**Verify Installation:**
```bash
mysql --version
# Should show: mysql Ver 8.0.x
```

---

### 6️⃣ **Code Editor** (Recommended: VS Code)

**Download:**
- https://code.visualstudio.com/

**Recommended Extensions:**
- PHP Intelephense
- Laravel Extension Pack
- Playwright Test for VSCode
- GitLens
- Tailwind CSS IntelliSense

---

## 📥 Clone Repository

### 1️⃣ Clone Project

```bash
# Clone repository
git clone https://github.com/petrusthelastking/MAGNET-Magang-Network-And-Tracking.git

# Masuk ke folder project
cd MAGNET-Magang-Network-And-Tracking

# Checkout ke branch development
git checkout Testing-Petrus
```

---

## ⚙️ Setup Laravel

### 1️⃣ Install PHP Dependencies

```bash
composer install
```

**Jika error "composer not found":**
- Pastikan Composer sudah di-install
- Restart terminal/command prompt
- Check PATH environment variable

---

### 2️⃣ Install NPM Dependencies

```bash
npm install
# atau
npm ci
```

---

### 3️⃣ Setup Environment File

```bash
# Copy .env.example ke .env
cp .env.example .env

# Untuk Windows (PowerShell):
Copy-Item .env.example .env

# Untuk Windows (CMD):
copy .env.example .env
```

---

### 4️⃣ Generate Application Key

```bash
php artisan key:generate
```

---

### 5️⃣ Configure .env File

Buka file `.env` dan sesuaikan:

```env
APP_NAME=MAGNET
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=magnet
DB_USERNAME=root
DB_PASSWORD=       # Kosongkan jika tidak ada password (XAMPP default)

# Atau gunakan SQLite untuk development (lebih simple)
# DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite
```

---

## 🗄️ Setup Database

### Option A: MySQL/MariaDB

**1️⃣ Start MySQL:**
- **XAMPP:** Start MySQL dari XAMPP Control Panel
- **Standalone:** `mysql.server start` (macOS) atau service sudah auto-start

**2️⃣ Create Database:**

```bash
# Login ke MySQL
mysql -u root -p

# Create database
CREATE DATABASE magnet;

# Exit
exit;
```

**3️⃣ Run Migrations:**

```bash
php artisan migrate
```

**4️⃣ Seed Database (Optional):**

```bash
php artisan db:seed
```

---

### Option B: SQLite (Recommended untuk Testing)

**1️⃣ Update .env:**

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

**2️⃣ Create Database File:**

```bash
# Linux/macOS:
touch database/database.sqlite

# Windows (PowerShell):
New-Item -Path database/database.sqlite -ItemType File

# Windows (CMD):
type nul > database\database.sqlite
```

**3️⃣ Run Migrations:**

```bash
php artisan migrate
php artisan db:seed
```

---

## 🎭 Setup Testing (Playwright)

### 1️⃣ Install Playwright

```bash
# Install Playwright dan browsers
npx playwright install

# Install system dependencies (jika diperlukan)
npx playwright install-deps
```

---

### 2️⃣ Verify Playwright Configuration

File `playwright.config.js` sudah ada di project.

Check baseURL:
```javascript
use: {
  baseURL: 'http://127.0.0.1:8000',
  // ...
}
```

---

### 3️⃣ Test Playwright Installation

```bash
# Run sample test
npx playwright test tests/e2e/admin/admin-login.spec.js --project=chromium
```

Jika berhasil, berarti setup OK! ✅

---

## 🚀 Running Project

### Development Mode:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
# Server running at: http://127.0.0.1:8000
```

**Terminal 2 - Vite Dev Server (Hot Reload):**
```bash
npm run dev
# Vite running at: http://localhost:5173
```

**Akses aplikasi di browser:**
```
http://127.0.0.1:8000
```

---

### Build untuk Production:

```bash
# Build assets
npm run build

# Start server
php artisan serve
```

---

## 🧪 Running Tests

### Run All E2E Tests:

```bash
npm run test:e2e
```

### Run Specific Tests:

```bash
# Admin tests
npx playwright test tests/e2e/admin --project=chromium

# Mahasiswa tests
npx playwright test tests/e2e/mahasiswa --project=chromium

# Single file
npx playwright test tests/e2e/admin/admin-login.spec.js --project=chromium
```

### Run with UI (Debugging):

```bash
npm run test:e2e:ui
```

### View Test Report:

```bash
npm run test:e2e:report
```

---

## 🐛 Troubleshooting

### Issue: `composer install` error

**Solution:**
```bash
# Clear composer cache
composer clear-cache

# Update composer
composer self-update

# Try install again
composer install --no-scripts
composer install
```

---

### Issue: `npm install` error

**Solution:**
```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules dan package-lock.json
rm -rf node_modules package-lock.json

# Install ulang
npm install
```

---

### Issue: Permission denied (Linux/macOS)

**Solution:**
```bash
# Give permission ke storage dan bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Change owner (jika perlu)
sudo chown -R $USER:www-data storage bootstrap/cache
```

---

### Issue: Port 8000 already in use

**Solution:**
```bash
# Use different port
php artisan serve --port=8001

# Update playwright.config.js baseURL
# baseURL: 'http://127.0.0.1:8001'
```

---

### Issue: Database connection error

**Solution:**
```bash
# Check MySQL is running
# XAMPP: Start dari Control Panel
# Standalone: mysql.server start

# Check credentials di .env
# DB_USERNAME=root
# DB_PASSWORD=

# Test connection
php artisan migrate:status
```

---

### Issue: Playwright tests fail

**Solution:**
```bash
# Make sure server is running
php artisan serve

# Install browsers ulang
npx playwright install chromium

# Clear test cache
rm -rf test-results playwright-report

# Run again
npm run test:e2e
```

---

## 📝 Workflow Development

### Daily Workflow:

```bash
# 1. Pull latest changes
git pull origin Testing-Petrus

# 2. Install dependencies (jika ada update)
composer install
npm install

# 3. Run migrations (jika ada migration baru)
php artisan migrate

# 4. Start development
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev

# 5. Coding... 💻

# 6. Test sebelum commit
npm run test:e2e

# 7. Commit & Push
git add .
git commit -m "Your message"
git push origin Testing-Petrus
```

---

### Working dengan Branch:

```bash
# Create new branch untuk feature
git checkout -b feature/nama-fitur

# Develop...

# Commit changes
git add .
git commit -m "Add: new feature"

# Push branch
git push origin feature/nama-fitur

# Create Pull Request di GitHub
```

---

## 🎯 Quick Commands Cheatsheet

```bash
# Laravel
php artisan serve                    # Start server
php artisan migrate                  # Run migrations
php artisan migrate:fresh --seed    # Reset database
php artisan db:seed                  # Seed database
php artisan route:list               # List all routes
php artisan cache:clear              # Clear cache

# NPM
npm run dev                          # Start Vite dev server
npm run build                        # Build for production
npm run test:e2e                     # Run all tests
npm run test:e2e:ui                  # Run tests with UI

# Git
git status                           # Check status
git pull                             # Pull latest changes
git add .                            # Stage all changes
git commit -m "message"              # Commit
git push                             # Push to remote
git checkout -b branch-name          # Create new branch
git branch                           # List branches

# Composer
composer install                     # Install PHP dependencies
composer update                      # Update dependencies
composer dump-autoload               # Regenerate autoload
```

---

## 📚 Dokumentasi Project

- **Testing Guide:** `tests/e2e/README.md`
- **Admin Tests:** `tests/e2e/admin/README.md`
- **Mahasiswa Tests:** `tests/e2e/mahasiswa/README.md`
- **GitHub Actions:** `.github/GITHUB_ACTIONS_GUIDE.md`
- **Troubleshooting:** `.github/TROUBLESHOOTING.md`

---

## 💡 Tips untuk Development

1. **Always pull before start coding:**
   ```bash
   git pull origin Testing-Petrus
   ```

2. **Test locally before push:**
   ```bash
   npm run test:e2e
   ```

3. **Use meaningful commit messages:**
   ```bash
   git commit -m "Fix: login validation error"
   git commit -m "Add: mahasiswa profile page"
   ```

4. **Keep dependencies updated:**
   ```bash
   composer update
   npm update
   ```

5. **Use .env for local config:**
   - Never commit `.env` file
   - Use `.env.example` as template

---

## ✅ Setup Checklist

Gunakan checklist ini untuk memastikan setup lengkap:

- [ ] PHP 8.2+ installed (`php --version`)
- [ ] Composer installed (`composer --version`)
- [ ] Node.js 18+ installed (`node --version`)
- [ ] Git installed (`git --version`)
- [ ] MySQL/SQLite running
- [ ] Repository cloned
- [ ] `.env` file configured
- [ ] `composer install` success
- [ ] `npm install` success
- [ ] `php artisan key:generate` done
- [ ] Database created
- [ ] `php artisan migrate` success
- [ ] `php artisan serve` running
- [ ] `npm run dev` running (optional)
- [ ] Test akses `http://127.0.0.1:8000` di browser
- [ ] Playwright installed (`npx playwright install`)
- [ ] Test run success (`npm run test:e2e`)

---

## 🆘 Need Help?

**Jika masih ada masalah:**

1. **Check error message carefully**
2. **Google the error** (biasanya ada solusi)
3. **Check Laravel logs:** `storage/logs/laravel.log`
4. **Ask team:** Share error message & screenshot
5. **Check documentation:** Laravel, Playwright docs

---

## 🎉 Setup Complete!

Jika semua checklist ✅, berarti setup berhasil dan siap develop!

**Happy Coding! 💻🚀**
