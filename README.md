### E-Commerce API (Laravel 12)
Overview

This is a RESTful API for an e-commerce product management system built with Laravel. It includes authentication, product management, categories, and order management.
Features

✅ Product Management

    CRUD operations for products
    Soft delete functionality
    Image upload & storage
    Pagination & filtering

✅ Category Management

    Many-to-many relationship with products
    Filtering products by category

✅ User Authentication (Laravel Sanctum)

    User registration & login
    Role-based access control (Admin & Customer)

✅ Order Management

    Place new orders
    View order history
    Get order details
    Decrease stock when an order is placed

✅ Security & Best Practices

    Password hashing & validation
    CSRF protection for web routes
    Rate limiting on API endpoints
    Input validation & sanitization

Installation Guide
1. Clone the Repository

        git clone https://github.com/RosyStephen/life-ecom.git
   
        cd life-ecom

2. Install Dependencies

        composer install

3. Key Generate

        php artisan key:generate

4. Set Up Database

        php artisan migrate --seed

(This will create tables and add sample data)

5. Storage & Permissions

        php artisan storage:link

6. Start the Server

        php artisan serve

(Runs on http://127.0.0.1:8000 by default)

## API Endpoints


### Authentication

| Method | Endpoint                     | Description                  |
|--------|------------------------------|------------------------------|
| POST   | `/api/auth/login`            | Login and get token         |
| POST   | `/api/auth/logout`           | Logout user                 |
| POST   | `/api/auth/register`         | Register new user           |
| POST   | `/api/auth/verify-email`     | Verify email with OTP       |
| POST   | `/api/auth/resend-otp`       | Resend verification OTP     |

### Products

| Method | Endpoint                                          | Description                          |
|--------|--------------------------------------------------|--------------------------------------|
| GET    | `/api/products/products`                        | Get all products (paginated)        |
| GET    | `/api/products/products/{product}`              | Get single product details          |
| POST   | `/api/products/products`                        | Create a new product (Admin only)   |
| POST   | `/api/products/products/{product}`              | Update a product (Admin only)       |
| DELETE | `/api/products/products/{product}`              | Soft delete a product (Admin only)  |
| POST   | `/api/products/product/delete-image/{image}`    | Delete an image from a product      |
| GET    | `/api/products/product/trashed`                 | Get trashed products                |
| PUT    | `/api/products/product/restore/{product}`       | Restore a soft-deleted product      |
| DELETE | `/api/products/product/force-delete/{product}`  | Permanently delete a product        |

### Categories

| Method | Endpoint                                          | Description                          |
|--------|--------------------------------------------------|--------------------------------------|
| GET    | `/api/master/categories`                        | Get all categories                  |
| POST   | `/api/master/categories`                        | Create a new category (Admin only)  |
| GET    | `/api/master/categories/{category}`             | Get category details                |
| PUT    | `/api/master/categories/{category}`             | Update a category (Admin only)      |
| DELETE | `/api/master/categories/{category}`             | Delete a category (Admin only)      |
| GET    | `/api/master/category/trashed`                  | Get trashed categories              |
| PUT    | `/api/master/category/restore/{category}`       | Restore a soft-deleted category     |
| DELETE | `/api/master/category/force-delete/{category}`  | Permanently delete a category       |

### Orders

| Method | Endpoint                          | Description                             |
|--------|----------------------------------|-----------------------------------------|
| GET    | `/api/orders/orders`            | View all orders (authenticated users)  |
| POST   | `/api/orders/order`             | Place a new order                      |
| GET    | `/api/orders/order/{code}`      | Get order details                      |


Additional Features (Bonus Implementations)

✅ Image Upload with Validation & Storage
✅ Product Inventory Management (Stock Deduction on Order)


### Admin Panel

    http://127.0.0.1:8000/
    
## Features:
 
Login & Register (without OTP verification)
Admin can View products, categories, and orders along with users and roles and permission
Customer can view Products, categories and their orders.
        
👤 Rosy Jayamani
✉ rosy.stephen64@gmail.com
