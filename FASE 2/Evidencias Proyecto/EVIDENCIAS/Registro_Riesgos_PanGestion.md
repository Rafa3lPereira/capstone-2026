# Registro de riesgos de PanGestión

Rafael Pereira y Hardy Vega · Noviembre de 2026

| ID | Riesgo | Probabilidad | Impacto | Respuesta | Responsable | Estado |
|---|---|---|---|---|---|---|
| R01 | Saldo inconsistente entre operación y libro | Alta | Alta | Probar confirmaciones y reversos en base aislada; conciliar saldo y movimientos. | Rafael | Abierto a piloto |
| R02 | Cierre o arqueo con diferencia sin explicación | Media | Alta | Registrar diferencia, observación y fondo. Revisar reportes con datos sintéticos. | Rafael y Hardy | Control implementado |
| R03 | Permisos incorrectos o fuga de datos | Media | Alta | Revisar perfiles y rutas; mantener credenciales y filas internas fuera del repositorio. | Hardy | Control implementado |
| R04 | Migraciones de ambos integrantes en conflicto | Media | Alta | Coordinar orden de migraciones, revisar cambios y aplicar en copia limpia. | Rafael y Hardy | En seguimiento |
| R05 | Confundir visibilidad de menú con autorización | Media | Alta | Revisar acceso a rutas con perfiles permitidos y denegados; separar alcance de permisos. | Hardy | En seguimiento |
| R06 | No lograr validar operación antes de la entrega | Media | Alta | Ensayar guion, asignar responsables y solicitar validación con usuario y registro de observaciones. | Rafael y Hardy | Pendiente |
| R07 | Respaldo no restaurable | Media | Alta | Probar restauración en base desechable y comprobar tablas, saldos y secuencias. | Rafael | Pendiente |
| R08 | Errores de pesos, montos o fecha comercial | Media | Media | Probar decimales, códigos con ceros y cambios de día en Santiago. | Rafael y Hardy | En seguimiento |
