# Quick Start - GitHub Actions E2E Testing

## 🚀 Setup Selesai!

File workflow sudah dibuat di:
- `.github/workflows/e2e-testing.yml` ✅
- `.github/workflows/quick-e2e.yml` ✅

---

## 📝 Langkah Selanjutnya:

### 1️⃣ Push ke GitHub

```bash
git add .github/
git commit -m "Add GitHub Actions workflows for E2E testing"
git push origin Testing-Petrus
```

### 2️⃣ Cek di GitHub

1. Buka repository di GitHub
2. Klik tab **"Actions"**
3. Akan muncul 2 workflows:
   - **E2E Testing** (otomatis)
   - **Quick E2E Test** (manual)

---

## 🎯 Cara Menggunakan

### Otomatis (Push/PR):

Setiap kali push atau buat PR ke `main`, `develop`, atau `Testing-Petrus`, workflow akan jalan otomatis.

### Manual (Quick Test):

1. Buka tab **Actions**
2. Pilih **"Quick E2E Test"**
3. Klik **"Run workflow"** (kanan atas)
4. Pilih role: `admin`, `mahasiswa`, atau `all`
5. Klik **"Run workflow"** (hijau)
6. Tunggu selesai (~5-10 menit)

---

## 📊 Lihat Hasil Test

### Status Summary:
- Di halaman Actions, lihat checkmark (✅) atau X (❌)

### Detail Results:
1. Klik workflow run
2. Klik job name (Admin/Mahasiswa)
3. Lihat log detail di setiap step

### Download Reports:
- Scroll ke bawah
- Bagian **"Artifacts"**
- Download ZIP results
- Extract dan buka `playwright-report/index.html`

---

## 🎨 Add Badge ke README (Optional)

Tambahkan di `README.md`:

```markdown
[![E2E Testing](https://github.com/petrusthelastking/MAGNET-Magang-Network-And-Tracking/actions/workflows/e2e-testing.yml/badge.svg)](https://github.com/petrusthelastking/MAGNET-Magang-Network-And-Tracking/actions/workflows/e2e-testing.yml)
```

Hasilnya akan tampil badge status test di README.

---

## ✅ Expected Results

Setelah workflow jalan, expected results:

### Admin Tests (16 tests):
- Login flow (4 tests)
- Data mahasiswa management (7 tests)
- CRUD operations (5 tests)

### Mahasiswa Tests (11 tests):
- Login flow (4 tests)
- Pengajuan magang (7 tests)

### Total: 27 tests - All should pass ✅

---

## 💡 Tips

1. **First run** mungkin butuh waktu ~10-15 menit (download dependencies)
2. **Subsequent runs** lebih cepat karena cache
3. **Check logs** jika ada yang fail
4. **Download artifacts** untuk detailed report

---

## 🐛 Jika Ada Masalah

### Workflow tidak muncul:
- Pastikan file ada di `.github/workflows/`
- Pastikan format YAML benar (no syntax error)
- Refresh halaman Actions

### Tests failed:
- Download artifacts
- Lihat screenshots di `test-results/`
- Check error message di logs
- Fix locally dan push lagi

### Server timeout:
- Normal di first run
- Retry workflow
- Check server logs di job output

---

## 📚 Dokumentasi Lengkap

Lihat: `.github/GITHUB_ACTIONS_GUIDE.md`

---

**Ready to Go! 🎉**

Push file workflow ke GitHub dan test akan otomatis jalan!
