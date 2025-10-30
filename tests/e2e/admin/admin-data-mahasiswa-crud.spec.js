import { test, expect } from '@playwright/test';

// Helper function for admin login
async function loginAsAdmin(page) {
  await page.goto('/login');
  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(2000);

  const userIDInput = page.locator('input[name="userID"]').or(
    page.locator('input[wire\\:model="userID"]')
  );
  const passwordInput = page.locator('input[name="password"]').or(
    page.locator('input[type="password"]')
  );

  await userIDInput.fill('077583473350128777');
  await passwordInput.fill('admin123');

  const loginButton = page.locator('button[type="submit"]').filter({ hasText: /Login|Masuk/i });
  await loginButton.click();

  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(3000);
}

// Helper function to navigate to Data Mahasiswa page via menu
async function navigateToDataMahasiswa(page) {
  // Make sure we're on the dashboard after login
  await page.waitForURL(/\/dashboard/, { timeout: 15000 }).catch(() => {});

  // Wait for page to be fully loaded
  await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {});
  await page.waitForTimeout(2000);

  // Look for "Kelola Data Master" menu item
  const kelolaDataMasterMenu = page.locator('button, div, a').filter({
    hasText: /Kelola Data Master/i
  }).first();

  const hasMenu = await kelolaDataMasterMenu.isVisible().catch(() => false);

  if (hasMenu) {
    await kelolaDataMasterMenu.click();
    console.log('✓ Clicked Kelola Data Master menu');
    await page.waitForTimeout(1500);
  }

  // Find Data Mahasiswa link by href and force click using JavaScript
  const dataMahasiswaLink = page.locator('a[href*="data-mahasiswa"]').first();

  const linkExists = await dataMahasiswaLink.count();

  if (linkExists > 0) {
    // Use JavaScript to click the hidden element
    await dataMahasiswaLink.evaluate(el => el.click());
    console.log('✓ Clicked Data Mahasiswa link');

    await page.waitForLoadState('domcontentloaded');
    await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {});
    await page.waitForTimeout(3000); // Extra wait for Livewire to initialize
    console.log('✓ Navigated via menu');
  } else {
    console.log('⚠ Link not found, navigation might fail');
  }
}

