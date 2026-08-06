# 7. Mantenimiento y pruebas

## Antes de modificar

1. Revisar `git status`.
2. Crear una rama o copia de respaldo.
3. Exportar la base de datos.
4. Cambiar un módulo a la vez.
5. Validar sintaxis.
6. Probar el flujo completo.

## PHP

```powershell
Get-ChildItem .\src\mwap\modules\pharmacy -Recurse -Filter *.php |
ForEach-Object { php -l $_.FullName }

php -l .\srcpp\init.php
```

## JavaScript

```powershell
Get-ChildItem .\src\public_htmles\modules\pharmacy -Recurse -Filter *.js |
ForEach-Object { node --check $_.FullName }
```

## Pruebas mínimas

- Registrar producto.
- Rechazar código duplicado.
- Aumentar y descontar stock.
- Crear pedido.
- Validar DNI, teléfono y cantidades.
- Registrar pago.
- Calcular vuelto.
- Imprimir ticket.
- Consultar reportes.
- Probar usuarios y permisos.
