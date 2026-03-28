# ArrayStock - Sistema de Inventario para Bar/Restaurante

Sistema web de gestión de inventario diseñado para bares y restaurantes. Permite controlar productos, proveedores, categorías y movimientos de stock en tiempo real, con alertas automáticas de stock bajo y un panel de análisis visual.

## Tecnologías

- **Backend:** PHP 8.3+ / Laravel 13
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Gráficos:** Chart.js
- **Autenticación:** Laravel Breeze
- **Build:** Vite

## Funcionalidades

- **Dashboard analítico** — KPIs en tiempo real, gráficos de movimientos (entradas vs salidas), distribución por categoría y productos más consumidos.
- **Gestión de productos** — CRUD completo con SKU, precio, costo, stock mínimo, unidad de medida e imagen. Filtros por nombre, categoría y stock bajo.
- **Categorías** — Organización de productos con color personalizable para identificación visual.
- **Proveedores** — Registro de proveedores con datos de contacto. Relación muchos-a-muchos con productos (costo y referencia por proveedor).
- **Movimientos de stock** — Registro de entradas, salidas y ajustes con trazabilidad completa (usuario, cantidad anterior/nueva, motivo). Filtros por producto, tipo y rango de fechas.
- **Alertas de stock bajo** — Comando programable que detecta productos por debajo del stock mínimo y envía notificaciones por correo electrónico.
- **Autenticación completa** — Registro, login, verificación de email, recuperación de contraseña y gestión de perfil.

## Requisitos previos

- PHP >= 8.3
- Composer
- Node.js >= 18
- Base de datos compatible (MySQL, PostgreSQL o SQLite)

## Instalación

```bash
# Clonar el repositorio
git clone https://github.com/miguelmartt/Inventario-Bar-Restaurante.git
cd Inventario-Bar-Restaurante

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar la base de datos en .env y ejecutar migraciones
php artisan migrate

# Compilar assets
npm run build
```

## Uso

```bash
# Servidor de desarrollo (Laravel + Vite + Queue + Logs)
composer dev

# O iniciar solo el servidor
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`.

### Verificar alertas de stock bajo

```bash
php artisan stock:check-alerts
```

## Estructura del proyecto

```
app/
├── Console/Commands/     # Comando de alertas de stock
├── Http/Controllers/     # Controladores (Dashboard, Product, Category, Supplier, StockMovement, Profile)
├── Mail/                 # Mailable de alerta de stock bajo
└── Models/               # Modelos Eloquent (User, Product, Category, Supplier, StockMovement)
database/
├── migrations/           # Esquema de base de datos
├── factories/            # Factories para testing
└── seeders/              # Seeders
resources/views/          # Vistas Blade organizadas por módulo
routes/web.php            # Definición de rutas
```

## Desarrollado por

Este proyecto ha sido desarrollado por **VérticeDev** — [verticedev.es](https://verticedev.es)

## Licencia

Este proyecto está licenciado bajo la [MIT License](https://opensource.org/licenses/MIT).
