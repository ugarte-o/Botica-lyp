# 2. Instalación local con WampServer

## Requisitos

- Windows.
- WampServer con Apache, PHP y MySQL/MariaDB.
- Extensión `mysqli` habilitada.
- Una base de datos llamada `botica` o la que se configure.
- El `DocumentRoot` apuntando a `src/public_html`.

## Ubicación del proyecto

Ejemplo:

```text
C:\wamp64\www\Proyecto\Botica
```

La carpeta pública no es la raíz completa del repositorio. Debe ser:

```text
C:\wamp64\www\Proyecto\Botica\src\public_html
```

## VirtualHost

Ejemplo de nombre:

```text
proyectodemo
```

Ejemplo conceptual de Apache:

```apache
<VirtualHost *:80>
    ServerName proyectodemo
    DocumentRoot "C:/ruta/Botica/src/public_html"

    <Directory "C:/ruta/Botica/src/public_html">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Después de crearlo:

1. Reinicia los servicios de WampServer.
2. Abre `http://proyectodemo/admin/`.
3. Comprueba que no aparezca un error de conexión.

## Configuración de base de datos

Archivo:

```text
src/app/cfg/db.php
```

Estructura:

```php
<?php
$data = array(
    "host" => "127.0.0.1",
    "db"   => "botica",
    "user" => "USUARIO_PRIVADO",
    "pass" => "CONTRASENA_PRIVADA",
    "port" => "3307"
);
```

La copia revisada usa el puerto `3307`. Si tu MySQL trabaja en `3306`, debes cambiar solamente el valor de `port`.

No publiques este archivo con credenciales reales.

## Comprobación rápida de conexión

Cuando la conexión funciona:

- `/admin/` muestra la pantalla de bienvenida.
- Inventario puede consultar `productos`.
- Pedidos puede listar productos activos con stock.
- Cobranza puede consultar pedidos pendientes.

Cuando falla, revisa:

1. Estado del servicio MySQL.
2. Puerto real.
3. Nombre de la base de datos.
4. Usuario y contraseña.
5. Privilegios del usuario sobre la base `botica`.
6. Extensión `mysqli` de PHP.

## Configuración de Mercado Pago

Archivo:

```text
src/app/cfg/mercadopago.php
```

Campos disponibles:

```php
$data = [
    "modo_prueba" => true,
    "access_token" => "",
    "webhook_secret" => "",
    "base_url" => "",
    "webhook_url" => ""
];
```

Para pruebas locales puede dejarse sin configurar. Para pagos reales necesitas:

- `access_token` de la cuenta vendedora.
- Una dirección pública HTTPS estable en `base_url`.
- Una URL de webhook válida o la ruta automática del proyecto.

Un enlace temporal de Cloudflare puede servir para demostraciones, pero cambia al reiniciar un túnel rápido y no es apropiado como dirección permanente de producción.

## Submódulos

El proyecto incluye partes de Meralda como submódulos Git. En una clonación completa se inicializan con:

```bash
git submodule update --init --recursive
```

Si recibes únicamente un ZIP que ya contiene todas las carpetas, el proyecto puede funcionar sin ejecutar ese comando. No obstante, no podrás actualizar fácilmente los submódulos desde Git.
