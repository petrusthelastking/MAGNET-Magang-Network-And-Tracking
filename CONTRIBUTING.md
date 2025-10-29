# 🤝 Contributing to MAGNET

Terima kasih sudah berkontribusi di project MAGNET! Panduan ini akan membantu Anda memahami workflow dan best practices untuk bekerja dalam tim.

---

## 📁 Struktur Project

```
MAGNET-Magang-Network-And-Tracking/
│
├── app/                          # Laravel application logic
│   ├── Http/Controllers/         # Controllers
│   ├── Models/                   # Eloquent models
│   ├── Livewire/                 # Livewire components
│   └── Repositories/             # Repository pattern
│
├── resources/                    # Frontend resources
│   ├── views/                    # Blade templates
│   ├── js/                       # JavaScript files
│   └── css/                      # CSS files
│
├── tests/                        # Testing files
│   ├── e2e/                      # Playwright E2E tests
│   ├── Feature/                  # Laravel feature tests
│   └── Unit/                     # Unit tests
│
├── database/                     # Database related
│   ├── migrations/               # Database migrations
│   ├── seeders/                  # Data seeders
│   └── factories/                # Model factories
│
├── scripts/                      # Helper scripts
│   └── testing/                  # Testing helper scripts
│
├── docs/                         # Documentation
│   ├── testing/                  # Testing documentation
│   ├── class-diagram/            # Class diagrams
│   └── sequence-diagram/         # Sequence diagrams
│
├── public/                       # Public accessible files
└── storage/                      # Storage for logs, cache, etc.
```

---

## 🚀 Getting Started (Setup Local)

### 1️⃣ Clone Repository

```bash
git clone https://github.com/Maju-Lancar/MAGNET-Magang-Network-And-Tracking.git
cd MAGNET-Magang-Network-And-Tracking
```

### 2️⃣ Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3️⃣ Setup Environment

```bash
# Copy .env file
cp .env.example .env

# Generate application key
php artisan key:generate
```

**Update `.env` file:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=magnet
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Setup Database

```bash
# Create database (via MySQL)
mysql -u root -e "CREATE DATABASE magnet;"

# Run migrations
php artisan migrate

# Seed data (optional)
php artisan db:seed
```

### 5️⃣ Build Frontend Assets

```bash
npm run build
```

### 6️⃣ Start Development Server

```bash
php artisan serve
```

Buka browser: http://127.0.0.1:8000

---

## 🔀 Git Workflow

### Branch Strategy

```
main (production)
  ↓
develop (integration)
  ↓
feature/nama-fitur (development)
```

### Membuat Feature Baru

```bash
# 1. Update branch develop terbaru
git checkout develop
git pull origin develop

# 2. Buat branch feature baru
git checkout -b feature/nama-fitur

# 3. Kerjakan fitur...

# 4. Commit changes
git add .
git commit -m "feat: deskripsi fitur"

# 5. Push ke remote
git push origin feature/nama-fitur

# 6. Buat Pull Request ke develop
```

### Commit Message Convention

Gunakan format: `<type>: <description>`

**Types:**
- `feat:` Fitur baru
- `fix:` Bug fix
- `docs:` Perubahan dokumentasi
- `style:` Format code (tidak mengubah logic)
- `refactor:` Refactoring code
- `test:` Menambah/update tests
- `chore:` Maintenance tasks

**Contoh:**
```bash
git commit -m "feat: add mahasiswa dashboard"
git commit -m "fix: resolve login redirect issue"
git commit -m "test: add E2E test for login flow"
git commit -m "docs: update testing guide"
```

---

## 🧪 Testing

### Run Tests Sebelum Commit

```bash
# Laravel tests
php artisan test

# Playwright E2E tests
npx playwright test

# Atau test spesifik
npx playwright test tests/e2e/mahasiswa-login-real.spec.js
```

### Membuat Test Baru

**Untuk E2E Test (Playwright):**

1. Buat file baru di `tests/e2e/`
2. Ikuti template di `docs/testing/README.md`
3. Run test untuk memastikan passing
4. Commit test file

