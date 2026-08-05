# 6. CSS, JavaScript y recursos públicos

## Ubicación correcta

Los archivos que el navegador debe descargar pertenecen a:

```text
src/public_html/res/
```

Para Botica se utiliza:

```text
src/public_html/res/modules/botica/<modulo>/ui.css
src/public_html/res/modules/botica/<modulo>/ui.js
```

No coloques CSS ni JavaScript público dentro de `src/mwap/modules/botica`, porque esa carpeta es para PHP cargado por el servidor.

## Carga desde la interfaz PHP

Patrón utilizado por los módulos:

```php
$util = new mwmod_mw_html_manager_uipreparers_ui($this);
$util->preapare_ui();

$css = new mwmod_mw_html_manager_item_css(
    "botica_modulo_css",
    "/res/modules/botica/modulo/ui.css"
);

$js = new mwmod_mw_html_manager_item_jsexternal(
    "botica_modulo_js",
    "/res/modules/botica/modulo/ui.js"
);

$util->add_css_item($css);
$util->add_js_item($js);
```

Cada recurso necesita un identificador único para evitar cargas duplicadas.

## Clase JavaScript de Pedidos

La pantalla de Pedidos declara en PHP:

```php
$this->js_ui_class_name =
    "mw_modules_botica_pedidos_ui";
```

Y el JavaScript define exactamente:

```javascript
function mw_modules_botica_pedidos_ui(info) {
    // ...
}
```

Los nombres deben coincidir.

## Enviar datos de PHP a JavaScript

Pedidos utiliza:

```php
$this->ui_js_init_params->set_prop(
    "productos",
    $productosJs
);
```

Después inicializa la instancia JavaScript:

```php
$variableJs = $this->get_js_ui_man_name();

$codigoJs->add_cont(
    $variableJs . ".init(" .
    $this->ui_js_init_params->get_as_js_val() .
    ");\n"
);
```

Esto es preferible a construir manualmente grandes cadenas JSON sin escape.

## Almacenamiento local

Pedidos usa `localStorage` para conservar temporalmente el carrito y el formulario cuando el usuario recarga la página.

No debe utilizarse `localStorage` para guardar:

- Contraseñas.
- Tokens privados.
- Credenciales de la base de datos.
- Access Token de Mercado Pago.
- Información que deba considerarse confirmada en el servidor.

El servidor siempre vuelve a validar precio y stock antes de registrar el pedido.

## Reglas de organización del CSS

Orden recomendado dentro de cada `ui.css`:

```text
1. Variables o configuración del módulo
2. Contenedor principal
3. Encabezado
4. Formularios
5. Tablas o tarjetas
6. Botones y estados
7. Modales o tickets
8. Responsive
```

Evita añadir bloques llamados `V2`, `nuevo` o `arreglo final` al final del archivo. Integra la regla en la sección correspondiente para mantener el CSS legible.

## Diseño adaptable

Usa Flexbox o Grid para la estructura principal. Reserva `transform: translate(...)` para animaciones o ajustes pequeños, no para colocar toda la página, porque puede provocar diferencias entre la vista de VS Code, computadoras y celulares.

## Versionado de recursos

En la bienvenida se usa:

```html
/res/modules/demo/uiadmin/welcome.css?v=3
```

El parámetro `?v=3` ayuda a invalidar la caché. Cuando hagas un cambio que no aparezca en el navegador, puedes aumentar el número:

```text
?v=4
```

También puedes realizar una recarga forzada con `Ctrl + F5`.
