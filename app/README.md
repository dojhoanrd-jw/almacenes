# 🏪 Almacenes API

## 📋 Descripción

**Almacenes API** es esta desarrollada en **Laravel** para la gestión de productos, facturas y usuarios. Proporciona endpoints seguros para operaciones CRUD, autenticación y autorización, validación de datos, paginación y filtrado. Ideal para administrar inventarios y facturación en pequeños y medianos negocios.

## 🛠 Tecnologías Usadas

- **Laravel** (PHP)
- **MySQL**
- **Docker**
- **Sanctum** (autenticación con tokens)
- **PHPUnit** (pruebas)
- **Composer**

## 🚀 Pasos para la Instalación

### Requisitos Previos

- Tener instalado **Docker**
- Tener instalado **Composer**

### Instalación

1. Clona el repositorio:
  

2. Construye y levanta los contenedores de Docker:
   ```bash
   docker-compose up -d
   ```

3. Instala las dependencias de PHP:
   ```bash
   docker exec -it <laravel_app> composer install
   ```

4. Configurar el archivo de entorno y genera la clave de la aplicación:
   ```bash
   docker exec -it <laravel_app> cp .env.example .env
   docker exec -it <laravel_app> php artisan key:generate
   Nota: las variables de entorno de .env.example son las correctas para el funcionamiento de la api
   ```

5. Ejecuta las migraciones para crear la base de datos:
   ```bash
   docker exec -it <laravel_app> php artisan migrate
   ```

6. (Opcional) Ejecuta las pruebas unitarias:
   ```bash
   docker exec -it <laravel_app> php artisan test
   ```

7. Accede a la API usando Postman o cualquier cliente HTTP en `http://localhost:8000`.

## 👤 Usuarios de Prueba

Puedes iniciar sesión en la API usando las siguientes credenciales de administrador por defecto (si existen en tu seed o migraciones):

- **Correo:** juan.perez@ejemplo.com
- **Contraseña:** Contraseña123!

- **Correo:** ana.gomez@ejemplo.com (admin)
- **Contraseña:** Contraseña123!

## 📚 Rutas API Disponibles

> Nota: Todas las rutas protegidas requieren autenticación mediante token.

### Autenticación
- `POST /api/login` — Iniciar sesión y obtener token
- `POST /api/register` — Registrar nuevo usuario
- `POST /api/logout` — Cerrar sesión

### Usuarios
- `GET /api/users` — Listar usuarios
- `GET /api/users/{id}` — Ver usuario
- `POST /api/users` — Crear usuario
- `PUT /api/users/{id}` — Actualizar usuario
- `DELETE /api/users/{id}` — Eliminar usuario

### Productos
- `GET /api/productos` — Listar productos (con paginación y filtros)
- `GET /api/productos/{id}` — Ver producto
- `POST /api/productos` — Crear producto
- `PUT /api/productos/{id}` — Actualizar producto
- `DELETE /api/productos/{id}` — Eliminar producto

### Facturas
- `GET /api/facturas` — Listar facturas (con paginación y filtros)
- `GET /api/facturas/{id}` — Ver factura
- `POST /api/facturas` — Crear factura
- `PUT /api/facturas/{id}` — Actualizar factura
- `DELETE /api/facturas/{id}` — Eliminar factura
