# Project Setup Guide

This guide will walk you through the process of cloning a Laravel project from GitHub and setting it up to run on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- PHP (>= 8.3.9)
- Composer
- Git
- Node.js and npm (for front-end assets)

## Setup Steps

1. **Clone the repository**

   Open your terminal and run the following command:

   ```
   git clone https://github.com/DNNYF/rs.git
   ```

2. **Navigate to the project directory**

   ```
   cd ./rs/
   ```

3. **Install PHP dependencies**

   ```
   composer install
   ```

4. **Create environment file**

   ```
   cp .env.example .env
   ```

   Update the `.env` file with your local environment settings (database credentials, app settings, etc.).

5. **Generate application key**

   ```
   php artisan key:generate
   ```

6. **Run database migrations**

   If the project uses a database, run migrations:

   ```
   php artisan migrate
   ```

   If you want to seed the database with sample data (if available):

   ```
   php artisan db:seed
   ```

7. **Create storage link**

   ```
   php artisan storage:link
   ```

   This creates a symbolic link from `public/storage` to `storage/app/public`, allowing public access to files in the storage folder.

8. **Install front-end dependencies**

   ```
   npm install
   ```

9. **Compile assets**

   ```
   npm run dev
   ```

   For production:

   ```
   npm run build
   ```

10. **Start the development server**

    ```
    php artisan serve
    ```

    Your Laravel application will be available at `http://localhost:8000`.

## Troubleshooting

If you encounter any issues, try the following:

- Clear configuration cache: `php artisan config:clear`
- Clear application cache: `php artisan cache:clear`
- If you have permission issues, run: `chmod -R 777 storage bootstrap/cache`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).