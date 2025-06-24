
# Doonamis

# Proyecto Vue 3 + Vite + Laravel

## Descripción

Este proyecto utiliza **Vue 3 con Vite** para el frontend y **Laravel** para el backend. Incluye autenticación con JWT, migraciones y seeders para gestionar la base de datos.

---

## Requisitos previos

- PHP >= 8.x
- Composer
- Node.js >= 16.x
- MySQL

---

## Instalación

### Backend (Laravel)

1. Navega a la carpeta backend y ejecuta composer install:

```bash
cd laravel-doonamis
composer install
```

2. copia .env.example a .env

3. configura las variables de entorno ( Asegurandote de la base de datos MySQL)

4. ejecuta los siguientes comandos 

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan jwt:secret
```

### Frontend (Vue)

1. entra a la carpeta correspondiente (cd vue-doonamis)

2. ejecuta la instalcion de dependecias

```bash
npm install
```

3. copia .env.example a .env y configura VITE_API_URL=http://localhost:8000/api

4. luego corre el siguiente comando para iniciar el servidor de desarrollo. 

```bash
npm run dev
```












