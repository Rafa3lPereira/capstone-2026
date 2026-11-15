# PanGestión · Seguimiento Kanban

Rafael Pereira y Hardy Vega · Actualización del 15 de noviembre de 2026

Adoptamos Kanban para el seguimiento y cierre de PanGestión. Los cuatro estados del tablero son Por hacer, En curso, En revisión y Listo. Priorizamos por impacto y dependencia. Al liberar capacidad, tomamos la siguiente tarea preparada. La carta Gantt conserva los hitos y el tablero muestra el estado de cada tarea según su evidencia.

El tablero Registro de tareas se configuró en Notion en noviembre de 2026. La carga inicial reconstruye el estado del proyecto a partir de los documentos, el código y las pruebas disponibles. Se usa la carta Gantt como referencia para los hitos anteriores a la creación del tablero.

## Base de datos Registro de tareas

Importa `PanGestion_Tareas_Notion.csv` mediante **Configuración → Importar → CSV** o con `/csv`. Usa **Tarea** como título. Configura **Estado** como selección o estado, **Prioridad** y **Área** como selección, **Evidencia** como URL, y **RACI**, **Criterio de aceptación** y **Observación** como texto. Al importar, conserva **Responsable** y **Revisor** como texto o selección. Si agregas propiedades de persona, asigna después las cuentas reales de Rafael y Hardy. No simules usuarios o fechas.

- **Todas las tareas**: vista tabla. Mostrar ID, estado, responsable, revisor, área y prioridad.
- **Tablero**: vista tablero agrupada por Estado, en orden Por hacer, En curso, En revisión, Listo. Mostrar ID, prioridad y responsable. Mantener visibles los grupos vacíos.
- **Mis tareas**: vista tabla filtrada por Responsable, con una variante por integrante.
- **Validación pendiente**: vista tabla para piloto, dispositivos, restauración y carga.

El archivo CSV carga las tareas. Configura las vistas, propiedades de persona y la plantilla de tarjeta en Notion. Si ya existe un registro, revisa los IDs antes de importar para evitar duplicados.

## Acuerdos de trabajo

| Estado | Política para cambiar de estado |
|---|---|
| Por hacer | Tiene responsable, prioridad, criterio y dependencias claras antes de empezar. |
| En curso | Se registra inicio real cuando hay capacidad. Si hay bloqueo, conservar el estado y registrar causa y siguiente paso. |
| En revisión | Enlazar el resultado, la prueba o el documento y solicitar revisión del compañero. |
| Listo | El criterio se comprobó y el revisor registró su conformidad técnica. |

El equipo limita el trabajo iniciado a dos tarjetas entre En curso y En revisión, incluidas las bloqueadas. Cada integrante mantiene como máximo una tarjeta activa. Si hay un bloqueo, se registra su causa y el siguiente paso. Antes de iniciar otra tarea se prioriza revisar o desbloquear lo que ya está abierto.

Una tarjeta pasa a En revisión con el cambio o la evidencia publicada y el resultado de la comprobación. Pasa a Listo cuando la otra persona verifica el criterio de aceptación y se enlaza el respaldo. La aceptación de la panadería se registra durante el piloto.

Agregar como propiedades opcionales **Bloqueada** (casilla), **Inicio real** y **Cierre real** (fechas) y **Motivo del bloqueo** (texto). Los registros reconstruidos conservan sus fechas reales vacías si no hay evidencia de inicio o cierre.

En la revisión semanal se observan las tareas abiertas, los bloqueos y el tiempo transcurrido desde el inicio. Al registrar fechas reales se podrá contar cuántas tareas se completan por semana y medir el tiempo de ciclo desde En curso hasta Listo.

## Plantilla de tarjeta

- **Objetivo:** qué resultado necesita la panadería o el proyecto.
- **Actividades:** lista de comprobación con pasos de trabajo.
- **Criterio de aceptación:** qué debe observar el revisor.
- **Prueba:** entorno, datos sintéticos utilizados, resultado esperado y observado.
- **Evidencias:** enlace al informe, prueba, captura o cambio en el repositorio.
- **Revisión:** responsable, revisor, observaciones y fecha real de cierre.

### Ejemplo · KB-06 Comprobar venta y salida de existencias

- [x] Registrar una venta de dos unidades de un artículo de muestra a $800.
- [x] Comprobar total de $1.600 y vuelto de $400 al recibir $2.000.
- [x] Comprobar que el saldo pase de 24 a 22 unidades.
- Ejercicio local con datos sintéticos. [Registro de la verificación](https://github.com/Rafa3lPereira/capstone-2026/blob/main/FASE%202/Evidencias%20Proyecto/EVIDENCIAS/Resultados_Verificacion_PanGestion.md).

Fuentes: [Guía Kanban](https://kanbanguides.org/es-es/the-kanban-guide/), [Importar CSV en Notion](https://www.notion.com/help/import-data-into-notion) y [Agrupar un tablero por estado](https://www.notion.com/help/guides/status-property-gives-clarity-on-tasks).
