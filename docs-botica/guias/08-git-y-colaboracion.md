# 8. Git y colaboración

## Flujo normal

```powershell
git pull
git status
git add .
git commit -m "Describe el cambio realizado"
git push
```

Ejecuta estos comandos únicamente dentro de la carpeta del repositorio.

## Antes de confirmar

```powershell
git status
git diff
git diff --cached
```

Verifica especialmente que no se incluyan archivos privados de `src/app/cfg/`.

## Ramas

Para cambios importantes:

```powershell
git switch -c nombre-del-cambio
```

Después del trabajo:

```powershell
git add .
git commit -m "Descripción"
git push -u origin nombre-del-cambio
```

En GitHub se puede crear un Pull Request antes de unir el cambio a `main`.

## Relación con Meralda

Botica utiliza el código de Meralda como framework base, pero la aplicación propia se encuentra en el módulo `pharmacy`. No se debe presentar el núcleo de Meralda como código creado desde cero para Botica.
