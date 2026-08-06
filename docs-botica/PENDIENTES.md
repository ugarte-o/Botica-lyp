# Pendientes del repositorio

Estado revisado el 5 de agosto de 2026.

## Prioridad alta

1. Retirar de Git los archivos privados que actualmente están publicados:
   - `src/app/cfg/db.php`
   - `src/app/cfg/install.php`
   - `src/app/cfg/sysmail.php`
2. Añadir archivos públicos de ejemplo:
   - `db.example.php`
   - `install.example.php`
   - `sysmail.example.php`
3. Explicar o incluir el esquema base de Meralda necesario antes de ejecutar `database/pharmacy_schema.sql`.
4. Cambiar las claves internas de instalación que ya aparecieron en el repositorio.
5. Corregir `.github/copilot-instructions.md`, porque todavía describe el repositorio como si usara submódulos y una carpeta `docs/` que no existen.

## Presentación

- Reemplazar el README principal incompleto.
- Agregar capturas de las pantallas principales.
- Añadir `SECURITY.md`, `CONTRIBUTING.md` y `NOTICE.md`.
- Añadir una versión o etiqueta, por ejemplo `v1.0.0`, cuando el flujo completo esté probado.
- Documentar limitaciones conocidas.

## Validación funcional

- Confirmar que un usuario administrador puede crear otros usuarios.
- Confirmar que el esquema SQL coincide con todas las consultas PHP.
- Confirmar que no existe código activo de Mercado Pago.
- Confirmar que el instalador no sea accesible públicamente.
- Probar instalación desde una computadora limpia siguiendo únicamente el README.
