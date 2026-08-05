# 1. Arquitectura y arranque

## Separación entre framework y aplicación

El proyecto usa tres grupos principales de código:

1. **Framework Meralda:** clases base, autoload, sesiones, permisos, menús y utilidades.
2. **Aplicación principal `demo`:** define la pantalla administrativa, el menú y la página de bienvenida.
3. **Módulo `botica`:** contiene Pedidos, Cobranza, Inventario, Productos y Reportes.

## Cadena de arranque

Cuando se abre `/admin/`, el flujo principal es:

```text
src/public_html/admin/index.php
    ↓
src/public_html/admin/init.php
    ↓
src/app/init.php
    ↓
src/mwap/preinit.php
    ↓
Registro del autoload de demo, botica y tema default
    ↓
Creación de mw_app
    ↓
Conexión a la base de datos
    ↓
mwap_demo_uiadmin_main
    ↓
Pantalla solicitada mediante ?ui=
```

## Registro del autoload

En `src/app/init.php` se registran los prefijos del proyecto:

```php
$GLOBALS["__mw_autoload_manager"]
    ->create_and_add_sub_pref_man(
        "demo",
        dirname(dirname(__FILE__)) . "/mwap/modules/demo",
        "mwap"
    );

$GLOBALS["__mw_autoload_manager"]
    ->create_and_add_sub_pref_man(
        "botica",
        dirname(dirname(__FILE__)) . "/mwap/modules/botica",
        "mwap"
    );
```

Esto permite que Meralda encuentre una clase a partir de su nombre.

Ejemplo:

```text
Clase:   mwap_botica_pedidos_man
Archivo: src/mwap/modules/botica/pedidos/man.php
```

La clase principal de la instalación es:

```php
class mw_app extends mwap_demo_ap
{
}
```

Por esa razón, la aplicación usa `mwap_demo_ap` como base y desde allí crea la interfaz administrativa.

## Aplicación principal

`src/mwap/modules/demo/ap.php` crea el administrador:

```php
function create_submanager_uiadmin()
{
    return new mwap_demo_uiadmin_main($this);
}
```

`src/mwap/modules/demo/uiadmin/main.php` define:

- La ruta base `/admin/`.
- La pantalla inicial `welcome`.
- La comprobación de sesión.
- Las opciones del menú.
- La clase que se crea para cada opción.

La lista actual es:

```php
$this->su_cods_for_side =
    "obec,cobranza,inventario,agregarproducto,reportes,mwx,users,cfg";
```

## Resolución de una pantalla

Al abrir:

```text
/admin/?ui=inventario
```

Meralda busca en `mwap_demo_uiadmin_main` este método:

```php
function create_subinterface_inventario()
{
    return new mwap_botica_inventario_uiadmin(
        "inventario",
        $this
    );
}
```

La clase `mwap_botica_inventario_uiadmin` define como hijo predeterminado `inicio`. Después se crea:

```text
mwap_botica_inventario_uiadmin_inicio
```

ubicada en:

```text
src/mwap/modules/botica/inventario/uiadmin/inicio.php
```

## Convención entre clase y archivo

El autoload convierte los guiones bajos posteriores al prefijo en carpetas y archivos.

| Clase | Archivo esperado |
|---|---|
| `mwap_botica_pedidos_man` | `botica/pedidos/man.php` |
| `mwap_botica_pedidos_uiadmin` | `botica/pedidos/uiadmin.php` |
| `mwap_botica_pedidos_uiadmin_pedidos` | `botica/pedidos/uiadmin/pedidos.php` |
| `mwap_demo_uiadmin_welcome` | `demo/uiadmin/welcome.php` |

No cambies el nombre de una clase sin cambiar también su ruta y todas sus referencias.

## Responsabilidad de cada tipo de archivo

### `man.php`

Contiene lógica de negocio y acceso a la base de datos:

- Validaciones.
- Consultas preparadas.
- Transacciones.
- Cálculos.
- Inserciones y actualizaciones.

### `uiadmin.php`

Declara el módulo visible en el administrador:

- Título.
- Icono.
- Subinterfaz predeterminada.
- Permiso necesario.
- Integración con el menú.

### `uiadmin/inicio.php` o `uiadmin/pedidos.php`

Construye la pantalla:

- Lee `GET` y `POST`.
- Llama al manager.
- Prepara datos.
- Imprime el HTML.
- Carga CSS y JavaScript.

### `public_html/res/modules/botica/<modulo>/`

Contiene los archivos que recibe el navegador:

```text
ui.css
ui.js
```

## Permisos

Los módulos actuales implementan:

```php
function is_allowed()
{
    return $this->allow("admin");
}
```

Por tanto, las pantallas están destinadas a usuarios con permiso administrativo y requieren la sesión activada por la interfaz principal.