**Contoh:**
```javascript
// tests/e2e/nama-fitur.spec.js
import { test, expect } from '@playwright/test';

test.describe('Nama Fitur Test', () => {
  test('should do something', async ({ page }) => {
    await page.goto('/halaman');
    // ... test logic
  });
});
```

---

## 📝 Code Style Guide

### PHP (Laravel)

```php
// ✅ Good
class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('mahasiswa.index', compact('mahasiswa'));
    }
}

// ❌ Bad - inconsistent spacing/naming
class mahasiswa_controller extends Controller{
    public function Index(){
        $data=Mahasiswa::all();
        return view('mahasiswa.index',compact('data'));
    }
}
```

### JavaScript

```javascript
// ✅ Good
const submitForm = async () => {
  const response = await fetch('/api/mahasiswa');
  const data = await response.json();
  return data;
};

// ❌ Bad - no const/let, inconsistent naming
var submit_form = async () => {
  var response = await fetch('/api/mahasiswa')
  var Data = await response.json()
  return Data
}
```

### Blade Templates

```html
<!-- ✅ Good -->
<div class="container mx-auto p-4">
    @foreach ($mahasiswa as $mhs)
        <div class="card">
            <h3>{{ $mhs->nama }}</h3>
            <p>{{ $mhs->nim }}</p>
        </div>
    @endforeach
</div>

<!-- ❌ Bad - inconsistent indentation -->
<div class="container mx-auto p-4">
@foreach($mahasiswa as $mhs)
<div class="card">
<h3>{{$mhs->nama}}</h3>
<p>{{$mhs->nim}}</p>
</div>
@endforeach
</div>
```

---

## 🐛 Debugging

### Laravel Debugging

```bash
# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Check logs
tail -f storage/logs/laravel.log

# Tinker console
php artisan tinker
```

### Database Issues

```bash
# Reset database (WARNING: deletes all data)
php artisan migrate:fresh --seed

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Frontend Build Issues

```bash
# Clear node modules
rm -rf node_modules
npm install

# Clear npm cache
npm cache clean --force
npm install

# Rebuild assets
npm run build
```

---

## 📚 Resources & Links

### Documentation
- **[Testing Guide](docs/testing/README.md)** - Panduan lengkap testing
- **[Playwright Docs](https://playwright.dev/)** - Playwright official docs
- **[Laravel Docs](https://laravel.com/docs)** - Laravel documentation
- **[Livewire Docs](https://livewire.laravel.com/)** - Livewire documentation

### Tools
- **[DBeaver](https://dbeaver.io/)** - Database management
- **[Postman](https://www.postman.com/)** - API testing
- **[VS Code](https://code.visualstudio.com/)** - Code editor

### Extensions (VS Code)
- Laravel Blade Snippets
- PHP Intelephense
- Prettier - Code formatter
- GitLens
- Playwright Test for VS Code

---

## 🔒 Security

**JANGAN pernah commit:**
- `.env` file dengan credentials asli
- Database dumps dengan data production
- API keys atau secrets
- Personal access tokens

**Jika tidak sengaja commit sensitive data:**
1. Hapus file dari Git history
2. Revoke credentials yang ter-expose
3. Update secrets di production

---

## 🆘 Need Help?

- **Issues:** [GitHub Issues](https://github.com/Maju-Lancar/MAGNET-Magang-Network-And-Tracking/issues)
- **Discussions:** [GitHub Discussions](https://github.com/Maju-Lancar/MAGNET-Magang-Network-And-Tracking/discussions)
- **Contact Team Lead:** Lihat bagian Contributors di README.md

---

## ✅ Checklist Sebelum Pull Request

- [ ] Code sudah di-test locally
- [ ] Semua tests passing (`php artisan test && npx playwright test`)
- [ ] Code mengikuti style guide
- [ ] Dokumentasi sudah diupdate (jika perlu)
- [ ] Commit messages mengikuti convention
- [ ] No sensitive data ter-commit
- [ ] Branch up-to-date dengan develop

---

**Happy Coding! 🚀**
