# 5. Recursos frontend

Los recursos propios se encuentran en:

```text
src/public_html/res/modules/pharmacy/
├── uiadmin/
├── orders/
├── payments/
├── inventory/
├── products/
└── reports/
```

## PHP

Prepara datos, valida permisos, ejecuta lógica mediante managers y genera el contenido inicial.

## JavaScript

Gestiona interacciones como carrito, filtros, formularios, ticket, impresión, tablas y gráficos. Las validaciones decisivas también deben repetirse en PHP.

## CSS

Cada módulo tiene estilos propios para evitar interferencias entre pantallas.

Después de modificar CSS o JavaScript, recarga con:

```text
Ctrl + F5
```

No se deben guardar contraseñas, tokens ni claves privadas en archivos públicos, HTML, JavaScript o `localStorage`.
