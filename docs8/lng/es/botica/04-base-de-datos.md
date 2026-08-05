# 4. Base de datos y flujo de información

> Esta referencia se construyó a partir de las consultas del código. No sustituye un archivo oficial de migraciones. Antes de recrear la base, compara los campos con tu base de datos real.

## Tablas utilizadas

```text
productos
pedidos
detalle_pedido
pagos
```

## Relaciones

```text
productos (1) ─────< detalle_pedido >───── (1) pedidos
                                                │
                                                │ 1
                                                │
                                                └─────< pagos
```

- Un pedido tiene uno o varios detalles.
- Cada detalle pertenece a un producto.
- Un pedido pendiente puede generar un pago.

## Campos de `productos` utilizados por el código

| Campo | Uso |
|---|---|
| `id` | Identificador interno |
| `codigo` | Código visible y único |
| `nombre` | Nombre del producto |
| `categoria` | Clasificación |
| `precio` | Precio unitario |
| `stock` | Cantidad disponible |
| `stock_minimo` | Umbral de alerta; valor alternativo 5 |
| `fecha_vencimiento` | Control de vencimiento |
| `estado` | `1` activo, `0` eliminado lógicamente |

## Campos de `pedidos` utilizados

| Campo | Uso |
|---|---|
| `id` | Identificador interno |
| `codigo` | Código generado `PED-00001` |
| `cliente_nombre` | Nombre del cliente |
| `cliente_documento` | Documento del cliente |
| `cliente_telefono` | Teléfono |
| `cliente_direccion` | Dirección |
| `observaciones` | Información adicional |
| `subtotal` | Total sin IGV |
| `igv` | 18 % calculado |
| `total` | Subtotal + IGV |
| `estado_pago` | `Pendiente` o `Pagado` |
| `estado_despacho` | Actualmente se inserta como `Pendiente` |
| `fecha_pedido` | Fecha utilizada por vistas y reportes |

### Observación importante

Aunque la interfaz ya no presenta un módulo de Despacho, el manager de Pedidos todavía inserta el campo:

```text
estado_despacho = Pendiente
```

No elimines esa columna de la base mientras el `INSERT` continúe utilizándola. Para retirarla correctamente habría que modificar primero el código y después la tabla.

## Campos de `detalle_pedido` utilizados

| Campo | Uso |
|---|---|
| `id` | Orden del detalle |
| `pedido_id` | Relación con el pedido |
| `producto_id` | Relación con el producto |
| `cantidad` | Unidades vendidas |
| `precio_unitario` | Precio guardado al vender |
| `subtotal` | Precio × cantidad |

Guardar `precio_unitario` en el detalle permite conservar el precio histórico incluso si luego cambia el precio del producto.

## Campos de `pagos` utilizados

| Campo | Uso |
|---|---|
| `id` | Identificador del pago |
| `pedido_id` | Relación con el pedido |
| `metodo_pago` | Efectivo, tarjeta, Mercado Pago u otro permitido |
| `monto_total` | Total del pedido |
| `monto_recibido` | Dinero entregado o aprobado |
| `vuelto` | Diferencia a devolver |
| `observacion` | Nota opcional |
| `fecha_pago` o `fecha_registro` | Fecha utilizada por reportes si existe |

## Transacción de Pedido

```text
BEGIN
  bloquear productos
  validar stock
  insertar pedido
  actualizar código
  insertar detalles
  descontar stock
COMMIT
```

Ante cualquier excepción:

```text
ROLLBACK
```

Esto evita pedidos incompletos o descuentos parciales de stock.

## Transacción de Cobranza

```text
BEGIN
  bloquear pedido
  verificar estado Pendiente
  insertar pago
  actualizar pedido a Pagado
  consultar detalle del ticket
COMMIT
```

## Consultas preparadas

Los managers utilizan `prepare()` y `bind_param()`. Esta práctica debe conservarse porque reduce el riesgo de inyección SQL.

No construyas consultas concatenando directamente valores recibidos de `$_POST` o `$_GET`.
