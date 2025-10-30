# GitHub Actions - E2E Testing Setup

Dokumentasi lengkap untuk menjalankan E2E testing di GitHub Actions.

---

## 📁 Workflow Files

```
.github/workflows/
├── e2e-testing.yml        # Main E2E workflow (otomatis)
└── quick-e2e.yml          # Quick test workflow (manual)
```

---

## 🚀 Workflow 1: E2E Testing (Otomatis)

**File:** `.github/workflows/e2e-testing.yml`

### Trigger Otomatis:
- ✅ Push ke branch: `main`, `develop`, `Testing-Petrus`
- ✅ Pull Request ke: `main`, `develop`
- ✅ Manual trigger dari GitHub Actions tab

### Jobs yang Dijalankan:

#### 1️⃣ Admin E2E Tests
- Install dependencies (PHP, Node.js, Composer, NPM)
- Setup database (SQLite)
- Run migrations & seeders
- Build assets
- Start Laravel server
- Run Playwright tests untuk Admin (16 tests)
- Upload test results sebagai artifacts

#### 2️⃣ Mahasiswa E2E Tests
- Setup yang sama seperti Admin
- Run Playwright tests untuk Mahasiswa (11 tests)
- Upload test results sebagai artifacts

#### 3️⃣ Test Summary
- Menampilkan summary hasil test
- Status Admin & Mahasiswa tests

---

## ⚡ Workflow 2: Quick E2E Test (Manual)

**File:** `.github/workflows/quick-e2e.yml`

### Cara Menggunakan:

1. Buka GitHub repository
2. Klik tab **"Actions"**
3. Pilih **"Quick E2E Test"** di sidebar kiri
4. Klik **"Run workflow"**
5. Pilih role yang ingin di-test:
   - `admin` - Test Admin saja
   - `mahasiswa` - Test Mahasiswa saja
   - `all` - Test semua role
6. Klik **"Run workflow"** (hijau)

### Keuntungan Quick Test:
- ⚡ Lebih cepat (fokus pada 1 role)
- 🎯 Flexible (pilih role yang mau ditest)
- 🔄 Manual control

---

## 📊 Melihat Hasil Test

### Di GitHub Actions Tab:

1. **Klik tab "Actions"** di repository
2. **Pilih workflow run** yang ingin dilihat
3. **Lihat status** setiap job:
   - ✅ Green checkmark = Passed
   - ❌ Red X = Failed
   - 🟡 Yellow = Running

### Melihat Detail:

1. **Klik nama job** (misal: "Admin E2E Tests")
2. **Expand step** untuk melihat log detail
3. **Lihat test output** di step "Run Admin E2E tests"

### Download Test Results:

1. Scroll ke bawah halaman workflow run
2. Lihat bagian **"Artifacts"**
3. Download:
   - `admin-test-results` - Hasil test admin
   - `mahasiswa-test-results` - Hasil test mahasiswa
4. Extract ZIP untuk lihat:
   - `playwright-report/` - HTML report
   - `test-results/` - Screenshots & videos

---

## 🎯 Status Badge

Tambahkan badge di README.md untuk show status:

```markdown
[![E2E Testing](https://github.com/petrusthelastking/MAGNET-Magang-Network-And-Tracking/actions/workflows/e2e-testing.yml/badge.svg)](https://github.com/petrusthelastking/MAGNET-Magang-Network-And-Tracking/actions/workflows/e2e-testing.yml)
```

---

## 🔧 Configuration

### Environment Variables:

Workflow sudah configured dengan:
- `DB_CONNECTION=sqlite` - Menggunakan SQLite untuk testing
- `APP_ENV=local` - Environment Laravel
- `CI=true` - Flag untuk Playwright CI mode

### Timeouts:

- **Job timeout:** 20 minutes per job
- **Server wait:** 30 attempts (60 seconds total)

### Artifacts Retention:

- **E2E Testing:** 7 days
- **Quick E2E:** 3 days

---

## 🐛 Troubleshooting

### Issue: Job timeout
**Solution:** Tingkatkan `timeout-minutes` di workflow file

### Issue: Server tidak start
**Solution:** Check Laravel logs di job output, pastikan database setup correct

### Issue: Tests failed
**Solution:** 
1. Download artifacts
2. Lihat screenshot & video di `test-results/`
3. Check HTML report di `playwright-report/index.html`

### Issue: Database error
**Solution:** Pastikan migrations & seeders berjalan dengan baik di step sebelumnya

---

## 📝 Best Practices

### 1️⃣ Commit Test Changes:
Pastikan commit test file changes sebelum push:
```bash
git add tests/e2e/
git commit -m "Update E2E tests"
git push
```

### 2️⃣ Check Status Sebelum Merge:
Selalu check GitHub Actions status sebelum merge PR

### 3️⃣ Review Failed Tests:
Kalau test gagal, download artifacts dan review:
- Screenshots untuk visual errors
- Videos untuk replay test execution
- HTML report untuk detail summary

### 4️⃣ Use Quick Test untuk Development:
Gunakan "Quick E2E Test" untuk test cepat saat develop

---

## 🎨 Workflow Visualization

```
Push/PR to main/develop
         │
         ▼
  ┌──────────────┐
  │ E2E Testing  │
  └──────┬───────┘
         │
    ┌────┴────┐
    │         │
    ▼         ▼
┌─────┐   ┌──────────┐
│Admin│   │Mahasiswa │
│Tests│   │  Tests   │
└──┬──┘   └────┬─────┘
   │           │
   └─────┬─────┘
         │
         ▼
   ┌──────────┐
   │ Summary  │
   └──────────┘
```

---

## 📋 Checklist Setup GitHub Actions

- [x] Create `.github/workflows/e2e-testing.yml`
- [x] Create `.github/workflows/quick-e2e.yml`
- [ ] Push workflows to GitHub
- [ ] Verify workflows appear in Actions tab
- [ ] Run manual test dengan "Quick E2E Test"
- [ ] Check test results dan artifacts
- [ ] Add status badge ke README (optional)

---

## 🔗 Useful Links

- **GitHub Actions Documentation:** https://docs.github.com/en/actions
- **Playwright CI Documentation:** https://playwright.dev/docs/ci
- **Laravel Testing:** https://laravel.com/docs/testing

---

## 💡 Tips untuk Tim

### Untuk Developer:
1. **Sebelum push:** Run test local dulu
   ```bash
   npx playwright test tests/e2e/admin --project=chromium
   npx playwright test tests/e2e/mahasiswa --project=chromium
   ```

2. **Setelah push:** Check Actions tab untuk status

3. **Jika gagal:** Download artifacts dan fix locally

### Untuk Reviewer (PR):
1. **Check Actions status** di PR
2. **Jangan merge** kalau tests failed
3. **Request changes** dengan detail dari test results

---

**Setup Complete! 🎉**

Workflow sudah ready untuk:
- ✅ Auto-run saat push/PR
- ✅ Manual run dengan pilihan role
- ✅ Upload test results & reports
- ✅ Summary status untuk setiap run
