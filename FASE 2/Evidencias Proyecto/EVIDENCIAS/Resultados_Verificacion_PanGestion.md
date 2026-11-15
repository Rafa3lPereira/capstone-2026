# Resultados de verificación de PanGestión

Autores: Rafael Pereira y Hardy Vega. Revisión de noviembre de 2026 en una copia local aislada.

**Origen:** Capstone (1).zip · noviembre de 2026. SHA-256 del ZIP recibido: `841669c2f023e8c1e07a5b6d9bb18fd2d660eb71644c6e779abe3f9895951614`. El paquete original no forma parte de la publicación.

| Verificación | Herramienta | Resultado observado |
|---|---|---|
| Interfaz | Node.js 24.22.1 | 103 pruebas aprobadas, sin errores ni omitidas. |
| Lógica unitaria | PHP 8.5.12 / PHPUnit 12.5.35 | 176 pruebas aprobadas, 843 aserciones. |
| Integración | PHPUnit / PostgreSQL 18.7 | 2.278 pruebas aprobadas, 14.442 aserciones. |
| Migraciones | Laravel / PostgreSQL 18.7 | 47 migraciones aplicadas en la copia de demostración. |
| Recursos de la interfaz | Vite 7.3.6 | Compilación correcta; 65 módulos transformados. |
| Venta sintética | Servicio de venta y base DEMO | 2 unidades a $800; total $1.600, recibido $2.000, vuelto $400 y saldo 22,000 unidades. |

La ejecución funcional usó una base separada de la demostración. No se importaron datos de la transferencia ni se ejecutaron pruebas sobre una instalación operativa. Los resultados se limitan a los escenarios automatizados y de demostración. La entrega se evaluó en una copia local con datos sintéticos. Panadería Almapan aceptó el alcance entregado, según informó el equipo del proyecto. La medición de carga y la auditoría externa quedan fuera de las pruebas registradas.

**Revisión de los datos de transferencia:** se leyeron cuatro CSV UTF-8 sin claves vacías o repetidas, errores de columnas ni referencias huérfanas en SKU, categoría y unidad. Se verificó su estructura sin importar o publicar sus filas.

## Dónde se hicieron las pruebas

- [Pruebas unitarias](../../PROYECTO/tests/Unit) con PHPUnit para la lógica de PHP.
- [Pruebas funcionales y de integración](../../PROYECTO/tests/Feature) con Laravel y PHPUnit en PostgreSQL aislado. Cubren, entre otros casos, acceso, ventas, inventario, recepciones, pedidos y caja.
- [Pruebas automatizadas de interfaz](../../PROYECTO/tests/Frontend) con Node.js. Incluyen una simulación de la entrada del lector.
- [Demostración local en navegador](Guion_Demostracion.md) con una base sintética distinta de la base de pruebas.

Postman permite comprobar solicitudes HTTP de forma opcional. La ejecución documentada utilizó PHPUnit, Node.js y un navegador. La verificación con lector y balanza físicos, la restauración y la medición de carga son actividades de continuidad. [Documentación de Postman](https://learning.postman.com/docs/use/send-requests/requests/).
