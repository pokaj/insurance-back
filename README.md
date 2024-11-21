# Laravel Project

## Overview
This project is built using the [Laravel](https://laravel.com/) PHP framework. It provides a robust backend solution for managing your application, and is scalable and easy to maintain. The application is designed to meet a variety of needs with its extendable architecture and rich ecosystem of features.

### Features Implemented
- **User Authentication**: Users can register, log in, and log out. Authentication was implemented with Laravel Sanctum
- **CRUD Operations for Policies**: Support for create, read, update, and delete, filtering and searching operations on Policies.
- **CORS Support**: Configured CORS to allow frontend (Angular) to communicate with the backend API.
- **Middleware**: Custom middleware to handle permissions, user authentication and route protection.
- **Email Notifications**: Support for sending emails to admin based on the expiring date of policies
- **Database Migrations**: Migrations are set up to manage database schema changes.
- **Seeding**: Sample data seeded to the database for testing.

## Getting Started

### Prerequisites
Make sure you have the following installed on your machine:
- PHP >= 7.3
- Composer (for managing PHP dependencies)
- MySQL
- Laravel's required PHP extensions (check the Laravel documentation)

### Clone the project
Clone the repository to your local machine:
```bash
git clone https://github.com/pokaj/insurance-back.git
cd insurance-policy-back
```

### Install Dependencies
Install the necessary PHP dependencies via composer
```bash
composer install
```

### Application Key
Generate laravel application key
```bash
php artisan key:generate
```

### Configure Database
Set up your database configuration in .env file
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### Database Set up
Run the migration to set up the database schema
```bash
php artisan migrate
```

### Populate database 
Run the seeder to populate the database with sample data
```bash
php artisan db:seed
```

### Setup mailing
setup email by entering details in the .env file.
Ps: For gmail, use app passwords
```bash
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_NAME=
```

### Start the serve
```bash
php artisan serve
```
