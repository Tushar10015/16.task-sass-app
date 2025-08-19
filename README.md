# Task Management Application

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## About

A modern task and project management application built with Laravel, Inertia.js, and Vue.js. The application provides a clean interface for managing projects, tasks, subtasks, and comments with real-time updates.

## Features

- User authentication and authorization
- Project management
- Task tracking with status updates
- Subtask management
- Real-time comments
- Responsive design with Tailwind CSS
- Inertia.js for single-page application experience
- Real-time updates using Laravel Echo and Pusher

## Tech Stack

- **Backend**: Laravel 10+
- **Frontend**: Vue.js 3, Inertia.js
- **Styling**: Tailwind CSS with Forms and Typography plugins
- **Authentication**: Laravel Jetstream with Teams
- **Real-time**: Laravel Echo, Pusher
- **Build Tool**: Vite
- **Testing**: Pest PHP

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- npm or yarn
- MySQL/PostgreSQL/SQLite

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/task-management-app.git
   cd task-management-app
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Configure your database in `.env`

7. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

8. Compile assets:
   ```bash
   npm run build
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

10. Visit `http://localhost:8000` in your browser

## Development

For development with hot module replacement:

```bash
# Start the Vite dev server
npm run dev

# In a separate terminal
php artisan serve
```

## Testing

Run the test suite:

```bash
php artisan test
```

## Contributing

Contributions are welcome! Please read our [contributing guidelines](CONTRIBUTING.md) before submitting pull requests.

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to the maintainer. All security vulnerabilities will be promptly addressed.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
