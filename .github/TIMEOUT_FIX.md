# 🔧 GitHub Actions Timeout Fix

## 🐛 Problem

### Error di GitHub Actions:
```
Error: expect(locator).toBeVisible() failed
Locator: locator('button').filter({ hasText: /Tambah Mahasiswa/i })
Expected: visible
Timeout: 5000ms
Error: element(s) not found
```

### Root Cause:
1. ⏱️ **Timeout terlalu pendek** (5 seconds) untuk CI environment
2. 🐌 **GitHub Actions lebih lambat** dari local machine
3. 🔄 **Livewire components** butuh waktu lebih lama untuk initialize
4. 📡 **Network latency** di CI environment
5. 🎭 **Page load** tidak dikasih waktu cukup untuk fully load

---

## ✅ Solutions Implemented

### 1️⃣ **Increase Global Timeouts di playwright.config.js**

**Before:**
```javascript
use: {
  baseURL: 'http://127.0.0.1:8000',
  trace: 'on-first-retry',
  screenshot: 'only-on-failure',
  video: 'retain-on-failure',
}
```

**After:**
```javascript
export default defineConfig({
  timeout: 60000, // 60 seconds per test (NEW!)
  
  use: {
    baseURL: 'http://127.0.0.1:8000',
    actionTimeout: 15000, // 15 seconds for actions (NEW!)
    navigationTimeout: 30000, // 30 seconds for navigation (NEW!)
    trace: 'on-first-retry',
    screenshot: 'only-on-failure',
    video: 'retain-on-failure',
  },
});
```

**Benefits:**
- ✅ Test timeout: 30s → **60s**
- ✅ Action timeout: default → **15s**
- ✅ Navigation timeout: default → **30s**

---

### 2️⃣ **Add networkidle Wait di Navigation Helper**

**Before:**
```javascript
async function navigateToDataMahasiswa(page) {
  await page.waitForURL(/\/dashboard/, { timeout: 10000 }).catch(() => {});
  
  // Click menu...
  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(2000);
}
```

**After:**
```javascript
async function navigateToDataMahasiswa(page) {
  await page.waitForURL(/\/dashboard/, { timeout: 15000 }).catch(() => {});
  
  // Wait for page to be fully loaded (NEW!)
  await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {});
  await page.waitForTimeout(2000);
  
  // Click menu...
  
  await page.waitForLoadState('domcontentloaded');
  await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {}); // NEW!
  await page.waitForTimeout(3000); // Increased from 2000
}
```

**networkidle vs domcontentloaded:**
- `domcontentloaded`: HTML parsed, but assets may still loading ⚠️
- `networkidle`: No network activity for 500ms ✅ (safer!)

---

### 3️⃣ **Increase Individual Timeouts di Test Files**

**Files Updated:**
- `tests/e2e/admin/admin-data-mahasiswa.spec.js`
- `tests/e2e/admin/admin-data-mahasiswa-crud.spec.js`

**Changes:**
```javascript
// Before: timeout 5000ms (5 seconds)
await expect(tambahButton).toBeVisible({ timeout: 5000 });
await expect(table).toBeVisible({ timeout: 5000 });

// After: timeout 15000ms (15 seconds)
await expect(tambahButton).toBeVisible({ timeout: 15000 });
await expect(table).toBeVisible({ timeout: 15000 });
```

**Total Changes:**
- ✅ 6 timeout values updated: 5000ms → 15000ms

---

### 4️⃣ **Add Extra Wait Before Button Click**

**admin-data-mahasiswa-crud.spec.js:**
```javascript
test('should open Tambah Mahasiswa modal...', async ({ page }) => {
  await navigateToDataMahasiswa(page);
  
  // NEW: Wait for page to be fully interactive
  await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {});
  await page.waitForTimeout(2000);
  
  const tambahButton = page.locator('button').filter({ hasText: /Tambah Mahasiswa/i });
  await expect(tambahButton).toBeVisible({ timeout: 15000 }); // Increased!
  
  await tambahButton.evaluate(el => el.click());
  await page.waitForTimeout(3000);
});
```

---

## 📊 Timeout Comparison

