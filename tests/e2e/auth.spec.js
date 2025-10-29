import { test, expect } from '@playwright/test';

test.describe('Authentication Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Navigate to login page
    await page.goto('/login');
  });

  test('should display login form', async ({ page }) => {
    // Check if login form elements exist
    await expect(page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first()).toBeVisible();
    await expect(page.locator('input[type="password"], input[name="password"]')).toBeVisible();
    await expect(page.locator('button[type="submit"]')).toBeVisible();
  });

  test('should show validation error for empty credentials', async ({ page }) => {
    // Click submit without filling form
    await page.locator('button[type="submit"]').click();
    
    // Wait for error message or validation
    await page.waitForTimeout(1000);
    
    // Should still be on login page
    expect(page.url()).toContain('/login');
  });

  test('should show error for invalid credentials', async ({ page }) => {
    // Fill form with invalid credentials
    const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first();
    await identifierInput.fill('invalid123');
    await page.fill('input[type="password"], input[name="password"]', 'wrongpassword');
    
    // Submit form
    await page.locator('button[type="submit"]').click();
    
    // Wait for response
    await page.waitForTimeout(2000);
    
    // Should show error message or stay on login page
    expect(page.url()).toContain('/login');
  });

  test('should redirect to dashboard after successful login (Admin)', async ({ page }) => {
    // Fill form with valid admin credentials (NIP)
    const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first();
    await identifierInput.fill('ADMIN001');
    await page.fill('input[type="password"], input[name="password"]', 'password');
    
    // Submit form
    await page.locator('button[type="submit"]').click();
    
    // Wait for navigation
    await page.waitForLoadState('networkidle');
    
    // Should redirect to admin dashboard
    expect(page.url()).toMatch(/\/(admin|dashboard)/);
  });
});

test.describe('Logout Tests', () => {
  test('should logout successfully', async ({ page }) => {
    // First, login as admin
    await page.goto('/login');
    const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first();
    await identifierInput.fill('ADMIN001');
    await page.fill('input[type="password"], input[name="password"]', 'password');
    await page.locator('button[type="submit"]').click();
    await page.waitForLoadState('networkidle');
    
    // Find and click logout button
    const logoutButton = page.locator('button:has-text("Logout"), a:has-text("Logout"), form[action*="logout"] button');
    await logoutButton.first().click();
    
    // Wait for logout
    await page.waitForTimeout(1000);
    
    // Should redirect to login or homepage
    expect(page.url()).toMatch(/\/(login|\/)?$/);
  });
});
