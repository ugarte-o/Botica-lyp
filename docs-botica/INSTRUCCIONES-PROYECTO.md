# Instrucciones para modificar Botica LyP

- Mantener la aplicación principal basada en `mwap_pharmacy_ap`.
- Mantener la lógica propia dentro de `src/mwap/modules/pharmacy/`.
- Mantener CSS y JavaScript propios en `src/public_html/res/modules/pharmacy/`.
- No volver a depender del módulo de aplicación `demo`.
- No eliminar Pedidos, Cobranza, Inventario, Productos ni Reportes sin autorización.
- Mercado Pago no forma parte de la versión actual.
- No modificar el núcleo de Meralda salvo que sea estrictamente necesario.
- Obtener los managers mediante `mainMan`.
- Usar consultas preparadas y transacciones para cambios de stock, pedidos y pagos.
- Mantener `debug_mode = "NO"` en versiones públicas.
- No publicar credenciales ni datos reales.
- Validar PHP y JavaScript antes de confirmar cambios.
- Revisar `git diff` antes de ejecutar `git commit`.
