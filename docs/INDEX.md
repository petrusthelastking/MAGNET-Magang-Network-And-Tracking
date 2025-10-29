# 📖 MAGNET Documentation Hub

Welcome to the MAGNET project documentation! This page serves as a central hub for all documentation resources.

---

## 🚀 Getting Started

### For New Team Members:
1. **[README.md](../README.md)** - Start here! Project overview and setup instructions
2. **[PROJECT_STRUCTURE.md](../PROJECT_STRUCTURE.md)** - Understand the codebase organization
3. **[QUICK_REFERENCE.md](../QUICK_REFERENCE.md)** - Essential commands you'll use daily
4. **[CONTRIBUTING.md](../CONTRIBUTING.md)** - Learn how to contribute effectively

---

## 📂 Documentation Categories

### 🏗️ Architecture & Design

| Document | Description |
|----------|-------------|
| [Project Structure](../PROJECT_STRUCTURE.md) | Complete folder and file organization |
| [Class Diagrams](class-diagram/) | UML class diagrams |
| [Sequence Diagrams](sequence-diagram/) | System interaction flows |
| [Deployment Diagrams](deployment-diagram/) | Infrastructure and deployment architecture |

### 💻 Development

| Document | Description |
|----------|-------------|
| [Quick Reference](../QUICK_REFERENCE.md) | Common commands and workflows |
| [Contributing Guide](../CONTRIBUTING.md) | Git workflow, coding standards, PR process |
| [Setup Laragon](../SETUP_LARAGON.md) | Local development environment setup |

### 🧪 Testing

| Document | Description |
|----------|-------------|
| [Testing Guide](testing/README.md) | Complete testing documentation |
| [Playwright Testing](testing/PLAYWRIGHT_TESTING.md) | E2E testing with Playwright |
| [Testing Checklist](../TESTING_CHECKLIST.md) | Pre-deployment testing checklist |
| [Manual Testing Guide](../MANUAL_TESTING_GUIDE.md) | Manual test procedures |

### 🎨 User Interface

| Document | Description |
|----------|-------------|
| [Website Preview](web-preview/) | Full UI screenshots and mockups |

---

## 🎯 Quick Links by Role

### Backend Developer
- [Laravel Documentation](https://laravel.com/docs)
- [Project Structure - Backend](../PROJECT_STRUCTURE.md#app---application-logic)
- [Quick Reference - Artisan Commands](../QUICK_REFERENCE.md#-laravel-artisan-commands)
- [Database Operations](../QUICK_REFERENCE.md#database-operations)

### Frontend Developer
- [Project Structure - Frontend](../PROJECT_STRUCTURE.md#resources---frontend-resources)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [DaisyUI Components](https://daisyui.com/components)
- [Livewire Documentation](https://livewire.laravel.com)

### QA/Tester
- [Testing Guide](testing/README.md)
- [Playwright Documentation](testing/PLAYWRIGHT_TESTING.md)
- [Testing Checklist](../TESTING_CHECKLIST.md)
- [Quick Reference - Testing](../QUICK_REFERENCE.md#-testing-commands)

### DevOps/Infrastructure
- [Deployment Diagrams](deployment-diagram/)
- [Setup Laragon](../SETUP_LARAGON.md)
- [Quick Reference - Optimization](../QUICK_REFERENCE.md#-performance--optimization)

### Project Manager
- [README.md](../README.md) - Project overview
- [Testing Checklist](../TESTING_CHECKLIST.md)
- [Contributing Guide](../CONTRIBUTING.md) - Team workflow

---

## 📝 Document Quick Access

### Installation & Setup
```bash
# Quick setup
git clone https://github.com/Maju-Lancar/MAGNET-Magang-Network-And-Tracking.git
cd MAGNET-Magang-Network-And-Tracking
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

See [README.md](../README.md) for detailed setup instructions.

### Testing Quick Start
```bash
# Start server
php artisan serve

# Run E2E tests (in new terminal)
npx playwright test

# Run with UI
npx playwright test --ui
```

See [Testing Guide](testing/README.md) for detailed testing instructions.

### Daily Development
```bash
# Clear cache
php artisan optimize:clear

# Run migrations
php artisan migrate

# Build frontend
npm run build

# Run tests
php artisan test && npx playwright test
```

See [Quick Reference](../QUICK_REFERENCE.md) for more commands.

---

## 🆘 Troubleshooting

### Common Issues:

| Issue | Solution | Reference |
|-------|----------|-----------|
| Server won't start | Kill process on port 8000, clear cache | [Quick Reference - Emergency](../QUICK_REFERENCE.md#-emergency-commands) |
| Database errors | Check `.env` config, run migrations | [Quick Reference - Database](../QUICK_REFERENCE.md#database-operations) |
| Test failures | Check logs, verify server running | [Testing Guide - Troubleshooting](testing/README.md#-troubleshooting) |
| Frontend not updating | Run `npm run build`, clear cache | [Quick Reference - Frontend](../QUICK_REFERENCE.md#-frontend-development) |

---

## 🔄 Document Update Guidelines

### When to Update Documentation:

1. **After major feature additions** - Update relevant architecture diagrams
2. **After changing project structure** - Update PROJECT_STRUCTURE.md
3. **After adding new commands** - Update QUICK_REFERENCE.md
4. **After changing workflow** - Update CONTRIBUTING.md
5. **After adding tests** - Update testing documentation

### How to Update:

1. Edit the appropriate `.md` file
2. Follow existing formatting and structure
3. Add entry to this INDEX.md if new document
4. Commit with descriptive message: `docs: update testing guide with new examples`

---

## 📊 Documentation Status

| Document | Last Updated | Status | Maintainer |
|----------|--------------|--------|------------|
| README.md | 2024-01-XX | ✅ Up to date | Team |
| PROJECT_STRUCTURE.md | 2024-01-XX | ✅ Up to date | Team |
| QUICK_REFERENCE.md | 2024-01-XX | ✅ Up to date | Team |
| CONTRIBUTING.md | 2024-01-XX | ✅ Up to date | Team |
| Testing Guide | 2024-01-XX | ✅ Up to date | Team |

---

## 🤝 Contributing to Documentation

Documentation is as important as code! If you find:
- **Outdated information** - Submit a PR with updates
- **Missing information** - Open an issue or add it yourself
- **Confusing explanations** - Suggest improvements
- **Typos/errors** - Fix them directly

See [CONTRIBUTING.md](../CONTRIBUTING.md) for contribution guidelines.

---

## 📞 Need Help?

- **For project setup issues:** Check [README.md](../README.md)
- **For coding questions:** Check [QUICK_REFERENCE.md](../QUICK_REFERENCE.md)
- **For testing problems:** Check [Testing Guide](testing/README.md)
- **For contribution process:** Check [CONTRIBUTING.md](../CONTRIBUTING.md)

**Still stuck?** Open an issue on GitHub or contact the team lead.

---

## 🌟 Documentation Best Practices

1. **Keep it simple** - Write for someone new to the project
2. **Use examples** - Code snippets help understanding
3. **Stay consistent** - Follow existing formatting
4. **Update regularly** - Documentation should match current code
5. **Link appropriately** - Cross-reference related documents
6. **Test commands** - Verify all commands work before documenting

---

**Last Updated:** 2024-01-XX  
**Maintained by:** MAGNET Team  
**Repository:** https://github.com/Maju-Lancar/MAGNET-Magang-Network-And-Tracking
