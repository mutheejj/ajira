# Ajira Global - Freelancing Platform

Ajira Global is a comprehensive job marketplace and freelancing platform built with Laravel, connecting job seekers with clients across various industries.

## 🚀 Features

### User Authentication & Profiles
- Secure registration and login for Job Seekers and Clients
- Email verification and password reset functionality
- Profile management with skill showcasing for job seekers
- Company profiles for clients/employers

### Job Seeker Features
- Create and update professional profiles with portfolio items
- Browse and search available jobs with advanced filtering
- Apply for jobs with cover letters and work samples
- Track application status in real-time
- Save favorite jobs for later application
- Task management for ongoing projects
- Work log tracking for completed hours
- Secure wallet for receiving payments with multiple withdrawal options
- Comprehensive dashboard with analytics

### Client/Employer Features
- Post detailed job openings with skill requirements
- Manage job applications with screening tools
- Review applicant profiles and portfolios
- Track project progress and deliverables
- Release payments for completed work
- Rate and review job seekers

### Jobs System
- Detailed job listings with search, filter, and sort capabilities
- Category-based browsing
- Location-based job search
- Application tracking for both clients and job seekers
- Budget and deadline management

### Payments & Wallet
- Secure wallet system for storing earnings
- Multiple withdrawal methods including:
  - MPesa integration for Kenyan users
  - PayPal for international transfers
  - Bank transfers
  - Mobile money options
- Transaction history and reporting

## 💻 Tech Stack
- [Laravel 10](https://laravel.com/) - PHP Framework
- MySQL - Database
- [Blade Templates](https://laravel.com/docs/10.x/blade) with [Tailwind CSS](https://tailwindcss.com/) - Frontend
- [Alpine.js](https://alpinejs.dev/) - JavaScript Framework
- [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum) - API Authentication

## 🛠️ Installation

### Prerequisites
- PHP 8.1+
- Composer
- MySQL or MariaDB
- Node.js and NPM (for frontend assets)

### Setup Steps
1. Clone this repository
   ```bash
   git clone https://github.com/mutheejj/ajira.git
   cd ajira-global
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install and compile frontend assets
   ```bash
   npm install
   npm run dev
   ```

4. Environment Configuration
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database connection in `.env` file
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ajira
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. For MPesa integration, add your credentials to the `.env` file
   ```
   MPESA_CONSUMER_KEY=your_consumer_key
   MPESA_CONSUMER_SECRET=your_consumer_secret
   MPESA_PASSKEY=your_passkey
   MPESA_SHORTCODE=your_shortcode
   ```

7. Run database migrations and seed initial data
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

8. Start the local development server
   ```bash
   php artisan serve
   ```

9. Visit http://localhost:8000 in your browser

## 🧱 Project Structure

This Laravel project follows the MVC architecture:

```
app/
├── Http/
│   ├── Controllers/        # Application controllers
│   ├── Middleware/         # Custom middleware
│   └── Requests/           # Form requests for validation
├── Models/                 # Database models
├── Services/               # Business logic services
resources/
├── views/                  # Blade templates
│   ├── layouts/            # Layout templates
│   ├── jobs/               # Job-related views
│   ├── applications/       # Application-related views
│   └── components/         # Reusable UI components
routes/
├── web.php                 # Web routes
└── api.php                 # API routes
database/
├── migrations/             # Database migrations
└── seeders/                # Database seeders
```

## 🤝 Acknowledgments

- [Laravel](https://laravel.com/) - The web framework used
- [Tailwind CSS](https://tailwindcss.com/) - UI framework
- [Alpine.js](https://alpinejs.dev/) - JavaScript framework for enhancing interactivity
- [MPesa Daraja API](https://developer.safaricom.co.ke/) - For mobile money integration
- [PayPal SDK](https://developer.paypal.com/) - For PayPal integration
- Icons from [Heroicons](https://heroicons.com/)
- UI components inspired by [Tailwind UI](https://tailwindui.com/)

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🔮 Roadmap

- Mobile app development with Flutter
- Real-time messaging system
- Advanced reporting features
- AI-powered job matching
- Time tracking features for hourly contracts

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.