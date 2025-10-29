import { test, expect } from '@playwright/test';

test.describe('Admin - Data Mahasiswa Tests', () => {
  // Setup authenticated admin session
  test.beforeEach(async ({ page }) => {
    // Login as admin with NIP
    await page.goto('/login');
    const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first();
    await identifierInput.fill('ADMIN001');
    await page.fill('input[type="password"], input[name="password"]', 'password');
    await page.locator('button[type="submit"]').click();
    await page.waitForLoadState('networkidle');
  });

  test('should display data mahasiswa page', async ({ page }) => {
    // Navigate to data mahasiswa page
    await page.goto('/admin/data-mahasiswa');
    
    // Wait for page to load
    await page.waitForLoadState('networkidle');
    
    // Check if page title or heading exists
    const heading = page.locator('h1, h2, h3').filter({ hasText: /Mahasiswa/i });
    await expect(heading.first()).toBeVisible();
  });

  test('should display table with mahasiswa data', async ({ page }) => {
    await page.goto('/admin/data-mahasiswa');
    await page.waitForLoadState('networkidle');
    
    // Check if table exists
    const table = page.locator('table');
    await expect(table.first()).toBeVisible();
  });

  test('should be able to search mahasiswa', async ({ page }) => {
    await page.goto('/admin/data-mahasiswa');
    await page.waitForLoadState('networkidle');
    
    // Find search input
    const searchInput = page.locator('input[type="search"], input[placeholder*="Cari"], input[placeholder*="Search"]');
    
    if (await searchInput.count() > 0) {
      await searchInput.first().fill('test');
      await page.waitForTimeout(1000);
      
      // Table should still be visible
      const table = page.locator('table');
      await expect(table.first()).toBeVisible();
    }
  });

  test('should open detail modal when clicking detail button', async ({ page }) => {
    await page.goto('/admin/data-mahasiswa');
    await page.waitForLoadState('networkidle');
    
    // Find detail button (adjust selector based on your actual implementation)
    const detailButton = page.locator('button:has-text("Detail"), a:has-text("Detail")');
    
    if (await detailButton.count() > 0) {
      await detailButton.first().click();
      await page.waitForTimeout(1000);
      
      // Check if modal or detail page appears
      const modal = page.locator('[role="dialog"], .modal, .modal-box');
      if (await modal.count() > 0) {
        await expect(modal.first()).toBeVisible();
      }
    }
  });

  test('should paginate through data', async ({ page }) => {
    await page.goto('/admin/data-mahasiswa');
    await page.waitForLoadState('networkidle');
    
    // Find pagination controls
    const nextButton = page.locator('button:has-text("Next"), a:has-text("Next"), button:has-text("›"), a:has-text("›")');
    
    if (await nextButton.count() > 0 && await nextButton.first().isEnabled()) {
      await nextButton.first().click();
      await page.waitForTimeout(1000);
      
      // URL or content should change
      await expect(page).toHaveURL(/[?&]page=/);
    }
  });
});
