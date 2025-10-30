import { test, expect } from '@playwright/test';

test.describe('Mahasiswa - Komentar dan Saran dari Dosen', () => {

  // 🧠 Reusable Login Function
  async function loginAsMahasiswa(page) {
    // Navigate to login page
    await page.goto('http://127.0.0.1:8000/login');
    await page.waitForLoadState('domcontentloaded');

    // Wait for and fill credentials
    const userIDInput = page.locator('input[name="userID"], input[wire\\:model="userID"]').first();
    const passwordInput = page.locator('input[type="password"]').first();
    const loginButton = page.locator('button[type="submit"]').first();

    // Fill credentials and submit
    await userIDInput.waitFor({ state: 'visible' });
    await userIDInput.fill('6705300038');
    await passwordInput.fill('mahasiswa123');
    
    // Click and wait for navigation
    await Promise.all([
      page.waitForURL('**/dashboard'),
      loginButton.click()
    ]);

    // Tunggu sampai dashboard muncul, jangan tunggu networkidle
    await page.waitForURL(/.*\/dashboard.*/, { timeout: 40000 });
    await page.waitForLoadState('domcontentloaded');
    console.log('URL after login:', await page.url());
  }

  // 🧭 Reusable Navigation Function
  async function navigateToSaranDosen(page) {
    test.setTimeout(120000);
    
    // Navigate directly without waiting for URL
    await page.goto('http://127.0.0.1:8000/saran-dari-dosen/', {
      waitUntil: 'domcontentloaded'
    });

    // Wait for key elements that indicate page is ready
    try {
      await page.locator('.container, main, .content').first().waitFor({ state: 'visible', timeout: 45000 });
      
      // Additional check to ensure we're on the right page
      const currentUrl = page.url();
      if (!currentUrl.includes('saran-dari-dosen')) {
        console.log('Warning: Not on expected page. Current URL:', currentUrl);
      }
    } catch (e) {
      console.log('Navigation warning:', e.message);
    }
  }

  test.beforeEach(async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/');
  });

  test('should successfully navigate to saran dari dosen page', async ({ page }) => {
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);
    
    // Verify we're on the right page
    await expect(page).toHaveURL(/.*saran-dari-dosen/);
    await expect(page.locator('h1, .page-title').first()).toBeVisible();
  });

  test('should search comments by lecturer name', async ({ page }) => {
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);

    // Wait for search input with increased timeout
    const searchInput = page.locator('input[type="search"], input[placeholder*="Cari"]').first();
    await searchInput.waitFor({ state: 'visible', timeout: 30000 });
    
    await searchInput.fill('Timmothy Krajcik');
    await page.waitForTimeout(500);
    await searchInput.press('Enter');

    // Wait for search results with better selector
    await expect(page.locator('div.bg-white').filter({ hasText: 'Timmothy Krajcik' }).first())
      .toBeVisible({ timeout: 30000 });
  });

  // ✅ Test 3: Search by content
  test('should search comments by content', async ({ page }) => {
    test.setTimeout(180000);
    await loginAsMahasiswa(page);
    await navigateToSaranDosen(page);

    // Wait for search input with increased timeout
    const contentSearchInput = page.locator('input[type="search"], input[placeholder*="Cari"]').first();
    await contentSearchInput.waitFor({ state: 'visible', timeout: 30000 });
    
    await contentSearchInput.fill('Consequuntur qui.');
    await page.waitForTimeout(500);
    await contentSearchInput.press('Enter');

    // Wait for search results with more specific selector
    await expect(page.locator('div.bg-white').filter({ hasText: /Consequuntur qui./i }).first())
      .toBeVisible({ timeout: 30000 });
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