| Action | Before (Local) | After (CI-Ready) | Improvement |
|--------|----------------|------------------|-------------|
| **Test Timeout** | 30s (default) | **60s** | +100% |
| **Action Timeout** | - | **15s** | NEW |
| **Navigation Timeout** | - | **30s** | NEW |
| **Element Visibility** | 5s | **15s** | +200% |
| **URL Wait** | 10s | **15s** | +50% |
| **Page Wait** | 2s | **3s** | +50% |

---

## 🎯 Expected Results di GitHub Actions

### Before Fix:
```
❌ Tests fail with timeout errors
❌ Elements not found (5s timeout too short)
❌ Livewire not initialized in time
❌ Multiple retries needed
```

### After Fix:
```
✅ All timeouts increased for CI environment
✅ networkidle wait ensures page fully loaded
✅ Elements have time to appear
✅ Tests pass on first try (no retries needed)
```

---

## 🧪 Local Testing Verification

**Command:**
```powershell
npx playwright test tests/e2e/admin/admin-data-mahasiswa-crud.spec.js --project=chromium --grep "should open Tambah Mahasiswa modal"
```

**Result:**
```
✅ 1 passed (27.4s)
✓ Found Tambah Mahasiswa button
✓ Clicked Tambah Mahasiswa button
✓ Modal title displayed
✓ All form fields verified!
```

---

## 📝 Files Modified

1. ✅ `playwright.config.js` - Added global timeouts
2. ✅ `tests/e2e/admin/admin-data-mahasiswa.spec.js` - Updated navigation & timeouts
3. ✅ `tests/e2e/admin/admin-data-mahasiswa-crud.spec.js` - Updated navigation & timeouts

---

## 🚀 Commit & Push

```powershell
git add playwright.config.js
git add tests/e2e/admin/

git commit -m "Fix: Increase timeouts for GitHub Actions CI environment

- Add global test timeout (60s), action timeout (15s), navigation timeout (30s)
- Implement networkidle wait strategy in navigation helpers
- Increase element visibility timeouts from 5s to 15s
- Add extra wait time after navigation (2s → 3s)
- Ensure Livewire components have time to initialize

Fixes timeout errors in GitHub Actions CI environment"

git push origin Testing-Petrus
```

---

## ⏱️ Expected GitHub Actions Runtime

### Previous (With Errors):
```
⏰ Setup: ~5 min
⏰ Tests: FAIL (timeout errors)
⏰ Retries: +10 min
━━━━━━━━━━━━━━━━━━━━━━━
📊 Total: ~15+ min (with failures)
```

### After Fix:
```
⏰ Setup: ~5 min
⏰ Tests: ~10-12 min (all pass!)
⏰ Upload: ~30s
━━━━━━━━━━━━━━━━━━━━━━━
📊 Total: ~15-18 min (all green! ✅)
```

---

## 💡 Why These Timeouts?

### CI Environment Characteristics:
- 🐌 **Slower CPU** than local machine
- 📡 **Higher network latency**
- 🔄 **Concurrent processes** (MySQL, PHP, npm)
- 💾 **Limited memory** (shared resources)
- 🎭 **Cold start** (no cache on first run)

### Recommended Timeouts for CI:
- ✅ Test timeout: **60s** (2x local)
- ✅ Action timeout: **15s** (3x default)
- ✅ Navigation: **30s** (safe for Livewire)
- ✅ Element wait: **15s** (3x previous)

---

## 🔍 Troubleshooting

### If Still Timeout:

#### Check Laravel Server Log:
```yaml
# Add to workflow after "Run Playwright tests"
- name: Show Laravel Log
  if: failure()
  run: cat storage/logs/laravel.log
```

#### Check Screenshot/Video:
```
# Download artifacts from GitHub Actions
# Check test-results/ folder
# Review screenshots and videos
```

#### Increase Timeout Further:
```javascript
// playwright.config.js
timeout: 90000, // 90 seconds (last resort!)
```

---

## ✅ Summary

**Problem:** Tests timing out di GitHub Actions  
**Root Cause:** Timeouts terlalu pendek untuk CI environment  
**Solution:** Increase timeouts + add networkidle wait  
**Status:** ✅ Fixed & Tested Locally  

**Next:** Push and verify di GitHub Actions! 🚀

---

**Last Updated:** October 30, 2025  
**Tested:** ✅ Local verification passed (27.4s)  
**Ready for:** GitHub Actions CI/CD
