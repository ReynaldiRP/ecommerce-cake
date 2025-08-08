# Dream Dessert - E-commerce Cake Application

<p align="center">
    <img src="public/assets/image/logo-dreamdessert.webp" width="200" alt="Dream Dessert Logo">
</p>

<p align="center">
    A modern e-commerce platform for custom cake orders built with Laravel, Vue.js, and Inertia.js
</p>

## 🍰 About Dream Dessert

Dream Dessert is a comprehensive e-commerce cake ordering platform that allows customers to browse, customize, and order cakes online. The application features a modern web interface with real-time order tracking, payment integration, and an admin dashboard for business management.

### ✨ Key Features

- **🛒 Product Catalog**: Browse various cake categories with detailed descriptions
- **🎂 Custom Cake Builder**: Customize cakes with flavors, sizes, and toppings
- **🛍️ Shopping Cart**: Add, modify, and manage cart items
- **💳 Payment Integration**: Secure payments via Midtrans payment gateway
- **📱 Order Tracking**: Real-time order status updates and notifications
- **👨‍💼 Admin Dashboard**: Comprehensive business management interface
- **📊 Analytics & Reports**: Sales performance and product analytics
- **📧 Email Notifications**: Automated order and payment confirmations
- **🔐 Role-based Access**: User authentication with admin/customer roles

## 🏗️ Technology Stack

### Backend
- **Laravel 10** - PHP web application framework
- **MySQL** - Primary database
- **Laravel Sanctum** - API authentication
- **Spatie Laravel Permission** - Role and permission management
- **Laravel Telescope** - Debug assistant

### Frontend
- **Vue.js 3** - Progressive JavaScript framework
- **Inertia.js** - Modern monolithic feel with SPA benefits
- **Tailwind CSS** - Utility-first CSS framework
- **DaisyUI** - Tailwind CSS component library
- **Chart.js** - Data visualization
- **Pinia** - State management for Vue.js

### Payment & Services
- **Midtrans** - Payment gateway integration
- **Laravel DomPDF** - PDF generation for reports
- **Laravel Mail** - Email services

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP >= 8.2**
- **Composer**
- **Node.js >= 16.x**
- **NPM or Yarn**
- **MySQL >= 8.0**
- **Git**

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd ecommerce-cake-app
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
# or
yarn install
```

### 4. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Environment Variables
Edit `.env` file with your configuration:

```env
APP_NAME="Dream Dessert"
APP_ENV=local
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_cake_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls

# Midtrans Configuration
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### 6. Database Setup
```bash
# Run database migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

### 7. Storage Link
```bash
php artisan storage:link
```

### 8. Build Assets
```bash
# For development
npm run dev

# For production
npm run build
```

## 🏃‍♂️ Running the Application

### Development Environment
```bash
# Start the Laravel development server
php artisan serve

# In another terminal, start the Vite dev server
npm run dev
```

Visit `http://localhost:8000` in your browser.

### Production Environment
```bash
# Build assets for production
npm run build

# Configure your web server (Apache/Nginx) to serve the application
```

## 📁 Project Structure

```
ecommerce-cake-app/
├── app/
│   ├── Http/Controllers/        # Application controllers
│   │   ├── Auth/               # Authentication controllers
│   │   ├── AdminDashboard/     # Admin panel controllers
│   │   └── ...                 # Other controllers
│   ├── Models/                 # Eloquent models
│   ├── Mail/                   # Mail classes
│   └── Http/Middleware/        # Custom middleware
├── database/
│   ├── migrations/             # Database migrations
│   ├── factories/              # Model factories
│   └── seeders/                # Database seeders
├── resources/
│   ├── js/
│   │   ├── Components/         # Vue.js components
│   │   ├── Pages/             # Inertia.js pages
│   │   ├── Layouts/           # Application layouts
│   │   └── Stores/            # Pinia stores
│   ├── css/                   # Stylesheets
│   └── views/                 # Blade templates
├── routes/
│   ├── web.php                # Web routes
│   └── api.php                # API routes
└── public/
    └── assets/                # Static assets
```

## 🔑 Key Models

- **User**: Customer and admin user management
- **Cake**: Product catalog with categories and pricing
- **Order**: Customer orders with status tracking
- **OrderItem**: Individual items within orders
- **Payment**: Payment processing and history
- **ShoppingChart**: Shopping cart functionality
- **Category**: Cake categorization
- **Flavour**: Available cake flavors
- **CakeSize**: Available cake sizes
- **Topping**: Additional cake toppings
- **Discount**: Promotional discounts

## 🛠️ API Routes

### Public Routes
- `GET /` - Home page
- `GET /home/products` - Product catalog
- `GET /login` - Login page
- `GET /register` - Registration page

### Authenticated Routes
- `GET /home/{cakeId}/detail-product` - Product details
- `POST /add-chart-item` - Add item to cart
- `POST /add-order` - Create order
- `GET /home/transaction-history` - Order history

### Admin Routes
- `GET /admin/dashboard/home` - Admin dashboard
- `CRUD /admin/dashboard/cake` - Cake management
- `CRUD /admin/dashboard/category` - Category management
- `GET /admin/dashboard/orders` - Order management
- `GET /admin/dashboard/payments` - Payment overview

## 🔧 Configuration

### Payment Gateway (Midtrans)
1. Create a Midtrans account
2. Get your Server Key and Client Key
3. Configure in `.env` file
4. Set sandbox/production mode

### Email Configuration
1. Configure SMTP settings in `.env`
2. Test email functionality with `php artisan tinker`

### File Storage
- Product images are stored in `public/assets/image/cakes/`
- User uploads go to `storage/app/public/`

## 📊 Database Schema

### Core Tables
- `users` - User accounts and authentication
- `cakes` - Product catalog
- `categories` - Product categories
- `orders` - Customer orders
- `order_items` - Order line items
- `payments` - Payment records
- `shopping_charts` - Shopping cart data
- `flavours`, `cake_sizes`, `toppings` - Product customization options

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

## 📈 Monitoring & Debugging

### Laravel Telescope
Access Telescope dashboard at `/telescope` for:
- Request monitoring
- Database query analysis
- Job monitoring
- Exception tracking

### Logs
- Application logs: `storage/logs/laravel.log`
- Error monitoring and debugging tools available

## 🚀 Deployment

### Production Checklist
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure production database
4. Set up proper web server (Apache/Nginx)
5. Configure SSL certificates
6. Set up automated backups
7. Configure production payment gateway
8. Optimize application:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Support

For support and questions:
- Create an issue in this repository
- Contact the development team

## 🔗 Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Generate IDE helper files
php artisan ide-helper:generate

# Run database migrations with fresh seed
php artisan migrate:fresh --seed

# Create new controller
php artisan make:controller ControllerName

# Create new model with migration
php artisan make:model ModelName -m

# Create new Vue component
# Add to resources/js/Components/

# Build and watch assets
npm run dev

# Format code
npx prettier --write resources/js
```

---

**Dream Dessert** - Making your cake dreams come true! 🍰✨
