# 4. Base de datos

Las tablas propias se crean con:

```text
database/pharmacy_schema.sql
```

Este archivo debe ejecutarse después de instalar las tablas base de Meralda.

## Tablas propias

```text
productos
pedidos
detalle_pedido
pagos
```

## Relaciones

```text
productos 1 ── N detalle_pedido N ── 1 pedidos 1 ── 1 pagos
```

## Flujo del pedido

```text
validar cliente y carrito
bloquear productos
verificar productos activos y stock
insertar pedido
generar código PED-xxxxx
insertar detalle
descontar stock
confirmar transacción
```

## Flujo de cobranza

```text
bloquear pedido
comprobar estado Pendiente
validar monto
insertar pago
actualizar pedido a Pagado
obtener datos del ticket
confirmar transacción
```

Las consultas deben usar sentencias preparadas. No se deben concatenar directamente valores de `$_POST` o `$_GET`.
