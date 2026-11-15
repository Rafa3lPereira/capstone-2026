# Arquitectura y modelo de datos de PanGestión

## Registro de una venta

El navegador muestra las vistas Blade. Laravel recibe la solicitud, valida la sesión y los datos de entrada. `SaleService` comprueba el permiso y abre la transacción. `SaleExecutionService` coordina la venta, los cobros y sus efectos en inventario y caja. PostgreSQL persiste los cambios asociados a la operación.

- [Arquitectura y flujo de la venta](Capturas/Arquitectura_PanGestion.png).
- [Punto de venta de PanGestión](Capturas/venta.png) y [movimiento en el historial de inventario](Capturas/movimientos.png). La demostración registró dos unidades a $800, $400 de vuelto y un saldo de 22 unidades.
- [Rutas web](../../PROYECTO/routes/web.php), [controlador](../../PROYECTO/app/Http/Controllers/SaleController.php) y [servicios de venta](../../PROYECTO/app/Services/Sales).

## Esquema relacional

- [Ventas, cobros y caja](Capturas/Modelo_Ventas_Caja_PanGestion.png). La sesión vincula ventas y movimientos con su caja. Las líneas y los pagos guardan su propia referencia a la venta.
- [Inventario y recepciones](Capturas/Modelo_Inventario_Recepciones_PanGestion.png). Los movimientos guardan el cambio y los saldos anterior y posterior. Según la causa, pueden referenciar la línea de una venta o una recepción. El saldo diario se guarda por artículo y fecha comercial.
- En los diagramas, PK identifica una clave primaria y FK una clave foránea. N representa varios registros y 0..1 indica una referencia opcional. [Migraciones de Laravel](../../PROYECTO/database/migrations).
