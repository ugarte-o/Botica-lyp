# 2. Instalación local

## Requisitos recomendados

- Apache 2.4 o Nginx.
- PHP 8.1 o superior.
- MySQL 8 o MariaDB compatible.
- Extensiones PHP necesarias por Meralda y la aplicación.
- Git.
- Un navegador moderno.

## Clonar

El repositorio actual no usa submódulos Git, por lo que se clona normalmente:

```powershell
git clone https://github.com/ugarte-o/Botica-lyp3.git
cd Botica-lyp3
```

## DocumentRoot

El servidor debe publicar únicamente:

```text
Botica-lyp3/src/public_html
```

No se debe publicar la raíz completa del repositorio.

## Base de datos

1. Crear una base de datos, por ejemplo `botica`.
2. Instalar primero las tablas base requeridas por Meralda.
3. Ejecutar `database/pharmacy_schema.sql`.
4. Crear un usuario de MySQL dedicado para la aplicación.

> El repositorio todavía debe indicar claramente de dónde obtener el esquema base de Meralda.

## Configuración privada

Crear localmente:

```text
src/app/cfg/db.php
src/app/cfg/install.php
src/app/cfg/sysmail.php
```

Estos archivos no deben subirse con contraseñas reales. Se recomienda copiar los archivos `.example.php` incluidos en el paquete de archivos recomendados.

## Acceso

Con un VirtualHost llamado `botica`, la ruta administrativa sería:

```text
http://botica/admin/
```

La configuración general actual utiliza Perú (`PE`), moneda soles (`PEN`) y modo debug desactivado.
