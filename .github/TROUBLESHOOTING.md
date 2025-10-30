# 🔧 GitHub Actions - Troubleshooting Guide

## ❌ Masalah yang Sering Terjadi dan Solusinya

---

## 1. ❌ TestUserSeeder Class Not Found

### Error:
```
Class "Database\Seeders\TestUserSeeder" not found
```

### Penyebab:
Workflow mencoba run seeder yang tidak ada

### ✅ Solusi:
**Sudah diperbaiki!** Workflow sekarang menggunakan:
```yaml
php artisan db:seed --force
```
Ini akan run semua seeders yang ada di `DatabaseSeeder.php`

---

## 2. ❌ MySQL Service Timeout

### Error:
```
SQLSTATE[HY000] [2002] Connection refused
```

### Penyebab:
- MySQL service belum ready
- Connection configuration salah

### ✅ Solusi:
**Sudah diperbaiki!** Workflow sekarang menggunakan **SQLite** instead of MySQL:
```yaml
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

**Keuntungan SQLite:**
- ✅ Lebih cepat setup
- ✅ No service dependencies
- ✅ Lebih reliable di CI/CD

---

## 3. ❌ Server Not Ready

### Error:
```
Error: page.goto: net::ERR_CONNECTION_REFUSED
```

### Penyebab:
Laravel server belum start atau belum ready

### ✅ Solusi:
**Sudah diperbaiki!** Added wait loop:
```yaml
- name: Wait for Server
  run: |
    for i in {1..30}; do
      if curl -s http://127.0.0.1:8000 > /dev/null; then
        echo "✓ Server is ready!"
        break
      fi
      sleep 2
    done
```

---

## 4. ❌ Playwright Browser Not Installed

### Error:
```
browserType.launch: Executable doesn't exist
```

### Penyebab:
Playwright browsers belum di-install atau wrong browser

### ✅ Solusi:
**Sudah diperbaiki!** Install chromium only:
```yaml
npx playwright install --with-deps chromium
```

Lebih cepat karena hanya install 1 browser instead of all.

---

## 5. ❌ Build Failed (Assets)

### Error:
```
ERROR: Failed to load PostCSS config
```

### Penyebab:
- Missing dependencies
- Vite configuration error

### ✅ Solusi:
Pastikan `npm ci` berjalan sebelum `npm run build`:
```yaml
- name: Install NPM Dependencies
  run: npm ci
  
- name: Build Assets
  run: npm run build
```

---

## 6. ❌ Test Timeout

### Error:
```
Test timeout of 30000ms exceeded
```

### Penyebab:
- Server lambat respond
- Test script timeout
- Network issue

### ✅ Solusi:

**Option 1:** Increase timeout di workflow:
```yaml
jobs:
  test:
    timeout-minutes: 30  # Increase if needed
```

**Option 2:** Increase timeout di test file:
```javascript
test.setTimeout(60000); // 60 seconds
```

---

## 7. ❌ Permission Denied (SQLite)

### Error:
```
SQLSTATE[HY000] [14] unable to open database file
```

### Penyebab:
Database file atau directory tidak ada

### ✅ Solusi:
**Sudah diperbaiki!** Create file first:
```yaml
- name: Setup Environment
  run: |
    cp .env.example .env
    php artisan key:generate
    touch database/database.sqlite  # Create file
```

---

## 🔍 How to Debug Failed Workflow

### Step 1: Lihat Logs
1. Buka failed workflow di GitHub Actions
2. Klik job yang fail
3. Expand step yang error
4. Read error message carefully

### Step 2: Download Artifacts
1. Scroll ke bawah workflow page
2. Download `test-results` artifact
3. Extract dan lihat:
   - Screenshots di `test-results/`
   - Videos (jika ada)

### Step 3: Download Playwright Report
1. Download `playwright-report` artifact
2. Extract
3. Buka `index.html` di browser
4. Lihat detail setiap test

### Step 4: Test Locally
Reproduce issue locally:
```bash
# 1. Use SQLite like CI
echo "DB_CONNECTION=sqlite" >> .env
echo "DB_DATABASE=database/database.sqlite" >> .env

# 2. Setup fresh
php artisan migrate:fresh --seed

# 3. Start server
php artisan serve

# 4. Run tests
npm run test:e2e
```

---

## 📋 Checklist Sebelum Push

- [ ] Tests passing locally
- [ ] `.env.example` updated dengan config yang correct
- [ ] Database seeders working
- [ ] Assets build successfully (`npm run build`)
- [ ] No hardcoded credentials di test files

---

## 🚀 Perbaikan yang Sudah Dilakukan

### ✅ playwright.yml (Updated)

**Before (Had Issues):**
- ❌ Using MySQL service (complex, slow)
- ❌ Required TestUserSeeder (might not exist)
- ❌ No server wait check
- ❌ Install all browsers (slow)

**After (Fixed):**
- ✅ Using SQLite (simple, fast)
- ✅ Run all seeders via DatabaseSeeder
- ✅ Added server ready check with retry
- ✅ Install chromium only (faster)
- ✅ Better error handling
- ✅ Manual trigger support (`workflow_dispatch`)

---

## 💡 Best Practices untuk CI/CD

### 1. Use SQLite for Testing
```yaml
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 2. Add Server Ready Check
```yaml
- name: Wait for Server
  run: |
    for i in {1..30}; do
      curl -s http://127.0.0.1:8000 && break || sleep 2
    done
```

### 3. Install Only Needed Browsers
```yaml
npx playwright install --with-deps chromium
```

### 4. Use Proper Versions
```yaml
- uses: actions/checkout@v4        # Latest
- uses: actions/setup-node@v4      # Latest
- uses: actions/upload-artifact@v4 # Latest
```

### 5. Add Manual Trigger
```yaml
on:
  push:
  pull_request:
  workflow_dispatch:  # Allow manual run
```

---

## 🔄 Re-run Failed Workflow

### Option 1: Push Again
```bash
git commit --allow-empty -m "Trigger workflow"
git push
```

### Option 2: Re-run dari GitHub
1. Buka failed workflow
2. Klik "Re-run jobs" (top right)
3. Pilih "Re-run failed jobs" atau "Re-run all jobs"

### Option 3: Manual Trigger
1. Tab Actions
2. Pilih workflow
3. Klik "Run workflow"
4. Select branch
5. Run

---

## 📞 Need Help?

Jika masih error setelah perbaikan:

1. **Check Logs:** Download dan review artifacts
2. **Test Locally:** Reproduce issue di local machine
3. **Review Changes:** Check recent commits yang might break tests
4. **Update Dependencies:** `npm update` dan `composer update`

---

**Workflow sudah diperbaiki dan ready to use! 🎉**

Push file `playwright.yml` yang sudah di-update dan workflow akan jalan lebih stable.
