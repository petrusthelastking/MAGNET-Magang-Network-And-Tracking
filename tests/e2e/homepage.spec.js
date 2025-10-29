import { test, expect } from '@playwright/test';

test.describe('Homepage Tests', () => {
  test('should load homepage successfully', async ({ page }) => {
    await page.goto('/');
    
    // Verify page loaded
    await expect(page).toHaveTitle(/MAGNET/);
  });

  test('should display navigation menu', async ({ page }) => {
    await page.goto('/');
    
    // Check if main navigation elements exist
    const navigation = page.locator('nav');
    await expect(navigation).toBeVisible();
  });

  test('should be responsive', async ({ page }) => {
    // Test on mobile viewport
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/');
    
    // Verify page is still accessible
    await expect(page).toHaveTitle(/MAGNET/);
  });
});
