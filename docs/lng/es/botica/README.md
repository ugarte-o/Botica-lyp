# Documentación de Botica LyP sobre Meralda

> Documentación específica del proyecto **Botica LyP**, basada en el código incluido en `Botica(14).zip` y revisada el 3 de agosto de 2026.

## ¿Qué se documenta aquí?

Meralda es el framework PHP que proporciona el arranque, el autoload, las sesiones, los permisos, las interfaces administrativas, los menús y varias utilidades. Botica LyP es la aplicación construida sobre ese framework.

Esta sección explica cómo se conectan ambos y qué archivos se deben modificar para continuar desarrollando el sistema sin desordenar el proyecto.

## Orden recomendado de lectura

1. [Arquitectura y arranque](01-arquitectura-y-arranque.md)
2. [Instalación local con WampServer](02-instalacion-local.md)
3. [Módulos de Botica](03-modulos-de-botica.md)
4. [Base de datos y flujo de información](04-base-de-datos.md)
5. [Cómo crear un módulo nuevo](05-crear-un-modulo.md)
6. [CSS, JavaScript y recursos públicos](06-recursos-frontend.md)
7. [Seguridad y publicación](07-seguridad-y-publicacion.md)
8. [Mantenimiento y solución de problemas](08-mantenimiento.md)

## Mapa rápido del proyecto

```text
Botica/
├── docs/                         Documentación de Meralda y de Botica
├── src/
│   ├── app/                      Configuración de esta instalación
│   │   ├── init.php              Registra los módulos y crea mw_app
│   │   └── cfg/                  Base de datos, correo y Mercado Pago
│   ├── mwap/                     PHP del framework y de los módulos
│   │   └── modules/
│   │       ├── mw/               Núcleo funcional de Meralda
│   │       ├── demo/             Aplicación principal y menú actual
│   │       ├── botica/           Lógica PHP propia de Botica
│   │       └── themes/           Tema visual del administrador
│   └── public_html/              Raíz pública del servidor web
│       ├── admin/                Entrada del administrador
│       ├── service/              Servicios o endpoints públicos
│       └── res/                  CSS, JavaScript, iconos y librerías
└── README.md
```

## Archivos que normalmente se modifican

Para desarrollar Botica, trabaja principalmente en:

```text
src/mwap/modules/botica/
src/mwap/modules/demo/uiadmin/main.php
src/mwap/modules/demo/uiadmin/welcome.php
src/public_html/res/modules/botica/
src/public_html/res/modules/demo/uiadmin/welcome.css
src/app/cfg/
```

Evita modificar directamente el núcleo del framework:

```text
src/mwap/modules/mw/
src/mwap/modulesext/
src/public_html/res/meralda/
src/public_html/res/thirdparty/
```

## Direcciones actuales

| Pantalla | Dirección |
|---|---|
| Inicio | `/admin/` |
| Pedidos | `/admin/?ui=obec` |
| Cobranza | `/admin/?ui=cobranza` |
| Inventario | `/admin/?ui=inventario` |
| Agregar producto | `/admin/?ui=agregarproducto` |
| Reportes | `/admin/?ui=reportes` |

`obec` es el código histórico de la ruta de Pedidos. El título mostrado al usuario sigue siendo **Pedidos**.

## Regla principal

La lógica y las consultas pertenecen a los archivos `man.php`. La interfaz PHP pertenece a `uiadmin.php` y a `uiadmin/*.php`. El diseño y la interacción del navegador pertenecen a `public_html/res/modules/botica/<modulo>/`.
