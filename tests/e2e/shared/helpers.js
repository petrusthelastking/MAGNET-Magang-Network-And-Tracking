import { expect } from '@playwright/test';

/**
 * Login helper untuk testing
 * @param {import('@playwright/test').Page} page - Playwright page object
 * @param {string} identifier - Email, NIM, atau NIP user
 * @param {string} password - Password user
 */
export async function login(page, identifier, password) {
  await page.goto('/login');
  await page.waitForLoadState('domcontentloaded');
  await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {});
  await page.waitForTimeout(2000);

  // Fill identifier (NIM/NIDN/NIP)
  const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"], input[name="userID"], input[wire\\:model="userID"]').first();
  await identifierInput.waitFor({ state: 'visible', timeout: 10000 });
  await identifierInput.fill(identifier);
  await page.waitForTimeout(500);

  // Fill password
  const passwordInput = page.locator('input[type="password"], input[name="password"]').first();
  await passwordInput.waitFor({ state: 'visible', timeout: 10000 });
  await passwordInput.fill(password);
  await page.waitForTimeout(500);

  // Click submit button and wait for navigation
  const submitButton = page.locator('button[type="submit"]').filter({ hasText: /Masuk|Login/i }).first();
  await submitButton.waitFor({ state: 'visible', timeout: 10000 });
  await submitButton.click();

  // Wait for navigation to complete - wait for dashboard
  await page.waitForURL(/\/dashboard/, { timeout: 30000 }).catch(async () => {
    // If not redirected to dashboard, check if still on login (error case)
    const currentUrl = page.url();
    console.log(`⚠ Login may have failed. Current URL: ${currentUrl}`);

    // Take screenshot for debugging
    if (currentUrl.includes('/login')) {
      throw new Error('Login failed - still on login page');
    }
  });

  await page.waitForLoadState('domcontentloaded');
  await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {});
  await page.waitForTimeout(2000);

  console.log(`✓ Successfully logged in as ${identifier}`);
}

/**
 * Login sebagai admin
 */
export async function loginAsAdmin(page) {
  await login(page, 'ADMIN001', 'password');
}

/**
 * Login sebagai mahasiswa
 */
export async function loginAsMahasiswa(page) {
  await login(page, '9743195802', 'testing123');
}

/**
 * Login sebagai perusahaan
 */
export async function loginAsPerusahaan(page) {
  await login(page, 'perusahaan@example.com', 'password');
}

/**
 * Logout helper
 */
export async function logout(page) {
  try {
    // Simply go to logout route if it exists
    await page.goto('/logout', { waitUntil: 'domcontentloaded', timeout: 5000 }).catch(() => {});
    await page.waitForTimeout(500);

    // Or look for user menu/dropdown button (avatar or name button)
    const userMenuButton = page.locator('[data-flux-dropdown-toggle], button[aria-haspopup="true"], button[aria-label*="menu" i], button:has(img[alt*="avatar" i])').first();

    // If dropdown exists and visible, click to open it first
    if (await userMenuButton.count() > 0 && await userMenuButton.isVisible().catch(() => false)) {
      await userMenuButton.click({ timeout: 3000 }).catch(() => {});
      await page.waitForTimeout(500); // Wait for dropdown animation

      // Now look for logout button (should be visible after dropdown opened)
      const logoutButton = page.locator('button:has-text("Logout"), a:has-text("Logout"), form[action*="logout"] button, button:has-text("Keluar")').first();

      if (await logoutButton.count() > 0 && await logoutButton.isVisible().catch(() => false)) {
        await logoutButton.click({ timeout: 3000 }).catch(() => {});
        await page.waitForTimeout(1000);
      }
    }
  } catch (error) {
    // Ignore logout errors - not critical for tests
    console.log('Logout skipped or failed (non-critical)');
  }
}

/**
 * Check if user is authenticated
 */
export async function isAuthenticated(page) {
  const logoutButton = page.locator('button:has-text("Logout"), a:has-text("Logout")');
  return (await logoutButton.count()) > 0;
}

/**
 * Fill form field helper
 */
export async function fillField(page, selector, value) {
  await page.locator(selector).fill(value);
}

/**
 * Click button helper with wait
 */
export async function clickButton(page, selector) {
  await page.locator(selector).click();
  await page.waitForTimeout(500);
}

/**
 * Wait for table to load
 */
export async function waitForTable(page) {
  await page.waitForSelector('table', { state: 'visible', timeout: 10000 });
}

/**
 * Take screenshot with name
 */
export async function takeScreenshot(page, name) {
  await page.screenshot({ path: `tests/e2e/screenshots/${name}.png`, fullPage: true });
}

/**
 * Check if element exists
 */
export async function elementExists(page, selector) {
  return (await page.locator(selector).count()) > 0;
}

/**
 * Get table row count
 */
export async function getTableRowCount(page) {
  return await page.locator('table tbody tr').count();
}

/**
 * Assert alert or notification exists
 */
export async function assertNotification(page, message) {
  const notification = page.locator('.alert, .notification, [role="alert"]').filter({ hasText: message });
  await expect(notification.first()).toBeVisible({ timeout: 5000 });
}
