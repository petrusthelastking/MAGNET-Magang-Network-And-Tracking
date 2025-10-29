import { expect } from '@playwright/test';

/**
 * Login helper untuk testing
 * @param {import('@playwright/test').Page} page - Playwright page object
 * @param {string} identifier - Email, NIM, atau NIP user
 * @param {string} password - Password user
 */
export async function login(page, identifier, password) {
  await page.goto('/login');
  
  // Try to find input by different selectors
  const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first();
  await identifierInput.fill(identifier);
  
  await page.fill('input[type="password"], input[name="password"]', password);
  await page.locator('button[type="submit"]').click();
  await page.waitForLoadState('networkidle');
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
  await login(page, 'TEST123456', 'password');
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
  const logoutButton = page.locator('button:has-text("Logout"), a:has-text("Logout"), form[action*="logout"] button');
  if (await logoutButton.count() > 0) {
    await logoutButton.first().click();
    await page.waitForTimeout(1000);
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
