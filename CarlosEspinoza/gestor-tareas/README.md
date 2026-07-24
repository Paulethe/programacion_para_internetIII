# Gestor de Tareas

Aplicación web simple para gestionar tareas, construida con Laravel 8 y AngularJS 1.x.

## Requisitos

- PHP ^7.3
- MySQL
- Composer

## Instalación

```bash
composer install
cp .env.example .env
# Configurar base de datos en .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```