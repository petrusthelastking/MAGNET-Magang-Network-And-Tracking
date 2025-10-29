# ⚠️ PENTING: Cara Menjalankan Testing Login Mahasiswa

## 🔴 MASALAH YANG TERJADI

`php artisan serve` dan PHP built-in server **TIDAK BISA START** di sistem Anda.
Kemungkinan penyebab:
- Windows Firewall blocking
- Antivirus blocking
- Network configuration issue

## ✅ SOLUSI: MENGGUNAKAN LARAGON VIRTUAL HOST

### 🎯 STATUS TERKINI:
- ✅ User NIM `6705300038` sudah ada di database
- ✅ Password sudah diupdate ke `mahasiswa123`
- ✅ Laragon Apache sudah running
- ✅ Virtual Host configuration sudah dibuat
- ✅ Playwright baseURL sudah diupdate ke `http://magnet.test`

### 🚀 CARA MENJALANKAN (3 LANGKAH MUDAH):

#### **LANGKAH 1: Setup Laragon Virtual Host (OTOMATIS)**

1. **Klik kanan PowerShell** → **Run as Administrator**
2. **Jalankan command:**
   ```powershell
   cd "c:\Peyimpanan Pribadi\Data D\New folder (2)\Semester 5\pmpl\MAGNET-Magang-Network-And-Tracking"
   .\setup-laragon.ps1
   ```
3. **Ikuti instruksi** di script untuk restart Laragon

#### **LANGKAH 2: Test di Browser (MANUAL)**

1. **Buka browser**: `http://magnet.test`
2. **Jika muncul homepage Laravel** → Server BERHASIL! ✅
3. **Buka halaman login**: `http://magnet.test/login`
4. **Login dengan**:
   - NIM: `6705300038`
   - Password: `mahasiswa123`
5. **Klik Login** → Jika masuk dashboard mahasiswa → LOGIN BERHASIL! 🎉

#### **LANGKAH 3: Jalankan Playwright Test (OTOMATIS)**

**Cara 1: Menggunakan Batch File**
```powershell
.\run-mahasiswa-login-test.bat
```

**Cara 2: Manual Command**
```powershell
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed
```

**Cara 3: Debug Mode**
```powershell
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug
```

---

## ⚠️ JIKA MASIH GAGAL (BACKUP PLAN)

## ✅ SOLUSI ALTERNATIF: TESTING MANUAL DULU

Karena ada kendala teknis dengan server, mari kita test **MANUAL** dulu untuk memastikan login bekerja:

### 1️⃣ VERIFIKASI USER TEST ADA

User mahasiswa sudah dibuat dengan kredensial:
- **NIM**: `6705300038`
- **Password**: `mahasiswa123`

Untuk memastikan ada di database, jalankan:
```powershell
php artisan tinker
```

Lalu ketik:
```php
\App\Models\Mahasiswa::where('nim', '6705300038')->first();
```

Jika muncul data mahasiswa, berarti user sudah ada ✅

### 2️⃣ START SERVER DENGAN CARA LAIN

**CARA 1: Nonaktifkan Firewall Sementara**
1. Buka Windows Security
2. Firewall & network protection
3. Turn off Windows Defender Firewall (sementara)
4. Coba lagi: `php artisan serve`

**CARA 2: Gunakan Terminal dengan Admin Rights**
1. Klik kanan PowerShell → Run as Administrator
2. `cd` ke folder project
3. `php artisan serve`

**CARA 3: Gunakan Port Lain**
```powershell
php artisan serve --port=8080
# atau
php artisan serve --port=9000
```

**CARA 4: Install XAMPP untuk Web Server**
1. Install XAMPP
2. Copy project ke `C:\xampp\htdocs\`
3. Start Apache dari XAMPP Control Panel
4. Akses: `http://localhost/MAGNET-Magang-Network-And-Tracking/public`

### 3️⃣ TEST LOGIN MANUAL DI BROWSER

Setelah server berhasil running:
1. Buka browser (Chrome/Edge/Firefox)
2. Akses halaman login
3. Masukkan:
   - NIM: `6705300038`
   - Password: `mahasiswa123`
4. Klik Login
5. ✅ Jika berhasil masuk dashboard, berarti login BERHASIL!

### 4️⃣ JALANKAN PLAYWRIGHT TEST

Setelah server running dan login manual berhasil:

**Step 1: Update baseURL di `playwright.config.js`**

Edit file dan ganti `baseURL` sesuai server Anda:
```javascript
// Jika pakai php artisan serve
baseURL: 'http://127.0.0.1:8000',

// Jika pakai XAMPP
baseURL: 'http://localhost/MAGNET-Magang-Network-And-Tracking/public',

// Jika pakai port lain
baseURL: 'http://127.0.0.1:9000',
```

**Step 2: Jalankan Test**
```powershell
# Test dengan browser visible
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed

# Test single case
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed --grep "should successfully login"

# Debug mode
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug
```

## 📊 HASIL YANG DIHARAPKAN

Jika test berhasil:
```
✓ should successfully login as mahasiswa with NIM 6705300038
✓ should display mahasiswa dashboard after login
✓ should show error with wrong password
✓ should be able to navigate after login

4 passed
```

## 📸 SCREENSHOT & REPORT

Test akan membuat:
- Screenshots di `test-results/`
- Video recording (jika gagal)
- HTML report: `npx playwright show-report`

## 🎯 KESIMPULAN

**Test login mahasiswa SUDAH SIAP 100%**:
- ✅ User test sudah dibuat di database
- ✅ Test file sudah dibuat lengkap
- ✅ Konfigurasi sudah siap

**Yang perlu dilakukan**:
1. Start Laravel server dengan cara apapun yang berhasil
2. Test login manual di browser dulu
3. Update baseURL di playwright.config.js
4. Run test Playwright

---

**File Penting**:
- Test: `tests/e2e/mahasiswa-login-real.spec.js`
- Config: `playwright.config.js`
- Seeder: `database/seeders/RealMahasiswaSeeder.php`

**Kredensial Test**:
- NIM: `6705300038`
- Password: `mahasiswa123`
