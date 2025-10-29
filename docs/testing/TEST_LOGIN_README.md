# 🚀 Quick Start - Testing Login Mahasiswa

## Kredensial Test
- **NIM**: `6705300038`
- **Password**: `mahasiswa123`

## ⚠️ PENTING: Start Server Manual

Karena ada issue dengan `php artisan serve`, silakan start server dengan salah satu cara berikut:

### Opsi 1: Gunakan XAMPP/Laragon
1. Copy project ke folder `htdocs` (XAMPP) atau `www` (Laragon)
2. Akses via `http://localhost/MAGNET-Magang-Network-And-Tracking/public`
3. Update baseURL di `playwright.config.js` sesuai URL di atas

### Opsi 2: NPM Dev Server (jika ada)
```powershell
npm run dev
```
Lalu buka terminal baru untuk run test.

### Opsi 3: Manual PHP Server
Jika berhasil:
```powershell
php -S localhost:8000 -t public
```

## 📝 Update Base URL di Playwright

Edit file `playwright.config.js`, ubah baris:
```javascript
baseURL: 'http://127.0.0.1:8000',
```

Menjadi URL server Anda, misalnya:
```javascript
baseURL: 'http://localhost/MAGNET-Magang-Network-And-Tracking/public',
// atau
baseURL: 'http://localhost:8000',
// atau sesuai dengan server Anda
```

## ▶️ Jalankan Test

Setelah server running dan baseURL sudah benar:

```powershell
# Test dengan browser visible (RECOMMENDED)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed

# Test specific untuk login saja
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --headed --grep "should successfully login"

# Debug mode (step by step)
npx playwright test tests/e2e/mahasiswa-login-real.spec.js --debug
```

## 🎯 Apa yang Akan Di-test?

1. ✅ **Login Berhasil**: Form login dengan NIM 6705300038 dan password mahasiswa123
2. ✅ **Redirect Dashboard**: Verifikasi setelah login redirect ke dashboard mahasiswa
3. ✅ **Error Handling**: Test dengan password salah
4. ✅ **Navigation**: Test navigasi setelah login berhasil

## 📸 Screenshots

Test akan membuat screenshots otomatis di folder `test-results/`:
- `01-login-page.png` - Halaman login sebelum diisi
- `02-login-form-filled.png` - Form sudah terisi
- `03-after-login.png` - Setelah klik login
- `04-mahasiswa-dashboard.png` - Dashboard mahasiswa
- Dan lain-lain...

## 📊 Melihat Hasil Test

Setelah test selesai:
```powershell
# Buka HTML report
npx playwright show-report

# Lihat screenshots
cd test-results
# Buka file .png dengan image viewer
```

## 🐛 Troubleshooting

### "Connection Refused" atau "Timeout"
**Penyebab**: Server belum running atau baseURL salah  
**Solusi**: 
1. Pastikan aplikasi bisa diakses di browser manual
2. Update `baseURL` di `playwright.config.js` dengan URL yang benar

### Test stuck di login page
**Penyebab**: Selector element mungkin berbeda  
**Solusi**: Jalankan dengan `--debug` untuk inspect element

### "User not found" atau login gagal
**Penyebab**: User belum ada di database  
**Solusi**: 
```powershell
php artisan db:seed --class=RealMahasiswaSeeder
```

## 💡 Tips Testing

1. **Gunakan --headed** untuk melihat browser action
2. **Gunakan --debug** untuk step-by-step debugging
3. **Gunakan --ui** untuk interactive mode
4. Check console log di test output untuk detail info
5. Screenshots tersimpan otomatis saat test gagal

## 📞 Jika Masih Error

Coba manual test dulu:
1. Buka browser
2. Akses URL aplikasi Anda
3. Login manual dengan NIM: 6705300038, Password: mahasiswa123
4. Jika berhasil, berarti server OK, tinggal fix baseURL di playwright config
5. Jika gagal, berarti masalah di aplikasi/database

---

**File Test**: `tests/e2e/mahasiswa-login-real.spec.js`  
**Config**: `playwright.config.js`  
**Seeder**: `database/seeders/RealMahasiswaSeeder.php`
