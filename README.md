# Geoglify Starter Kit

Welcome to the Geoglify Starter Kit! This kit provides a ready-to-use foundation for building your new Laravel application, using Laravel Breeze with Vue.js. It comes with everything you need, including PostgreSQL/PostGIS integration and a Docker environment, so you can start coding right away. The frontend Vue.js will be compiled automatically.

## What's Included?

The Geoglify Starter Kit includes:

- **Laravel Breeze with Vue.js**: A complete setup for user authentication and management, utilizing Laravel Breeze and Vue.js to build your geoapp.
  - **Backend with Laravel**: Includes essential routes, controllers, and views for authentication and other core features.
  - **Frontend with Vue.js**: Integrated with Laravel Breeze for a modern, responsive user interface.

- **PostgreSQL/PostGIS**: A PostgreSQL database configured with PostGIS support for geospatial operations.

- **Docker Setup**: A Docker environment that manages all necessary services:
  - **Alpine Linux**: Lightweight Linux distribution used for the base image.
  - **Supervisor**: Process control system to manage multiple processes.
  - **Nginx**: Web server for serving the Laravel application.
  - **PHP-FPM**: PHP FastCGI Process Manager for handling PHP requests.
  - **OPCache**: PHP Opcode caching to improve performance.
  - **Vite**: Modern frontend tool for building and serving Vue.js assets, offering fast development and efficient production builds.


## Getting Started

### 1. Clone the Repository

Clone the Geoglify Starter Kit repository to your local machine:

```bash
git clone https://github.com/geoglify/starter-kit.git
```

### 2. Set Up and Start Docker
Navigate to the project folder and start the Docker containers. 
This will automatically install all dependencies and configure the environment.

```bash
cd starter-kit
docker-compose up -d
```

Docker will set up the environment, install Laravel and Vue.js dependencies, and prepare the PostgreSQL/PostGIS database.

### 3. Access the Application
Your application is now ready and available at http://localhost:8080.

### Customization
The Geoglify Starter Kit is highly customizable. You can modify both the backend and frontend, and adjust the Docker setup to add new services or change existing configurations as needed. This project is open-source software licensed under the [MIT license](LICENSE).

Inspired by: https://github.com/jdsantos/laravel-alpine-nginx-phpfpm-opcache-docker/blob/main/README.md
