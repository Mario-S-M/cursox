# Entorno Docker para Cursox

No se modificó ningún archivo del proyecto. Todo lo de aquí es infraestructura añadida.

## Levantar

    docker compose up -d

## URLs

| Servicio    | URL                          |
|-------------|------------------------------|
| Sitio       | http://localhost:8080/Cursox.html |
| phpMyAdmin  | http://localhost:8081 (entra solo, root sin contraseña) |
| MySQL (TCP) | localhost:3306, usuario `root`, sin contraseña, BD `cursox` |

## Por qué un contenedor de PHP y no PHP local

`conexion.php`, `conectar.php` y `procesar_reseñas.php` se conectan a `"localhost"`.
En mysqli ese host fuerza **socket Unix**, no TCP, así que un PHP del host nunca
alcanzaría al MySQL del contenedor. La solución, sin tocar el código: MySQL y PHP
comparten el volumen `cursox-mysql-socket` (montado en `/var/run/mysqld`) y el
contenedor PHP tiene `mysqli.default_socket` apuntando ahí.

## Datos

`initdb/01-schema.sql` crea las tablas `maestros` y `reseñas` (esquema inferido del código PHP).
`initdb/02-seed.sql` carga 9 maestros de ejemplo y 8 reseñas.
Sólo se ejecutan la primera vez, con el volumen de datos vacío.

Para recargar los datos desde cero:

    docker compose down -v && docker compose up -d

## Apagar

    docker compose down        # conserva los datos
    docker compose down -v     # borra también la base de datos
