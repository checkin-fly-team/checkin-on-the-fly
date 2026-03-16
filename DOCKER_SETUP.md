# Docker Setup Guide for Checkin On The Fly

## Overview
This Docker Compose setup includes:
- **PHP-FPM**: Application container running PHP 8.2
- **Nginx**: Web server handling HTTP requests
- **MySQL**: Database server
- **Redis**: Cache and queue driver
- **Node.js**: Frontend asset compilation with Vite

## Prerequisites
- Docker and Docker Compose installed
- A `.env` file in the project root

## Getting Started

### 1. Setup Environment
Copy the default `.env.example`:
```bash
cp .env.example .env
```

### 2. Generate Laravel App Key
```bash
docker-compose exec app php artisan key:generate
```

### 3. Run Migrations
```bash
docker-compose exec app php artisan migrate
```

### 4. Build and Start Containers
```bash
docker-compose up -d --build
```

### 5. Install Frontend Dependencies
```bash
docker-compose exec node npm install
```

## Useful Commands

### View Logs
```bash
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f db
```

### Access the Application
- Application: http://localhost
- Vite Dev Server: http://localhost:5173

### Artisan Commands
```bash
docker-compose exec app php artisan tinker
docker-compose exec app php artisan queue:work
docker-compose exec app php artisan cache:clear
```

### Database Access
```bash
docker-compose exec db mysql -u laravel -p checkin
# Use password: password (default)
```

### Stop Containers
```bash
docker-compose down
```

### Remove All Data (including database)
```bash
docker-compose down -v
```

## Environment Variables for Dockploy

When deploying with Dockploy, ensure you set these environment variables:
- `APP_KEY`: Laravel application key (generate with `php artisan key:generate`)
- `DB_HOST`: Database host (use container name: `db`)
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: Database credentials
- `REDIS_HOST`: Redis host (use container name: `redis`)
- `APP_DEBUG`: Set to `false` in production

## Troubleshooting

### Permission Issues
If you get permission errors, rebuild the containers:
```bash
docker-compose down
docker-compose up -d --build
```

### Database Connection Issues
Ensure the database is healthy:
```bash
docker-compose exec db mysqladmin ping
```

### Node Modules Issues
Clear node_modules and reinstall:
```bash
docker-compose exec node rm -rf node_modules package-lock.json
docker-compose exec node npm install
```

## Production Considerations for Dockploy

1. **Change Default Passwords**: Update all passwords in `.env`
2. **Set APP_DEBUG=false**: Critical for production
3. **Use Strong APP_KEY**: Generate a secure key
4. **Set Up SSL/TLS**: Update Nginx config with your certificates
5. **Configure Proper Logging**: Use Syslog or centralized logging
6. **Set Resource Limits**: Adjust container memory/CPU limits as needed
7. **Use Production Database**: Consider using managed MySQL database service instead of container

## SSL/TLS Setup
1. Place certificates in `docker/nginx/ssl/`
2. Update `docker/nginx/conf.d/app.conf` with SSL configuration
3. Rebuild Nginx container
