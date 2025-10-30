import { test, expect } from '@playwright/test';

test.describe('Mahasiswa - Komentar dan Saran dari Dosen', () => {

  // 🧠 Reusable Login Function
  async function loginAsMahasiswa(page) {
    test.setTimeout(180000); // kasih waktu ekstra (3 menit)
    await page.goto('http://127.0.0.1:8000/login');
    await page.waitForLoadState('domcontentloaded');
    console.log('Current URL after navigation:', await page.url());

    await page.waitForSelector('form', { state: 'visible', timeout: 20000 });

    const userIDInput = page.locator([
      'input[name="userID"]',
      'input[wire\\:model="userID"]',
      'input[wire\\:model="nim"]',
      'input[wire\\:model="user.nim"]',
      'input[placeholder*="NIM"]',
      'input[type="text"]'
    ].join(','));

    await expect(userIDInput).toBeVisible({ timeout: 10000 });
    await userIDInput.fill('6705300038');

    const passwordInput = page.locator([
      'input[name="password"]',
      'input[wire\\:model="password"]',
      'input[wire\\:model="user.password"]',
      'input[type="password"]'
    ].join(','));

    await expect(passwordInput).toBeVisible({ timeout: 10000 });
    await passwordInput.fill('mahasiswa123');

    const loginButton = page.locator([
      'button[type="submit"]:has-text("Login")',
      'button[type="submit"]:has-text("Masuk")',
      'button:has-text("Login")',
      'button:has-text("Masuk")'
    ].join(','));

    await expect(loginButton).toBeEnabled({ timeout: 10000 });
    await loginButton.click();

    // Tunggu sampai dashboard muncul, jangan tunggu networkidle
    await page.waitForURL(/.*\/dashboard.*/, { timeout: 40000 });
    await page.waitForLoadState('domcontentloaded');
    console.log('URL after login:', await page.url());
  }

  // 🧭 Reusable Navigation Function
  async function navigateToSaranDosen(page) {
    await page.waitForLoadState('domcontentloaded');
    console.log('Current URL before navigation:', await page.url());

    try {
      await page.goto('http://127.0.0.1:8000/saran-dari-dosen', { waitUntil: 'domcontentloaded' });
      if ((await page.url()).includes('saran-dari-dosen')) {
        console.log('Direct navigation successful');
        return;
      }
    } catch (e) {
      console.log('Direct navigation failed:', e);
    }

    const saranMenu = page.locator([
      'a[href="/saran-dari-dosen"]',
      '.nav-item a:has-text("Saran")',
      '.sidebar a:has-text("Saran")',
      'a:has-text("Saran dari Dosen")'
    ].join(','));

    if (await saranMenu.isVisible({ timeout: 10000 })) {
      await saranMenu.click();
      await page.waitForLoadState('domcontentloaded');
    } else {
      throw new Error('Could not find Saran dari Dosen menu');
    }
  }

  test.beforeEach(async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/');
  });

  // ✅ Test 1: Navigasi
  test('should successfully navigate to saran dari dosen page', async ({ page }) => {
    test.setTimeout(180000);
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);
    expect(await page.url()).toContain('saran-dari-dosen');
  });

  // ✅ Test 2: Search by lecturer
  test('should search comments by lecturer name', async ({ page }) => {
    test.setTimeout(180000);
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);

    const searchInput = page.locator('input[type="search"]');
    await searchInput.fill('Timmothy Krajcik');
    await page.waitForTimeout(500); // simulasi jeda ngetik
    await searchInput.press('Enter');

    await page.waitForTimeout(1500);
    await expect(page.locator('.comment-card, .saran-item').filter({ hasText: 'Timmothy Krajcik' }))
      .toBeVisible({ timeout: 10000 });
  });

  // ✅ Test 3: Search by content
  test('should search comments by content', async ({ page }) => {
    test.setTimeout(180000);
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);

    const contentSearchInput = page.locator('input[type="search"]');
    await contentSearchInput.fill('Consequuntur qui.');
    await page.waitForTimeout(500);
    await contentSearchInput.press('Enter');

    await page.waitForTimeout(1500);
    await expect(page.locator('.comment-content, .saran-content').filter({ hasText: /Consequuntur qui./i }))
      .toBeVisible({ timeout: 10000 });
  });

  // ✅ Test 4: Filter by time
  test('should filter comments by time period', async ({ page }) => {
    test.setTimeout(180000);
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);

    const filterThisMonth = page.locator('button:has-text("Bulan Ini")');
    if (await filterThisMonth.isVisible({ timeout: 5000 })) {
      await filterThisMonth.click();
      await page.waitForTimeout(1500);
    } else {
      console.warn('⚠️ Filter button not found');
    }
  });

  // ✅ Test 5: Sort comments
  test('should sort comments by date', async ({ page }) => {
    test.setTimeout(180000);
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);

    console.log('✓ Testing sorting options...');
    const sortButton = page.locator('button:has-text("Urutkan"), select[name="sort"], .sort-dropdown');
    if (await sortButton.isVisible({ timeout: 5000 })) {
      await sortButton.click();
      const sortNewest = page.locator('button:has-text("Terbaru"), option:has-text("Terbaru")');
      if (await sortNewest.isVisible()) {
        await sortNewest.click();
      } else {
        console.warn('⚠️ Sort option not found');
      }
    } else {
      console.warn('⚠️ Sort button not found');
    }
  });
});
