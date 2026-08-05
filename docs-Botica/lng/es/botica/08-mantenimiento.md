# 8. Mantenimiento y solución de problemas

## Antes de modificar

1. Haz una copia del proyecto.
2. Exporta la base de datos.
3. Cambia un módulo a la vez.
4. Prueba Inicio, Pedidos, Cobranza, Inventario, Productos y Reportes.
5. Revisa el registro de Apache y PHP si aparece un error 500.

## La clase no se encuentra

Comprueba:

- Nombre exacto de la clase.
- Ruta equivalente al nombre.
- Prefijo `mwap_botica_`.
- Registro de `botica` en `src/app/init.php`.
- Mayúsculas y minúsculas en hosting Linux.

Ejemplo correcto:

```text
mwap_botica_productos_uiadmin_inicio
src/mwap/modules/botica/productos/uiadmin/inicio.php
```

## La opción no aparece en el menú

Revisa en `src/mwap/modules/demo/uiadmin/main.php`:

1. Que el código esté en `su_cods_for_side`.
2. Que exista `create_subinterface_<codigo>()`.
3. Que la clase exista.
4. Que `is_allowed()` permita al usuario actual.

## CSS o JavaScript no carga

Comprueba:

- Que el archivo esté bajo `src/public_html/res/`.
- Que la URL comience con `/res/`.
- Que el nombre sea exactamente `ui.css` o `ui.js` según la referencia.
- La consola del navegador.
- Una recarga forzada con `Ctrl + F5`.
- El parámetro de versión de caché.

## Los botones no funcionan

Revisa:

1. Errores de JavaScript en la consola.
2. Que la clase de JavaScript coincida con `js_ui_class_name`.
3. Que el método `init()` se ejecute.
4. Que los identificadores del HTML coincidan con los buscados por JavaScript.
5. Que los botones dentro de formularios tengan el tipo correcto.

## El formulario recarga pero no registra

Comprueba:

- `method="post"`.
- Campo oculto de acción esperado por PHP.
- Nombres de los inputs.
- Excepción mostrada por el manager.
- Conexión y permisos de la base.
- Estructura real de las tablas.

Acciones actuales:

```text
Pedidos:  pedido_accion = registrar
Productos: producto_accion = guardar | agregar_stock | eliminar
Cobranza: accion según el formulario de pago
```

## Stock incorrecto

El stock se descuenta dentro de la transacción del pedido. Si no cambia:

- Comprueba que el pedido se haya confirmado.
- Revisa si ocurrió un `ROLLBACK`.
- Verifica que `productos.estado = 1`.
- Verifica el identificador del producto.
- Revisa el error `No se pudo actualizar el stock del producto`.

## Reportes sin datos

Los reportes se basan en pagos registrados, no solo en pedidos creados. Comprueba:

- Que existan registros en `pagos`.
- Que los pedidos estén relacionados.
- Que la fecha esté en `fecha_pago`, `fecha_registro` o `fecha_pedido`.
- Que los filtros de fecha incluyan los registros.

## Cambio de estructura de base de datos

Antes de eliminar una columna, busca su uso en todo el proyecto.

Ejemplo:

```text
estado_despacho
```

Aunque no existe una pantalla de Despacho, el manager de Pedidos todavía inserta ese campo. Eliminarlo únicamente en MySQL provocaría un error al registrar pedidos.

## Revisión rápida por módulo

### Pedidos

- Lista productos activos.
- Agrega y elimina del carrito.
- Conserva temporalmente los datos.
- Registra pedido.
- Descuenta stock.

### Cobranza

- Lista pendientes.
- Abre un pedido.
- Registra pago.
- Cambia a Pagado.
- Genera ticket.

### Productos

- Registra producto.
- Evita códigos repetidos.
- Aumenta stock.
- Elimina lógicamente.

### Inventario

- Muestra stock y vencimiento.
- Marca estados visuales según los datos.

### Reportes

- Filtra fechas.
- Resume ventas pagadas.
- Agrupa productos, clientes y métodos.
