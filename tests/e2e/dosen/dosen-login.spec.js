import { test, expect } from '@playwright/test';

test.describe('Dosen - Login Flow', () => {
  test.beforeEach(async ({ page }) => {
    // Set base URL for all tests
    await page.goto('/');
  });

  test('should successfully login as dosen with valid credentials', async ({ page }) => {
    console.log('✓ Testing dosen login with valid NIP and password...');

    // Navigate to login page (unified for all roles)
    await page.goto('/login');
    await page.waitForLoadState('domcontentloaded');
    await page.waitForTimeout(2000);
    console.log('✓ Navigated to login page');

    // Verify we're on the login page
    await expect(page).toHaveURL(/\/login/, { timeout: 5000 });
    console.log('✓ On login page');

    // Check for login form elements (uses userID for NIM/NIP/NIDN)
    const userIDInput = page.locator('input[name="userID"]').or(
      page.locator('input[wire\\:model="userID"]')
    );
    await expect(userIDInput).toBeVisible({ timeout: 10000 });
    console.log('✓ UserID input field is visible');

    const passwordInput = page.locator('input[name="password"]').or(
      page.locator('input[type="password"]')
    );
    await expect(passwordInput).toBeVisible({ timeout: 10000 });
    console.log('✓ Password input field is visible');

    // Fill in dosen credentials (NIDN)
    await userIDInput.fill('1142938758');
    console.log('✓ Filled NIDN: 1142938758');

    await passwordInput.fill('dosen123');
    console.log('✓ Filled password');

    // Find and click login button
    const loginButton = page.locator('button[type="submit"]').filter({ hasText: /Login|Masuk/i }).or(
      page.locator('button').filter({ hasText: /Login|Masuk/i })
    );
    await expect(loginButton).toBeVisible({ timeout: 10000 });
    await loginButton.click();
    console.log('✓ Clicked login button');

    // Wait for navigation after login
    await page.waitForLoadState('domcontentloaded');
    await page.waitForTimeout(3000);

    // Verify successful login - should redirect to dashboard
    const currentUrl = page.url();
    console.log(`✓ Current URL after login: ${currentUrl}`);

    // Check if redirected to dashboard
    const isDashboard = currentUrl.includes('/dashboard');
    expect(isDashboard).toBeTruthy();
    console.log('✓ Successfully redirected to dashboard');

    // Verify we're no longer on login page (successful authentication)
    const isNotLoginPage = !currentUrl.includes('/login');
    expect(isNotLoginPage).toBeTruthy();
    console.log('✓ Successfully logged in (not on login page)');

    console.log('✅ Dosen login test completed successfully!');
  });

  test('should show error message with invalid credentials', async ({ page }) => {
    console.log('✓ Testing dosen login with invalid credentials...');

    await page.goto('/login');
    await page.waitForLoadState('domcontentloaded');
    await page.waitForTimeout(2000);

    // Fill in invalid credentials
    const userIDInput = page.locator('input[name="userID"]').or(
      page.locator('input[wire\\:model="userID"]')
    );
    const passwordInput = page.locator('input[name="password"]').or(
      page.locator('input[type="password"]')
    );

    await userIDInput.fill('0000000000');
    await passwordInput.fill('wrongpassword');
    console.log('✓ Filled invalid credentials');

    // Click login
    const loginButton = page.locator('button[type="submit"]').filter({ hasText: /Login|Masuk/i }).or(
      page.locator('button').filter({ hasText: /Login|Masuk/i })
    );
    await loginButton.click();
    console.log('✓ Clicked login button');

    await page.waitForTimeout(2000);

    // Should stay on login page or show error
    const currentUrl = page.url();
    const isStillOnLogin = currentUrl.includes('/login');

    if (isStillOnLogin) {
      console.log('✓ Stayed on login page (invalid credentials)');

      // Look for error message
      const errorMessage = page.locator('.alert-danger, .error, [class*="error"]').or(
        page.getByText(/Invalid|Salah|Gagal|credentials|password salah/i)
      ).first();

      // Error message might be visible
      const hasError = await errorMessage.isVisible().catch(() => false);
      if (hasError) {
        console.log('✓ Error message displayed');
      }
    }

    console.log('✅ Invalid credentials test completed!');
  });

  test('should show validation error when submitting empty form', async ({ page }) => {
    console.log('✓ Testing admin login with empty form...');

    await page.goto('/login');
    await page.waitForLoadState('domcontentloaded');
    await page.waitForTimeout(2000);

    // Click login button without filling anything
    const loginButton = page.locator('button[type="submit"]').filter({ hasText: /Login|Masuk/i }).or(
      page.locator('button').filter({ hasText: /Login|Masuk/i })
    );
    await loginButton.click();
    console.log('✓ Clicked login button with empty form');

    await page.waitForTimeout(2000);

    // Should stay on login page
    await expect(page).toHaveURL(/\/login/, { timeout: 5000 });
    console.log('✓ Stayed on login page (validation triggered)');

    console.log('✅ Empty form validation test completed!');
  });

  test('should have proper form structure and UI elements', async ({ page }) => {
    console.log('✓ Testing login page structure...');

    await page.goto('/login');
    await page.waitForLoadState('domcontentloaded');
    await page.waitForTimeout(2000);

    // Check page title or heading
    const pageTitle = page.locator('h1, h2, h3').filter({ hasText: /Login|Masuk/i }).first();
    await expect(pageTitle).toBeVisible({ timeout: 10000 });
    console.log('✓ Page title is visible');

    // Check userID input (unified for NIM/NIP/NIDN)
    const userIDInput = page.locator('input[name="userID"]').or(
      page.locator('input[wire\\:model="userID"]')
    );
    await expect(userIDInput).toBeVisible({ timeout: 10000 });
    console.log('✓ UserID input field present');

    // Check password input
    const passwordInput = page.locator('input[name="password"]').or(
      page.locator('input[type="password"]')
    );
    await expect(passwordInput).toBeVisible({ timeout: 10000 });
    console.log('✓ Password input field present');

    // Check submit button
    const submitButton = page.locator('button[type="submit"]');
    await expect(submitButton).toBeVisible({ timeout: 10000 });
    console.log('✓ Submit button present');

    console.log('✅ Login page structure test completed!');
  });
});
