# 5. Cómo crear un módulo nuevo

Este ejemplo crea un módulo llamado `proveedores` con una pantalla `inicio`.

## 1. Crear las carpetas PHP

```text
src/mwap/modules/botica/proveedores/
├── man.php
├── uiadmin.php
└── uiadmin/
    └── inicio.php
```

## 2. Crear el manager

Archivo:

```text
src/mwap/modules/botica/proveedores/man.php
```

```php
<?php

class mwap_botica_proveedores_man
    extends mwmod_mw_manager_baseman
{
    function __construct($mainAP)
    {
        $this->init("proveedores", $mainAP);
    }

    function get_db_link()
    {
        $conexion = $this->mainap->get_db_link();

        if (!$conexion) {
            throw new Exception(
                "No se pudo conectar a la base de datos."
            );
        }

        return $conexion;
    }

    function listar()
    {
        $conexion = $this->get_db_link();
        $resultado = $conexion->query("SELECT id, nombre FROM proveedores");

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
```

Para consultas con datos externos, utiliza `prepare()` y `bind_param()`.

## 3. Crear la interfaz principal del módulo

Archivo:

```text
src/mwap/modules/botica/proveedores/uiadmin.php
```

```php
<?php

class mwap_botica_proveedores_uiadmin
    extends mwmod_mw_ui_base_basesubuia
{
    function __construct($cod, $parent)
    {
        $this->init_as_main_or_sub($cod, $parent);
        $this->set_lngmsgsmancod("demo");
        $this->set_def_title("Proveedores");

        $this->sucods = "inicio";
        $this->subinterface_def_code = "inicio";
        $this->mnuIconClass = "fas fa-truck mnuicon";
    }

    function allowcreatesubinterfacechildbycode()
    {
        return true;
    }

    function _do_create_subinterface_child_inicio($cod)
    {
        return new mwap_botica_proveedores_uiadmin_inicio(
            $cod,
            $this
        );
    }

    function do_exec_no_sub_interface()
    {
    }

    function is_allowed()
    {
        return $this->allow("admin");
    }
}
```

## 4. Crear la pantalla hija

Archivo:

```text
src/mwap/modules/botica/proveedores/uiadmin/inicio.php
```

```php
<?php

class mwap_botica_proveedores_uiadmin_inicio
    extends mwmod_mw_ui_base_basesubui
{
    function __construct($cod, $parent)
    {
        $this->init_as_main_or_sub($cod, $parent);
        $this->set_lngmsgsmancod("demo");
        $this->set_def_title("Proveedores");

        $this->js_ui_class_name =
            "mw_modules_botica_proveedores_ui";
    }

    function do_exec_no_sub_interface()
    {
        $util =
            new mwmod_mw_html_manager_uipreparers_ui($this);

        $util->preapare_ui();

        $util->add_css_item(
            new mwmod_mw_html_manager_item_css(
                "botica_proveedores_css",
                "/res/modules/botica/proveedores/ui.css"
            )
        );

        $util->add_js_item(
            new mwmod_mw_html_manager_item_jsexternal(
                "botica_proveedores_js",
                "/res/modules/botica/proveedores/ui.js"
            )
        );

        $util->add_js_item(
            $this->create_js_man_ui_header_declaration_item()
        );
    }

    function do_exec_page_in()
    {
        $man = new mwap_botica_proveedores_man(
            $this->mainap
        );

        $proveedores = $man->listar();

        echo '<div class="proveedores-page">';
        echo '<h1>Proveedores</h1>';

        foreach ($proveedores as $proveedor) {
            echo '<p>' . htmlspecialchars(
                (string) $proveedor["nombre"],
                ENT_QUOTES,
                "UTF-8"
            ) . '</p>';
        }

        echo '</div>';
    }

    function is_allowed()
    {
        return $this->allow("admin");
    }
}
```

## 5. Crear CSS y JavaScript

```text
src/public_html/res/modules/botica/proveedores/ui.css
src/public_html/res/modules/botica/proveedores/ui.js
```

JavaScript mínimo:

```javascript
function mw_modules_botica_proveedores_ui(info) {
    this.info = new mw_obj();
    this.info.set_params(info);

    this.init = function (params) {
        this.params = new mw_obj();
        this.params.set_params(params || {});
    };
}
```

## 6. Registrar la ruta en el administrador

Edita:

```text
src/mwap/modules/demo/uiadmin/main.php
```

Agrega el código al menú:

```php
$this->su_cods_for_side =
    "obec,cobranza,inventario,agregarproducto,proveedores,reportes,mwx,users,cfg";
```

Y agrega el creador:

```php
function create_subinterface_proveedores()
{
    return new mwap_botica_proveedores_uiadmin(
        "proveedores",
        $this
    );
}
```

La ruta será:

```text
/admin/?ui=proveedores
```

## 7. Lista de comprobación

- La clase coincide con la ruta del archivo.
- El código de `?ui=` coincide con `create_subinterface_<codigo>()`.
- Los recursos están dentro de `public_html`.
- El manager no imprime HTML.
- La interfaz no contiene consultas SQL directas cuando pueden ir en el manager.
- Los valores impresos se escapan con `htmlspecialchars()`.
- La pantalla implementa `is_allowed()`.
