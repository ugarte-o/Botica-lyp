# 1. Arquitectura y arranque

## Estructura principal

```text
src/
├── app/                              Configuración de la aplicación
├── mwap/                             Núcleo de Meralda y módulos PHP
│   └── modules/pharmacy/             Lógica propia de Botica
└── public_html/                      Única carpeta pública del servidor
    └── res/modules/pharmacy/         CSS y JavaScript propios
```

## Cadena de inicio

El acceso administrativo entra por:

```text
src/public_html/admin/index.php
```

El arranque termina cargando `src/app/init.php`. Ese archivo registra el prefijo `pharmacy` y declara:

```php
class mw_app extends mwap_pharmacy_ap
{
}
```

Por eso la aplicación activa es Botica y no el antiguo proyecto de demostración.

## Aplicación principal

`src/mwap/modules/pharmacy/ap.php` conecta:

- `mwap_pharmacy_uiadmin_main`: interfaz administrativa principal.
- `mwap_pharmacy_mainman`: administrador central de la lógica de negocio.

Los managers se obtienen de forma diferida mediante `mainMan`:

```text
mainMan->orders
mainMan->payments
mainMan->inventory
mainMan->products
mainMan->reports
```

## Menú

`src/mwap/modules/pharmacy/uiadmin.php` registra:

```text
orders,payments,inventory,addproduct,reports
```

Todas las pantallas propias requieren el permiso `admin`.
