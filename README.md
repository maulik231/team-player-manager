# TEAM-PLAYER-MANAGER

### Requirements

-   php 8.3+
-   node(lts) 20+

### Setup on linux

### Install Backend Dependencies

```
composer install
```

### Install Frontend Dependencies

```
npm install
```

### Environment Configuration

```
cp .env.example .env
```

### Run Migrations and Seed the Database

```
php artisan migrate
php artisan db:seed
```

### Run the Laravel Development Server (Both Vue and Laravel server)

```
npm run dev
php artisan serve
```
