<p align="center" style="display: flex; justify-content: center; align-items: center;">
  <a href="https://all4it.org" target="_blank" style="margin-left: 20px; margin-right: 20px;">
    <img src="https://all4it.org/storage/01JCJT95TT3PTZTDFW5ESD79FP.svg" width="100" alt="All4IT Logo">
  </a>
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# Laravel: All4it.org backend

Welcome to the backend API of website [All4it.org](https://all4it.org/), built with Laravel. This repository handles the core logic and serves as the bridge between the front-end React application and the database. Our Laravel-based API is designed to provide a seamless and efficient experience for users and administrators alike.

## Architecture

The project follows a clean and maintainable architecture:

- **Controllers**: Handle incoming HTTP requests. Each controller method is responsible for processing a specific action, such as fetching or updating data.
- **Services**: Contains the business logic of the application. Services are used in conjunction with controllers to handle more complex operations and to keep the controllers lightweight and clean.
- **Models**: Represent the database structure and interact with the database using Laravel's Eloquent ORM.

This separation of concerns makes the application scalable, maintainable, and easy to extend.

---

## Features

- **API Endpoints**: A comprehensive set of RESTful API endpoints that handle everything required for web forms, retrieving information from the database, and user authentication. The API seamlessly integrates with the frontend to manage form submissions, fetch data dynamically, and ensure secure access with built-in user authentication features, making it easy to manage both user interactions and data processing.
- **Admin Panel**: The project integrates with [Filament](https://filamentphp.com/), a beautiful and powerful admin panel for managing e-commerce data.
- **Authentication & Authorization**: Built-in user authentication using Laravel's Passport or Sanctum, ensuring secure API access.
- **Validation**: All input data is validated to ensure correctness and prevent security vulnerabilities.

---

## Frontend

The front-end of the application is developed in React and exists in a separate repository. The React application communicates with the Laravel API to fetch and display data dynamically. For more details on the front-end setup, visit the repository:

[Frontend Repository](https://github.com/frontend)

---

## **Preview**
Below is a screenshot of the website:

![Website Screenshot](https://all4it.org/storage/all4it.jpg "Website Screenshot")

---

## Installation

### Prerequisites

- PHP 8.0 or higher
- Laravel 10
- Composer
- MySQL or another database of your choice
- Node.js and npm (for running the frontend)

### Setup

1. Clone the repository:

   `git clone https://github.com/repo`

   `cd your-laravel-repo`

2. Install dependencies: `composer install`

3. Set up your environment variables:

   Copy `.env.example` to `.env` and update the database and API keys: `cp .env.example .env`

4. Generate the application key: `php artisan key:generate`

5. Run database migrations: `php artisan migrate`

6. Start the Laravel server: `php artisan serve`
    
    Alternatively, you can configure any web server of your choice, such as Apache or Nginx, to serve the application. Ensure that the server is configured to point to the `public` directory, as this is where the application is accessed.

The API should now be up and running at `http://localhost:8000`.

---

## Admin Panel

The admin panel is powered by [Filament](https://filamentphp.com/), offering a modern and sleek interface to manage the system. It allows administrators to perform various actions such as:

- Managing pages
- Handling users
- Configuring system settings

Filament provides an intuitive and fast interface for managing your web platform without the need for complex development.

---

## **Contact Us**

Interested in building your custom e-commerce solution? Contact our team for a consultation and let’s create something exceptional together!

## 💼 [Mail us](mailto:info@all4it.org) | 🌐 [Our web-site](https://all4it.org/)

---
