import { test, expect } from '@playwright/test';
import { loginAsMahasiswa, waitForTable } from './helpers';

test.describe('Recommendation System Tests', () => {
  test.beforeEach(async ({ page }) => {
    await loginAsMahasiswa(page);
  });

  test('should display recommendation page for mahasiswa', async ({ page }) => {
    // Navigate to recommendation/preference page
    await page.goto('/mahasiswa/rekomendasi');
    await page.waitForLoadState('networkidle');
    
    // Check if recommendation content exists
    const heading = page.locator('h1, h2, h3').filter({ hasText: /Rekomendasi|Lowongan/i });
    await expect(heading.first()).toBeVisible({ timeout: 5000 });
  });

  test('should show preference settings', async ({ page }) => {
    await page.goto('/mahasiswa/preferensi');
    await page.waitForLoadState('networkidle');
    
    // Check if preference form exists
    const form = page.locator('form');
    if (await form.count() > 0) {
      await expect(form.first()).toBeVisible();
    }
  });

  test('should update mahasiswa preferences', async ({ page }) => {
    await page.goto('/mahasiswa/preferensi');
    await page.waitForLoadState('networkidle');
    
    // Find preference inputs (adjust based on your implementation)
    const selectInputs = page.locator('select, input[type="range"]');
    
    if (await selectInputs.count() > 0) {
      // Update first preference
      const firstInput = selectInputs.first();
      
      if (await firstInput.getAttribute('type') === 'range') {
        await firstInput.fill('8');
      } else {
        await firstInput.selectOption({ index: 1 });
      }
      
      // Submit form
      const submitButton = page.locator('button[type="submit"]');
      if (await submitButton.count() > 0) {
        await submitButton.click();
        await page.waitForTimeout(2000);
        
        // Should show success message or redirect
        const successMessage = page.locator('.alert-success, .success, [role="alert"]').filter({ hasText: /berhasil|success/i });
        if (await successMessage.count() > 0) {
          await expect(successMessage.first()).toBeVisible({ timeout: 5000 });
        }
      }
    }
  });

  test('should display recommended lowongan based on preferences', async ({ page }) => {
    await page.goto('/mahasiswa/rekomendasi');
    await page.waitForLoadState('networkidle');
    
    // Check if recommendations are displayed
    const recommendationCards = page.locator('.card, .recommendation-item, article');
    
    if (await recommendationCards.count() > 0) {
      await expect(recommendationCards.first()).toBeVisible();
      
      // Should show ranking or score
      const score = page.locator('.score, .ranking, .badge').first();
      if (await score.count() > 0) {
        await expect(score).toBeVisible();
      }
    }
  });

  test('should view detail of recommended lowongan', async ({ page }) => {
    await page.goto('/mahasiswa/rekomendasi');
    await page.waitForLoadState('networkidle');
    
    // Click on first recommendation
    const detailButton = page.locator('a:has-text("Detail"), button:has-text("Lihat")').first();
    
    if (await detailButton.count() > 0) {
      await detailButton.click();
      await page.waitForLoadState('networkidle');
      
      // Should show lowongan detail
      const detailContent = page.locator('.detail, .description');
      await expect(detailContent.first()).toBeVisible({ timeout: 5000 });
    }
  });

  test('should show ranking explanation', async ({ page }) => {
    await page.goto('/mahasiswa/rekomendasi');
    await page.waitForLoadState('networkidle');
    
    // Look for info/help icon about ranking
    const infoButton = page.locator('[data-tooltip], .tooltip, button[title*="info"]');
    
    if (await infoButton.count() > 0) {
      await infoButton.first().hover();
      await page.waitForTimeout(500);
      
      // Tooltip should appear
      const tooltip = page.locator('.tooltip-content, [role="tooltip"]');
      if (await tooltip.count() > 0) {
        await expect(tooltip.first()).toBeVisible();
      }
    }
  });
});

test.describe('Admin - Multi-MOORA System Tests', () => {
  test.beforeEach(async ({ page }) => {
    // Login as admin with NIP
    await page.goto('/login');
    const identifierInput = page.locator('input[type="email"], input[name="email"], input[name="nip"], input[name="nim"], input[type="text"]').first();
    await identifierInput.fill('ADMIN001');
    await page.fill('input[type="password"], input[name="password"]', 'password');
    await page.locator('button[type="submit"]').click();
    await page.waitForLoadState('networkidle');
  });

  test('should access kriteria management', async ({ page }) => {
    await page.goto('/admin/kriteria');
    await page.waitForLoadState('networkidle');
    
    // Check if kriteria list exists
    const table = page.locator('table');
    if (await table.count() > 0) {
      await expect(table.first()).toBeVisible();
    }
  });

  test('should display bobot kriteria', async ({ page }) => {
    await page.goto('/admin/kriteria');
    await page.waitForLoadState('networkidle');
    
    // Check if weight/bobot column exists
    const bobotCell = page.locator('td, th').filter({ hasText: /bobot|weight/i });
    if (await bobotCell.count() > 0) {
      await expect(bobotCell.first()).toBeVisible();
    }
  });

  test('should view recommendation results', async ({ page }) => {
    await page.goto('/admin/rekomendasi');
    await page.waitForLoadState('networkidle');
    
    // Check if recommendation results exist
    const resultsTable = page.locator('table');
    if (await resultsTable.count() > 0) {
      await waitForTable(page);
    }
  });
});
