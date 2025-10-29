# Playwright E2E Testing Guide

## 📋 Prerequisites
- Node.js dan npm terinstall
- Laravel application berjalan di `http://127.0.0.1:8000`
- Database sudah di-seed dengan data testing

## 🚀 Setup

### 1. Install Dependencies
```bash
npm install -D @playwright/test
npx playwright install
```

### 2. Database Setup untuk Testing
Pastikan Anda memiliki data seed untuk testing. Buat user testing di database:

```php
// database/seeders/TestUserSeeder.php
public function run()
{
    // Admin
    \App\Models\Admin::create([
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'name' => 'Admin Test',
    ]);

    // Mahasiswa
    \App\Models\Mahasiswa::create([
        'email' => 'mahasiswa@example.com',
        'password' => bcrypt('password'),
        'nim' => '12345678',
        'nama' => 'Mahasiswa Test',
    ]);

    // Perusahaan
    \App\Models\Perusahaan::create([
        'email' => 'perusahaan@example.com',
        'password' => bcrypt('password'),
        'nama_perusahaan' => 'PT Test',
    ]);
}
```

Jalankan seeder:
```bash
php artisan db:seed --class=TestUserSeeder
```

## 🧪 Running Tests

### Run All Tests
```bash
npm run test:e2e
```

### Run Tests dengan UI Mode (Interactive)
```bash
npm run test:e2e:ui
```

### Run Tests dengan Browser Terlihat (Headed)
```bash
npm run test:e2e:headed
```

### Run Tests dalam Debug Mode
```bash
npm run test:e2e:debug
```

### Run Specific Test File
```bash
npx playwright test tests/e2e/auth.spec.js
```

### Run Tests pada Browser Tertentu
```bash
npx playwright test --project=chromium
npx playwright test --project=firefox
npx playwright test --project=webkit
```

### View Test Report
```bash
npm run test:e2e:report
```

## 📁 Test Structure

```
tests/e2e/
├── helpers.js                      # Helper functions untuk reusable code
├── homepage.spec.js                # Tests untuk homepage
├── auth.spec.js                    # Tests untuk authentication
├── admin-data-mahasiswa.spec.js    # Tests untuk admin data mahasiswa
└── lowongan-magang.spec.js         # Tests untuk lowongan magang
```

## ✍️ Writing Tests

### Basic Test Structure
```javascript
import { test, expect } from '@playwright/test';

test.describe('Feature Name', () => {
  test.beforeEach(async ({ page }) => {
    // Setup before each test
    await page.goto('/');
  });

  test('should do something', async ({ page }) => {
    // Test code here
    await expect(page).toHaveTitle(/Expected Title/);
  });
});
```

### Using Helpers
```javascript
import { test, expect } from '@playwright/test';
import { loginAsAdmin, waitForTable } from './helpers';

test('admin test', async ({ page }) => {
  await loginAsAdmin(page);
  await page.goto('/admin/dashboard');
  await waitForTable(page);
});
```

### Common Actions
```javascript
// Navigate
await page.goto('/path');

// Click
await page.click('button');
await page.locator('button:has-text("Submit")').click();

// Fill input
await page.fill('input[name="email"]', 'test@example.com');

// Select dropdown
await page.selectOption('select[name="status"]', 'active');

// Wait
await page.waitForTimeout(1000);
await page.waitForLoadState('networkidle');
await page.waitForSelector('.element');

// Assertions
await expect(page).toHaveURL('/dashboard');
await expect(page).toHaveTitle(/Title/);
await expect(page.locator('.element')).toBeVisible();
await expect(page.locator('.element')).toHaveText('Text');
```

## 🎯 Best Practices

### 1. Use Data Test IDs
Tambahkan `data-testid` pada elemen penting:
```html
<button data-testid="submit-button">Submit</button>
```

```javascript
await page.locator('[data-testid="submit-button"]').click();
```

### 2. Avoid Hard-coded Waits
Gunakan `waitForSelector` atau `waitForLoadState` instead of `waitForTimeout`:
```javascript
// ❌ Bad
await page.waitForTimeout(3000);

// ✅ Good
await page.waitForSelector('.data-loaded');
await page.waitForLoadState('networkidle');
```

### 3. Use Page Object Model
Untuk test yang kompleks, gunakan Page Object Model:

```javascript
// pages/LoginPage.js
export class LoginPage {
  constructor(page) {
    this.page = page;
    this.emailInput = page.locator('input[name="email"]');
    this.passwordInput = page.locator('input[name="password"]');
    this.submitButton = page.locator('button[type="submit"]');
  }

  async login(email, password) {
    await this.emailInput.fill(email);
    await this.passwordInput.fill(password);
    await this.submitButton.click();
  }
}

// Usage in test
import { LoginPage } from './pages/LoginPage';

test('login test', async ({ page }) => {
  const loginPage = new LoginPage(page);
  await page.goto('/login');
  await loginPage.login('admin@example.com', 'password');
});
```

### 4. Use beforeEach for Setup
```javascript
test.describe('Admin Tests', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsAdmin(page);
  });

  test('test 1', async ({ page }) => {
    // Already logged in as admin
  });

  test('test 2', async ({ page }) => {
    // Already logged in as admin
  });
});
```

## 🔍 Debugging

### 1. Playwright Inspector
```bash
npx playwright test --debug
```

### 2. Screenshots on Failure
Screenshots otomatis tersimpan di `test-results/` saat test gagal.

### 3. Video Recording
Video tersimpan di `test-results/` untuk test yang gagal.

### 4. Trace Viewer
```bash
npx playwright show-trace trace.zip
```

### 5. Console Logs
```javascript
page.on('console', msg => console.log(msg.text()));
```

## 📊 CI/CD Integration

### GitHub Actions
```yaml
name: Playwright Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: actions/setup-node@v3
        with:
          node-version: 18
      
      - name: Install dependencies
        run: npm ci
      
      - name: Install Playwright Browsers
        run: npx playwright install --with-deps
      
      - name: Setup Laravel
        run: |
          composer install
          cp .env.example .env
          php artisan key:generate
          php artisan migrate
          php artisan db:seed --class=TestUserSeeder
      
      - name: Run Playwright tests
        run: npm run test:e2e
      
      - uses: actions/upload-artifact@v3
        if: always()
        with:
          name: playwright-report
          path: playwright-report/
          retention-days: 30
```

## 🔧 Configuration

Konfigurasi Playwright ada di `playwright.config.js`. Anda bisa mengubah:
- `baseURL`: URL aplikasi
- `timeout`: Timeout untuk test
- `retries`: Jumlah retry saat gagal
- `workers`: Jumlah parallel workers
- Browser yang digunakan

## 📚 Resources
- [Playwright Documentation](https://playwright.dev)
- [Playwright API Reference](https://playwright.dev/docs/api/class-playwright)
- [Playwright Best Practices](https://playwright.dev/docs/best-practices)

## 🐛 Common Issues

### Issue: Browser not found
```bash
npx playwright install
```

### Issue: Port 8000 already in use
Pastikan Laravel app tidak running di terminal lain, atau ubah port di `playwright.config.js`.

### Issue: Tests timeout
Increase timeout di `playwright.config.js`:
```javascript
use: {
  timeout: 60000, // 60 seconds
}
```

### Issue: Authentication fails
Pastikan user test sudah di-seed ke database dengan credentials yang benar.

## 📝 Notes
- Pastikan aplikasi Laravel running sebelum menjalankan test
- Gunakan database testing terpisah untuk menghindari data corruption
- Update selectors jika ada perubahan pada UI
- Jalankan test secara berkala untuk memastikan tidak ada regression
