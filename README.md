# Jupit Technical Test

This technical test assesses your proficiency in microservices architecture, focusing on API design and implementation with PHP/Laravel for authentication services and Node.js/JavaScript for notification services.

## Question

Your task is to develop an authentication API flow (registration/login) within a Laravel microservice, which will handle authentication logic. Additionally, all mail and notification processes triggered by these authentication actions should be handled by a separate Node.js microservice. The seamless integration between these two services via REST API is crucial.

## 🔗 Links

- [Node.js Notification Microservice Repository](https://github.com/Tsdjimmy/jupit-nodejs-test)

## Assumptions

The case study assumes:

1. Both microservices communicate via REST API.
2. The system is deployed on separate Linux machines.
3. The development approach is test-driven.
4. All implementations are functional.

## How to Submit

1. Clone the respective repository.
2. Create a new branch named after your email address.
3. Complete your work on this new branch.
4. Push your code along with the Postman API documentation.
5. Repeat the steps for both the Laravel and Node.js microservices.
6. Ensure all submissions are made before the deadline.

## Setup Instructions for Laravel Authentication Service

### Prerequisites

- PHP (>= 7.3)
- Composer
- Laravel-supported database (MySQL, PostgreSQL, SQLite, SQL Server)
- RabbitMQ Server

### Installation & Configuration

1. **Clone the Repository**

   ```bash
   git clone https://github.com/Tsdjimmy/jupit-laravel-test.git
   cd jupit-laravel-test
   ```

2. **Install Composer Dependencies**

   This includes the necessary package for RabbitMQ integration.

   ```bash
   composer install
   ```

   Ensure `php-amqplib/php-amqplib` is included in your `composer.json` file for RabbitMQ communication.

3. **Environment Setup**

   Copy the `.env.example` file to a new `.env` file. Adjust database settings and other environment variables as necessary.

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Migrations**

   Run migrations to set up your database schema.

   ```bash
   php artisan migrate
   ```

5. **Laravel Sanctum for API Authentication**

   Install Laravel Sanctum for SPA authentication:

   ```bash
   composer require laravel/sanctum
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

   Ensure your `api` middleware group is using Sanctum's `EnsureFrontendRequestsAreStateful` middleware for API token authentication.

6. **RabbitMQ Messaging**

   Ensure your `.env` file contains the correct RabbitMQ service credentials and the necessary configuration for Laravel to publish messages to the queue.

7. **Start the Laravel Development Server**

   ```bash
   php artisan serve
   ```

   Your Laravel application should now be accessible.

### Testing

Refer to the provided [Postman documentation](https://documenter.getpostman.com/view/10059500/2sA35D5iCQ) for details on how to test the API endpoints. Ensure your Node.js notification service is running and configured to receive messages from Laravel through RabbitMQ.
