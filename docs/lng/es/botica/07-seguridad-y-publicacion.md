# 7. Seguridad y publicación

## Archivos privados

No compartas públicamente el contenido real de:

```text
src/app/cfg/db.php
src/app/cfg/mercadopago.php
src/app/cfg/sysmail.php
```

Pueden contener:

- Usuario y contraseña de MySQL.
- Access Token de Mercado Pago.
- Secreto del webhook.
- Credenciales de correo.

## Raíz pública correcta

En hosting, el `DocumentRoot` debe apuntar a:

```text
src/public_html
```

No debe apuntar a la carpeta completa `Botica`, porque expondría `src/app`, `docs` y archivos de configuración.

## Permisos

Las interfaces de Botica requieren:

```php
$this->allow("admin")
```

No elimines la comprobación de sesión ni conviertas las páginas administrativas en endpoints públicos.

## Entrada del usuario

Reglas obligatorias:

- Validar todos los datos en PHP, aunque JavaScript ya los valide.
- Convertir identificadores a enteros.
- Verificar montos y cantidades.
- Usar consultas preparadas.
- Escapar texto al imprimir HTML.
- No confiar en precios enviados por el navegador.

Pedidos cumple la regla importante de volver a consultar el precio y el stock desde la base de datos.

## Transacciones y concurrencia

Mantén:

```sql
FOR UPDATE
```

y las transacciones en Pedidos y Cobranza. Evitan que dos operaciones simultáneas vendan el mismo stock o cobren dos veces el mismo pedido.

## Mercado Pago

Para producción:

1. Usa HTTPS.
2. Configura un dominio estable.
3. Cambia `modo_prueba` según corresponda.
4. Protege el Access Token.
5. Configura y valida el secreto del webhook.
6. No marques un pedido como pagado únicamente porque el navegador volvió a una URL de éxito; consulta y valida el pago con Mercado Pago.

El código actual verifica el estado del pago mediante la API antes de registrarlo.

## Copia para hosting

Puedes excluir del paquete de producción:

```text
.git/
.github/
docs/
example/
```

Pero conserva `docs/` en tu proyecto de desarrollo, porque contiene la documentación del framework y de Botica.

No elimines submódulos funcionales como:

```text
src/mwap/modules/mw/
src/mwap/modulesext/
src/public_html/res/meralda/
src/public_html/res/thirdparty/
src/mwap/modules/themes/default/
src/public_html/res/themes/default/
```

## Túneles temporales

Los túneles rápidos de Cloudflare son útiles para pruebas, pero:

- La dirección puede cambiar al reiniciarlos.
- No tienen garantía de disponibilidad.
- No sustituyen un dominio y un túnel nombrado para producción.
- Al publicar el administrador, debes proteger las credenciales de acceso.
