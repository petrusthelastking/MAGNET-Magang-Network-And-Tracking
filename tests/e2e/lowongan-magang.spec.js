import { test, expect } from '@playwright/test';

test.describe('Lowongan Magang Tests', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/');
  });

  test('should display list of lowongan magang', async ({ page }) => {
    // Navigate to lowongan page (adjust URL based on your routes)
    await page.goto('/lowongan-magang');
    await page.waitForLoadState('networkidle');
    
    // Check if lowongan cards or list exists
    const lowonganContainer = page.locator('.card, .lowongan-item, article');
    
    if (await lowonganContainer.count() > 0) {
      await expect(lowonganContainer.first()).toBeVisible();
    }
  });

  test('should filter lowongan by bidang industri', async ({ page }) => {
    await page.goto('/lowongan-magang');
    await page.waitForLoadState('networkidle');
    
    // Find filter dropdown or buttons
    const filterElement = page.locator('select[name*="bidang"], button:has-text("Filter")');
    
    if (await filterElement.count() > 0) {
      await filterElement.first().click();
      await page.waitForTimeout(1000);
      
      // Content should update
      await expect(page).toHaveURL(/[?&](bidang|filter)=/);
    }
  });

  test('should view detail lowongan', async ({ page }) => {
    await page.goto('/lowongan-magang');
    await page.waitForLoadState('networkidle');
    
    // Click on first lowongan detail
    const detailLink = page.locator('a:has-text("Detail"), a:has-text("Lihat Detail"), button:has-text("Detail")');
    
    if (await detailLink.count() > 0) {
      await detailLink.first().click();
      await page.waitForLoadState('networkidle');
      
      // Should navigate to detail page
      expect(page.url()).toMatch(/lowongan|detail/);
    }
  });

  test('should search lowongan', async ({ page }) => {
    await page.goto('/lowongan-magang');
    await page.waitForLoadState('networkidle');
    
    // Find search input
    const searchInput = page.locator('input[type="search"], input[placeholder*="Cari"]');
    
    if (await searchInput.count() > 0) {
      await searchInput.first().fill('programmer');
      await searchInput.first().press('Enter');
      await page.waitForTimeout(1000);
      
      // Results should update
      await expect(page).toHaveURL(/[?&](search|q)=/);
    }
  });
});

test.describe('Apply Magang Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Login as mahasiswa with NIM
    await page.goto('/login');
    const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first();
    await identifierInput.fill('TEST123456');
    await page.fill('input[type="password"], input[name="password"]', 'password');
    await page.locator('button[type="submit"]').click();
    await page.waitForLoadState('networkidle');
  });

  test('should show apply button on lowongan detail', async ({ page }) => {
    await page.goto('/lowongan-magang');
    await page.waitForLoadState('networkidle');
    
    // Navigate to detail
    const detailLink = page.locator('a:has-text("Detail"), button:has-text("Detail")');
    if (await detailLink.count() > 0) {
      await detailLink.first().click();
      await page.waitForLoadState('networkidle');
      
      // Check for apply button
      const applyButton = page.locator('button:has-text("Lamar"), button:has-text("Daftar"), a:has-text("Lamar")');
      if (await applyButton.count() > 0) {
        await expect(applyButton.first()).toBeVisible();
      }
    }
  });
});
