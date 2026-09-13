<?php
$servidor   = "localhost";
$usuario    = "root";
$password   = "";
$base_datos = "cursox";
$conexionServidor = new mysqli($servidor, $usuario, $password, $base_datos);
if ($conexionServidor->connect_error) {
    die("Error al conectar con MySQL: " . $conexionServidor->connect_error);
}
$conexionServidor->set_charset("utf8mb4");
?>