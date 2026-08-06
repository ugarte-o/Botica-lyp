# 3. Módulos de Botica

## Pedidos (`orders`)

Responsabilidades principales:

- Listar productos disponibles.
- Gestionar el carrito.
- Validar datos del cliente.
- Verificar stock.
- Registrar pedido y detalle.
- Descontar existencias.
- Calcular subtotal, IGV y total.

## Cobranza (`payments`)

- Listar pedidos pendientes.
- Registrar el método de pago.
- Validar el monto recibido.
- Calcular vuelto.
- Cambiar el pedido a `Pagado`.
- Preparar e imprimir el ticket.

Métodos previstos:

```text
Efectivo, Yape, Plin, Tarjeta, Transferencia
```

## Inventario (`inventory`)

Muestra código, nombre, categoría, precio, stock, stock mínimo, fecha de vencimiento y estado. Incluye alertas visuales para poco stock y productos próximos a vencer.

## Productos (`products` / `addproduct`)

- Registrar productos.
- Evitar códigos duplicados.
- Aumentar stock.
- Validar precio, cantidad y vencimiento.
- Eliminar de forma lógica mediante el campo `estado`.

## Reportes (`reports`)

Permite consultar ventas por fechas, método de pago, pedido, cliente o documento. Presenta resúmenes, tendencias y productos vendidos.

## Inicio

La portada administrativa se encuentra en:

```text
src/mwap/modules/pharmacy/uiadmin/welcome.php
src/public_html/res/modules/pharmacy/uiadmin/welcome.css
```
