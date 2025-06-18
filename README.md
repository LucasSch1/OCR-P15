# 🚀 OCR-P15: Refactor Website Code for Optimization

## Description
This project is a landscape photography website, allowing Ina Zaoui to share her work and promote young photographers. The application enables users to discover photos from around the world and learn more about the artist's travels.

## Prerequisites
- PHP >= 8.0
- Composer
- Symfony CLI
- PostgreSQL

## Development Tools
- PHPStan for static analysis
- Rector for code modernization
- PHPUnit for testing
- Symfony Profiler for debugging

## Project Structure
- `src/`: Application source code
- `templates/`: Twig templates
- `tests/`: Unit and functional tests
- `config/`: Application configuration
- `public/`: Public files (assets, uploads)
- `migrations/`: Database migrations

# Installation

## 📥 1. Clone the project
Clone the repository to your local machine:
```bash
git clone https://github.com/LucasSch1/OCR-P15.git
cd OCR-P15
```

## ⚙️ 2. Install dependencies
Run the following command to install PHP dependencies:
```bash
composer install
```
Wait for the download and installation of resources to complete.

## 🛠 3. Configure the database
Modify the **.env** file to **enter your database connection credentials.**

Expected configuration:
```bash
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/ina_zaoui?serverVersion=16&charset=utf8"
```
**⚠️ Replace app and !ChangeMe! with your actual username and password if needed, as well as your database version.**

## 🏗 4. Create and apply the database
➤ Create the database:
```bash
php bin/console doctrine:database:create
```
➤ Apply migration to the database:
```bash
php bin/console doctrine:migrations:migrate
```
**Confirm by typing yes if prompted.**

➤ Create a migration (**if the existing one doesn't work**):
```bash
php bin/console doctrine:migrations:diff
```

## 🔄 5. Create test database and run migrations:
```bash
php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate --env=test
```

## ✅ 6. Verify schema synchronization
Ensure the database is in sync with entities:
```bash
php bin/console doctrine:schema:validate
```
If everything is correct, you should see:

**Mapping   OK**

**Database  OK**

Messages should appear in green ✅.

## 🗄 7. Add test data
Load fixtures (test data) into the database:
```bash
php bin/console doctrine:fixtures:load
```
Load fixtures (test data) into the test database:
```bash
php bin/console doctrine:fixtures:load --env=test
```

**Confirm by typing yes if prompted.**

# Usage

## 🚀 Launch web server
Start the Symfony server in the background:
```bash
symfony serve -d
```
Then click on the **link displayed in the console to access the project.**

## 🧪 Tests
To run tests:
```bash
php bin/phpunit
```
Note: Make sure you have configured the test database and loaded fixtures before running tests.

## 🔑 Login

To log in with the Administrator account, use the following credentials:

- Username: `ina@zaoui.com`
- Password: `password`

To log in with the Guest account, use the following credentials:

- Username: `invite+1@exemple.com`
- Password: `password`
