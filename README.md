
## About Stackifide

Stackifide is a comprehensive web application platform built with Laravel that enables businesses to efficiently manage multiple customer websites from a single, centralized dashboard. Designed for web agencies, hosting providers, and digital service companies, Stackifide streamlines website management operations, client relationships, and team collaboration.

### Key Features

**Multi-Website Management**
- Centralized dashboard for managing multiple customer websites
- Track website status, performance metrics, and updates
- Organize websites by client, project, or category

**Role-Based Access Control**
- **Admin**: Full system access and configuration
- **Editor**: Content management and website editing capabilities
- **Customer**: View and manage their own websites
- **Public**: Limited access for public-facing features

**User Management**
- Secure authentication with first and last name support
- Profile management and customization
- Email verification and password reset functionality

**Modern Technology Stack**
- Built with Laravel 12 for robust backend functionality
- Tailwind CSS for modern, responsive UI design
- MySQL database for reliable data storage
- RESTful API architecture for extensibility

### Use Cases

- **Web Agencies**: Manage all client websites from one platform
- **Hosting Providers**: Offer website management as a service
- **Digital Marketing Agencies**: Track and manage client website portfolios
- **Freelancers**: Organize and maintain multiple client projects

### Getting Started

Stackifide provides a clean, intuitive interface that makes website management simple and efficient. Whether you're managing a handful of sites or hundreds, Stackifide scales with your business needs.

## Installation

### Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 18+ and NPM

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/keersa/stackifide-app.git
   cd stackifide-app
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Update the `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=stackifide
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed the database** (optional - creates a test admin user)
   ```bash
   php artisan db:seed
   ```
   
   Default test user credentials:
   - Email: `test@example.com`
   - Password: `password`
   - Role: `admin`

7. **Build frontend assets**
   ```bash
   npm run build
   ```
   
   Or for development with hot reloading:
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to access the application.

## User Roles

Stackifide includes four user roles with different permission levels:

- **Admin**: Full system access, can manage all users and websites
- **Editor**: Can create and edit website content
- **Customer**: Can view and manage their own websites
- **Public**: Limited access for public-facing features

## Technology Stack

- **Backend**: Laravel 12
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Asset Compilation**: Vite

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

This project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to the project maintainers. All security vulnerabilities will be promptly addressed.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