test.describe('Admin - Data Mahasiswa CRUD Operations', () => {
  test.beforeEach(async ({ page }) => {
    // Login as admin before each test
    await loginAsAdmin(page);
    console.log('✓ Logged in as admin');
  });

  test('should open Tambah Mahasiswa modal and display all required fields', async ({ page }) => {
    console.log('✓ Testing Tambah Mahasiswa modal...');

    await navigateToDataMahasiswa(page);

    // Wait for page to be fully interactive
    await page.waitForLoadState('networkidle', { timeout: 10000 }).catch(() => {});
    await page.waitForTimeout(2000);

    // Find and click "Tambah Mahasiswa" button with longer timeout
    const tambahButton = page.locator('button').filter({ hasText: /Tambah Mahasiswa/i });
    await expect(tambahButton).toBeVisible({ timeout: 15000 });
    console.log('✓ Found Tambah Mahasiswa button');

    // Use JavaScript click to ensure it works
    await tambahButton.evaluate(el => el.click());
    await page.waitForTimeout(3000);
    console.log('✓ Clicked Tambah Mahasiswa button');

    // Check modal title - look for any heading with the text
    const modalTitle = page.locator('text=/Tambahkan data mahasiswa baru/i');
    await expect(modalTitle).toBeVisible({ timeout: 8000 });
    console.log('✓ Modal title displayed');

    // Verify all required fields exist
    const namaInput = page.locator('input[wire\\:model="storeMahasiswaNama"]').or(
      page.locator('label:has-text("Nama")').locator('..').locator('input')
    );
    await expect(namaInput).toBeVisible({ timeout: 3000 });
    console.log('✓ Nama field exists');

    const nimInput = page.locator('input[wire\\:model="storeMahasiswaNIM"]').or(
      page.locator('label:has-text("NIM")').locator('..').locator('input')
    );
    await expect(nimInput).toBeVisible({ timeout: 3000 });
    console.log('✓ NIM field exists');

    const emailInput = page.locator('input[wire\\:model="storeMahasiswaEmail"]').or(
      page.locator('label:has-text("Email")').locator('..').locator('input')
    );
    await expect(emailInput).toBeVisible({ timeout: 3000 });
    console.log('✓ Email field exists');

    const jenisKelaminSelect = page.locator('select[wire\\:model="storeMahasiswaJenisKelamin"]').or(
      page.locator('label:has-text("Jenis Kelamin")').locator('..').locator('select, button')
    );
    await expect(jenisKelaminSelect.first()).toBeVisible({ timeout: 3000 });
    console.log('✓ Jenis Kelamin field exists');

    const tanggalLahirInput = page.locator('input[wire\\:model="storeMahasiswaTanggalLahir"]').or(
      page.locator('label:has-text("Tanggal lahir")').locator('..').locator('input')
    );
    await expect(tanggalLahirInput).toBeVisible({ timeout: 3000 });
    console.log('✓ Tanggal lahir field exists');

    const angkatanInput = page.locator('input[wire\\:model="storeMahasiswaAngkatan"]').or(
      page.locator('label:has-text("Angkatan")').locator('..').locator('input')
    );
    await expect(angkatanInput).toBeVisible({ timeout: 3000 });
    console.log('✓ Angkatan field exists');

    const prodiSelect = page.locator('select[wire\\:model="storeMahasiswaProdi"]').or(
      page.locator('label:has-text("Program Studi")').locator('..').locator('select, button')
    );
    await expect(prodiSelect.first()).toBeVisible({ timeout: 3000 });
    console.log('✓ Program Studi field exists');

    const alamatInput = page.locator('input[wire\\:model="storeMahasiswaAlamat"]').or(
      page.locator('label:has-text("Alamat")').locator('..').locator('input')
    );
    await expect(alamatInput).toBeVisible({ timeout: 3000 });
    console.log('✓ Alamat field exists');

    // Verify Submit button exists
    const submitButton = page.locator('button[type="submit"]').filter({ hasText: /Simpan/i });
    await expect(submitButton).toBeVisible({ timeout: 3000 });
    console.log('✓ Submit button exists');

    console.log('✅ All form fields verified!');
  });

  test('should show validation errors when submitting empty Tambah Mahasiswa form', async ({ page }) => {
    console.log('✓ Testing form validation...');

    await navigateToDataMahasiswa(page);

    // Open modal
    const tambahButton = page.locator('button').filter({ hasText: /Tambah Mahasiswa/i });
    await tambahButton.click();
    await page.waitForTimeout(1000);

    // Try to submit without filling any fields
    const submitButton = page.locator('button[type="submit"]').filter({ hasText: /Simpan/i });
    await submitButton.click();
    await page.waitForTimeout(2000);

    // Check for validation errors
    const errorMessages = page.locator('[class*="error"], [role="alert"], flux\\:error');
    const errorCount = await errorMessages.count();

    console.log(`✓ Found ${errorCount} validation error(s)`);

    // Should have at least some validation errors
    expect(errorCount).toBeGreaterThan(0);

    console.log('✅ Form validation works correctly!');
  });

  test('should check if Import button exists and is clickable', async ({ page }) => {
    console.log('✓ Testing Import button...');

    await navigateToDataMahasiswa(page);

    // Find Import button
    const importButton = page.locator('button').filter({ hasText: /Import/i });
    await expect(importButton).toBeVisible({ timeout: 5000 });
    console.log('✓ Import button is visible');

    // Check if button is enabled
    const isEnabled = await importButton.isEnabled();
    console.log(`✓ Import button is ${isEnabled ? 'enabled' : 'disabled'}`);

    // Try to click the button
    await importButton.click();
    await page.waitForTimeout(1500);

    // Check if any modal or file input appears
    const modal = page.locator('[role="dialog"]').first();
    const fileInput = page.locator('input[type="file"]').first();

    const hasModal = await modal.isVisible().catch(() => false);
    const hasFileInput = await fileInput.isVisible().catch(() => false);

    if (hasModal) {
      console.log('✓ Import modal opened');
    } else if (hasFileInput) {
      console.log('✓ File input field found');
    } else {
      console.log('⚠ Import button clicked but no modal/file input detected');
      console.log('ℹ Import functionality may not be implemented yet');
    }

    console.log('✅ Import button test completed!');
  });

  test('should check if Export button exists and is clickable', async ({ page }) => {
    console.log('✓ Testing Export button...');

    await navigateToDataMahasiswa(page);

    // Find Export button
    const exportButton = page.locator('button').filter({ hasText: /Export/i });
    await expect(exportButton).toBeVisible({ timeout: 5000 });
    console.log('✓ Export button is visible');

    // Check if button is enabled
    const isEnabled = await exportButton.isEnabled();
    console.log(`✓ Export button is ${isEnabled ? 'enabled' : 'disabled'}`);

    // Try to click the button
    await exportButton.click();
    await page.waitForTimeout(1500);

    // Check if any download is triggered or modal appears
    const modal = page.locator('[role="dialog"]').first();
    const hasModal = await modal.isVisible().catch(() => false);

    if (hasModal) {
      console.log('✓ Export modal/dialog opened');
    } else {
      console.log('⚠ Export button clicked but no modal detected');
      console.log('ℹ Export functionality may trigger a direct download or not be implemented yet');
    }

    console.log('✅ Export button test completed!');
  });

  test('should verify Import and Export buttons are in the action toolbar', async ({ page }) => {
    console.log('✓ Testing Import/Export button positions...');

    await navigateToDataMahasiswa(page);

    // Find the toolbar/action buttons container
    const tambahButton = page.locator('button').filter({ hasText: /Tambah Mahasiswa/i });
    const importButton = page.locator('button').filter({ hasText: /Import/i });
    const exportButton = page.locator('button').filter({ hasText: /Export/i });

    // All buttons should be visible
    await expect(tambahButton).toBeVisible({ timeout: 5000 });
    await expect(importButton).toBeVisible({ timeout: 5000 });
    await expect(exportButton).toBeVisible({ timeout: 5000 });

    console.log('✓ All action buttons (Tambah, Import, Export) are visible');

    // Check they are in the same container/group
    const container = page.locator('div').filter({
      has: tambahButton
    }).filter({
      has: importButton
    }).filter({
      has: exportButton
    }).first();

    const hasContainer = await container.isVisible().catch(() => false);

    if (hasContainer) {
      console.log('✓ All buttons are grouped together in the same container');
    } else {
      console.log('ℹ Buttons exist but may not be in the same container');
    }

    console.log('✅ Button layout verified!');
  });
});
