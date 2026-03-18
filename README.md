# LEOFUSION

Backend base en Laravel + MySQL para ferretería y construcción con modelo de venta por cotización (sin stock propio).

## Características implementadas

- Arquitectura MVC con modelos para `users`, `categories`, `products`, `quotes`, `quote_items`, `providers`, `orders`.
- Migraciones MySQL listas para flujo de cotización y pedido.
- Autenticación API con Laravel Sanctum (`register`, `login`, `me`, `logout`).
- Control de acceso por roles (`admin`, `cliente`, `profesional`, `proveedor`) usando middleware `role`.
- CRUD administrativo:
  - Categorías
  - Productos (incluye ficha técnica PDF y `is_quote_only`)
  - Proveedores
- Gestión de cotizaciones:
  - Cliente/profesional crea cotización
  - Admin actualiza estado
  - Admin asigna proveedor y total
  - Cliente aprueba cotización
  - Admin convierte cotización aprobada en pedido
- Gestión de pedidos y reporte básico (`/api/admin/reports/overview`).

## Flujo principal

1. Cliente o profesional envía cotización (`POST /api/quotes`).
2. Admin revisa y marca estado (`PATCH /api/admin/quotes/{quote}/status`).
3. Admin asigna proveedor y total (`POST /api/admin/quotes/{quote}/assign-provider`).
4. Cliente aprueba (`POST /api/quotes/{quote}/approve`).
5. Admin convierte a pedido (`POST /api/admin/quotes/{quote}/convert-to-order`).

## Endpoints principales

### Auth
- `POST /api/auth/register`
- `POST /api/auth/login`
- `GET /api/auth/me`
- `POST /api/auth/logout`

### Cliente / Profesional
- `POST /api/quotes`
- `GET /api/quotes`
- `GET /api/quotes/{quote}`
- `POST /api/quotes/{quote}/approve`

### Admin
- `apiResource /api/admin/categories`
- `apiResource /api/admin/products`
- `apiResource /api/admin/providers`
- `GET /api/admin/quotes`
- `GET /api/admin/quotes/{quote}`
- `PATCH /api/admin/quotes/{quote}/status`
- `POST /api/admin/quotes/{quote}/assign-provider`
- `POST /api/admin/quotes/{quote}/convert-to-order`
- `GET /api/admin/orders`
- `GET /api/admin/orders/{order}`
- `PATCH /api/admin/orders/{order}`
- `GET /api/admin/reports/overview`

## Notas de integración

- El backend está preparado para conectarse al front Bootstrap existente.
- No se maneja inventario: la lógica usa `products.is_quote_only = true` como enfoque por defecto.
- `price_reference` es referencial y opcional.
