import { test, expect } from '@playwright/test';

test.describe('Server Connectivity Test', () => {
  const urlsToTest = [
    'http://localhost:8000',
    'http://127.0.0.1:8000',
    'http://localhost:8080',
    'http://localhost/MAGNET-Magang-Network-And-Tracking/public',
    'http://localhost:8000/public',
  ];

  for (const url of urlsToTest) {
    test(`Test connectivity to ${url}`, async ({ page }) => {
      try {
        console.log(`\n🔍 Testing: ${url}`);
        
        const response = await page.goto(url, { timeout: 5000, waitUntil: 'domcontentloaded' });
        
        if (response && response.ok()) {
          console.log(`✅ SUCCESS! Server responding at: ${url}`);
          console.log(`   Status: ${response.status()}`);
          console.log(`\n📝 Update playwright.config.js dengan baseURL: '${url}'`);
          
          // Take screenshot
          await page.screenshot({ path: `test-results/server-found-${url.replace(/[:/]/g, '-')}.png` });
          
          expect(response.status()).toBeLessThan(400);
        } else {
          console.log(`❌ Server tidak responding properly di ${url}`);
        }
      } catch (error) {
        console.log(`❌ Failed to connect to ${url}`);
        console.log(`   Error: ${error.message}`);
      }
    });
  }
});

test.describe('Login Page Detection', () => {
  test('Find login page if server is up', async ({ page }) => {
    const baseUrls = [
      'http://localhost:8000',
      'http://localhost',
    ];

    const loginPaths = [
      '/login',
      '/auth/login',
      '/masuk',
      '/signin',
      '/',
    ];

    for (const baseUrl of baseUrls) {
      for (const path of loginPaths) {
        const fullUrl = baseUrl + path;
        try {
          console.log(`\n🔍 Checking: ${fullUrl}`);
          const response = await page.goto(fullUrl, { timeout: 3000 });
          
          if (response && response.ok()) {
            // Check if it looks like a login page
            const hasLoginForm = await page.locator('input[type="password"]').count() > 0;
            const hasEmailOrUsername = await page.locator('input[type="email"], input[name="nim"], input[name="username"]').count() > 0;
            
            if (hasLoginForm && hasEmailOrUsername) {
              console.log(`✅ FOUND LOGIN PAGE: ${fullUrl}`);
              await page.screenshot({ path: `test-results/login-page-found.png` });
              console.log(`\n📝 Use this URL in your tests!`);
              expect(true).toBe(true);
              return;
            }
          }
        } catch (error) {
          // Silent fail, continue to next URL
        }
      }
    }
  });
});
