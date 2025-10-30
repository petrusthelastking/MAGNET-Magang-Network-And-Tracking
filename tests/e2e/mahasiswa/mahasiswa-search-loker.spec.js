import { test, expect } from '@playwright/test';

const BASE_URL = 'http://127.0.0.1:8000';

test.describe('Mahasiswa - Search Lowongan Magang', () => {
  
  // Reusable selectors
  const selectors = {
    userID: [
      'input[name="userID"]',
      'input[wire\\:model="userID"]',
      'input[wire\\:model="nim"]',
      'input[wire\\:model="user.nim"]',
      'input[placeholder*="NIM"]'
    ].join(','),
    password: [
      'input[name="password"]',
      'input[wire\\:model="password"]',
      'input[wire\\:model="user.password"]',
      'input[type="password"]'
    ].join(','),
    loginButton: [
      'button:has-text("Login")',
      'button:has-text("Masuk")',
      'input[type="submit"][value="Login"]',
      'input[type="submit"][value="Masuk"]'
    ].join(','),
    searchInput: [
      'input[wire\\:model*="search"]',
      'input[wire\\:model*="keyword"]',
      'input[name="search"]',
      'input[placeholder*="Cari"]',
      'input[placeholder*="Search"]',
      'input[type="search"]'
    ].join(','),
    searchButton: [
      '[wire\\:click*="search"]',
      'button[type="submit"]',
      'button:has-text("Cari")',
      'button:has-text("Search")',
      'button:has-text("Temukan")'
    ].join(','),
  };

  // Reusable login function
  async function loginAsMahasiswa(page) {
    await page.goto(`${BASE_URL}/login`);
    await page.waitForSelector(selectors.userID, { timeout: 10000 });

    await page.fill(selectors.userID, '6705300038');
    await page.fill(selectors.password, 'mahasiswa123');
    await page.click(selectors.loginButton);

    await page.waitForURL(/\/dashboard/, { timeout: 10000 });
    await expect(page).toHaveURL(/\/dashboard/);
  }

  // Before each test: start fresh
  test.beforeEach(async ({ page }) => {
    await page.goto(BASE_URL);
  });

  test('should login as mahasiswa successfully', async ({ page }) => {
    await loginAsMahasiswa(page);
    console.log('✅ Logged in as mahasiswa');
  });

  test('should search using Enter key when no button is available', async ({ page }) => {
    await loginAsMahasiswa(page);

    const searchInput = page.locator(selectors.searchInput);
    await expect(searchInput).toBeVisible({ timeout: 10000 });

    await searchInput.fill('Frontend Developer');

    // Press Enter to trigger search (for input-based search)
    await searchInput.press('Enter');

    // Wait for network and Livewire to update
    await page.waitForLoadState('networkidle');
    await page.waitForSelector('.lowongan-list, .search-results, .magang-list', { timeout: 10000 });
    
    const resultContent = await page.textContent('.lowongan-list, .search-results, .magang-list');
    expect(resultContent.toLowerCase()).toContain('frontend developer');
  });

  test('should show empty results message when no match found', async ({ page }) => {
    await loginAsMahasiswa(page);

    const searchInput = page.locator(selectors.searchInput);
    await searchInput.fill('XYZ123NonExistentPosition999');
    await searchInput.press('Enter');
    await page.waitForLoadState('networkidle');

    const noResults = page.locator([
      '.no-results',
      '.empty-results',
      '.alert:has-text("Tidak ditemukan")',
      'div:has-text("Tidak ada hasil")'
    ].join(','));
    
    await expect(noResults).toBeVisible({ timeout: 10000 });
  });
});
