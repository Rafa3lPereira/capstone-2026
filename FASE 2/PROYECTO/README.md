# PanGestión para Panadería Almapan

Proyecto APT de **Rafael Pereira y Hardy Vega**, Ingeniería en Informática, Duoc UC, Puerto Montt.

Aplicación web Laravel y PostgreSQL para catálogo, ventas, pedidos, inventario, recepciones, mermas, caja y administración. Producción y recetas, personal y proveedores permanecen en el código con sus entradas de navegación desactivadas para la demostración académica. El control de acceso se aplica en el servidor.

## Preparación local

1. Instalar PHP compatible con `composer.lock` (verificado con PHP 8.5.12) con `pdo_pgsql`, `mbstring`, `dom`, `openssl` y extensiones que indique Composer. Instalar Composer, PostgreSQL y Node.js en una versión admitida por Vite. Usar una base PostgreSQL nueva y una cuenta local con permisos sobre esa base.
2. Ejecutar `composer install` y `npm ci`. Copiar `.env.example` a `.env` y configurar la conexión PostgreSQL propia, la zona de uso y el entorno local. No usar credenciales de otra instalación. Para una demo local aislada se pueden usar sesiones en archivo, caché en archivo y cola síncrona.
3. Ejecutar `php artisan key:generate` y `php artisan migrate`. Aplicar los seeders de `database/seeders` con `php artisan db:seed --class=NombreDelSeeder` (hay nueve). Preparan permisos y métodos de pago; no crean datos operacionales de la panadería.
4. Usar `php artisan pangestion:bootstrap-admin` para crear la primera cuenta con credenciales locales. Crear los catálogos y abrir la caja según el guion de demostración; los datos de ejemplo son sintéticos.
5. Ejecutar `npm run build` y `php artisan serve --host=127.0.0.1`. El servidor de desarrollo se usa para verificación local.

## Verificación

- Interfaz: `node --test tests/Frontend/*.test.cjs`.
- Pruebas unitarias: `php vendor/phpunit/phpunit/phpunit --testsuite Unit`.
- Integración: preparar PostgreSQL y `.env.testing` en un entorno desechable, con base `pangestion_test` y rol `pangestion_test_user` propios. Ejecutar `php vendor/phpunit/phpunit/phpunit --testsuite Feature`. La suite verifica el entorno, base y rol antes de ejecutar; no conectar una base operativa.

Las evidencias académicas están en la [carpeta de evidencias](../Evidencias%20Proyecto). El repositorio excluye datos de la transferencia, respaldos, registros, claves y archivos de entorno. Los directorios de dependencias y recursos compilados se reconstruyen localmente desde los archivos de bloqueo.
