# 3. Módulos de Botica

## Resumen

| Módulo | Código de URL | PHP | Recursos públicos | Tablas principales |
|---|---|---|---|---|
| Inicio | `welcome` | `demo/uiadmin/welcome.php` | `demo/uiadmin/welcome.css` | Actualmente no consulta BD |
| Pedidos | `obec` | `botica/pedidos/` | `botica/pedidos/` | `productos`, `pedidos`, `detalle_pedido` |
| Cobranza | `cobranza` | `botica/cobranza/` | `botica/cobranza/` | `pedidos`, `detalle_pedido`, `productos`, `pagos` |
| Inventario | `inventario` | `botica/inventario/` | `botica/inventario/` | `productos` |
| Agregar producto | `agregarproducto` | `botica/productos/` | `botica/productos/` | `productos` |
| Reportes | `reportes` | `botica/reportes/` | `botica/reportes/` | `pagos`, `pedidos`, `detalle_pedido`, `productos` |

## Inicio

Archivos:

```text
src/mwap/modules/demo/uiadmin/welcome.php
src/public_html/res/modules/demo/uiadmin/welcome.css
```

Responsabilidad:

- Mostrar bienvenida.
- Presentar accesos rápidos.
- Enlazar con las rutas reales.

Actualmente muestra estados neutrales (`Sin datos`) y no consulta directamente la base de datos.

## Pedidos

Archivos PHP:

```text
src/mwap/modules/botica/pedidos/uiadmin.php
src/mwap/modules/botica/pedidos/uiadmin/pedidos.php
src/mwap/modules/botica/pedidos/man.php
```

Recursos:

```text
src/public_html/res/modules/botica/pedidos/ui.css
src/public_html/res/modules/botica/pedidos/ui.js
```

Métodos principales del manager:

```php
get_productos_disponibles()
registrar_pedido($datos)
```

Flujo de registro:

1. Valida nombre, documento, teléfono, dirección y carrito.
2. Agrupa cantidades por producto.
3. Inicia una transacción.
4. Bloquea cada producto mediante `FOR UPDATE`.
5. Verifica que esté activo y tenga stock.
6. Calcula subtotal.
7. Calcula IGV del 18 %.
8. Inserta el pedido como `Pendiente`.
9. Genera un código como `PED-00001`.
10. Inserta el detalle.
11. Descuenta el stock.
12. Confirma la transacción.

El carrito y los datos del cliente se guardan temporalmente en `localStorage` con estas claves:

```text
botica_pedido_carrito
botica_pedido_cliente
```

## Cobranza

Archivos PHP:

```text
src/mwap/modules/botica/cobranza/uiadmin.php
src/mwap/modules/botica/cobranza/uiadmin/inicio.php
src/mwap/modules/botica/cobranza/man.php
src/mwap/modules/botica/cobranza/mercadopago.php
```

Métodos principales:

```php
get_pedidos_pendientes()
get_pedido_pendiente($pedidoId)
registrar_pago($datos)
registrar_pago_mercadopago($pagoMercadoPago)
```

Flujo del pago manual:

1. Valida pedido, método y monto.
2. Bloquea el pedido con `FOR UPDATE`.
3. Comprueba que continúe pendiente.
4. Calcula el vuelto.
5. Inserta el pago.
6. Cambia `estado_pago` a `Pagado`.
7. Consulta el detalle para generar el ticket.
8. Confirma la transacción.

Mercado Pago usa Checkout Pro y crea una referencia con este formato:

```text
BOTICA_PEDIDO_<ID>
```

La moneda configurada es PEN.

## Inventario

Archivos:

```text
src/mwap/modules/botica/inventario/uiadmin.php
src/mwap/modules/botica/inventario/uiadmin/inicio.php
src/mwap/modules/botica/inventario/man.php
```

Método principal:

```php
get_inventario()
```

Consulta productos activos y presenta:

- Código.
- Nombre.
- Categoría.
- Precio.
- Stock.
- Stock mínimo.
- Fecha de vencimiento.

Cuando `stock_minimo` no tiene valor, el código usa `5` como valor predeterminado.

## Productos

Archivos:

```text
src/mwap/modules/botica/productos/uiadmin.php
src/mwap/modules/botica/productos/uiadmin/inicio.php
src/mwap/modules/botica/productos/man.php
```

Métodos principales:

```php
listar_productos()
listar_productos_para_stock()
guardar_producto($datos)
agregar_stock($productoId, $cantidadAgregar)
eliminar_producto($productoId)
fecha_es_valida($fecha)
```

La eliminación es lógica:

```sql
UPDATE productos
SET estado = 0
WHERE id = ?
```

Por tanto, el registro permanece en la base de datos, pero deja de mostrarse como producto activo.

## Reportes

Archivos:

```text
src/mwap/modules/botica/reportes/uiadmin.php
src/mwap/modules/botica/reportes/uiadmin/inicio.php
src/mwap/modules/botica/reportes/man.php
```

Métodos principales:

```php
normalizar_filtros($datos)
get_reporte($filtros)
get_resumen_rapido()
```

Incluye información como:

- Total vendido.
- Ticket promedio.
- Número de ventas.
- Clientes.
- Productos más vendidos.
- Métodos de pago.
- Ventas por fecha.

El código busca una columna de fecha disponible en `pagos` entre:

```text
fecha_pago
fecha_registro
```

Si ninguna existe, utiliza `pedidos.fecha_pedido`.
