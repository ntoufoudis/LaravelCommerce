# LaravelCommerce

[![License](https://img.shields.io/github/license/ntoufoudis/LaravelCommerce)](LICENSE.md)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Build Status](https://img.shields.io/github/actions/workflow/status/ntoufoudis/LaravelCommerce/tests.yml)](https://github.com/ntoufoudis/LaravelCommerce/actions)

**LaravelCommerce** is an open-source, headless eCommerce RESTful API built with Laravel. It's designed for developers who want full control over their store’s backend logic, integrations, and scalability — whether you're building a custom storefront, mobile app, or multi-channel commerce solution.

---

## ✨ Features

- 🛒 Product, Category & Inventory Management
- 👥 Customer Accounts & Profiles
- 📦 Orders, Cart & Checkout APIs
- 💰 Payment Gateway Integration-ready
- 📊 Admin Panel-ready API
- 📦 Shipping & Tax Configuration Support (Modular)
- 🔐 Secure API with Laravel Sanctum (or Passport)
- 🧩 Extendable & Modular Architecture
- 📄 JSON:API-compliant responses

---

## 🚀 Getting Started

### Requirements

- PHP 8.2+
- Composer
- MySQL / PostgreSQL
- Laravel CLI

### Installation

```bash
git clone https://github.com/ntoufoudis/LaravelCommerce.git
cd laravelcommerce
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```
## 🤝 Contributing

Pull requests are welcome. Read more [Here](CONTRIBUTING.md).

## 📜 License

LaravelCommerce is open-sourced software licensed under the [MIT license](LICENSE.md).

## 💬 Community & Support
* Issues: Use GitHub Issues
* Discussions: Coming soon
* Slack/Discord: Planned for future
