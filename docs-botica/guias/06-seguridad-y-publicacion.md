# 6. Seguridad y publicación

## Archivos privados

No deben publicarse con datos reales:

```text
src/app/cfg/db.php
src/app/cfg/install.php
src/app/cfg/sysmail.php
```

Aunque aparezcan en `.gitignore`, si Git ya los seguía anteriormente es necesario retirarlos del índice con `git rm --cached`.

## Datos prohibidos

- Contraseñas y tokens.
- Claves privadas.
- Datos reales de clientes.
- Exportaciones reales de la base de datos.
- Logs y copias de respaldo.
- Configuración local del servidor.

## Servidor

- Publicar únicamente `src/public_html`.
- Mantener `debug_mode = "NO"` en producción.
- Usar HTTPS.
- Usar un usuario MySQL dedicado.
- Restringir o retirar el instalador.
- Realizar copias de seguridad.

## GitHub

GitHub almacena el código fuente. No ejecuta PHP ni MySQL mediante GitHub Pages.

Un túnel rápido de Cloudflare sirve para demostraciones temporales, no como hosting permanente.
