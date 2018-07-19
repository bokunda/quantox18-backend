# Initialization

### Git clone
```
git clone https://github.com/bokunda/quantox18-backend
```

### Change working directory
```
cd quantox18-backend
```
### Env file
```
cp .env.example .env
```
### Composer update
```
composer update
```
### Generate Laravel key
```
php artisan key:generate
```
### Setup database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=username
DB_PASSWORD=password
```
### Migration
```
php artisan migrate --seed
```

## JWT installation

#### Install 
```
composer require tymon/jwt-auth:1.0.0
```
### Publish files
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
### Generate JWT secret code
```
php artisan jwt:secret
```