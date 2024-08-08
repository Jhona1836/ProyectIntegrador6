<?php
$conexion = new mysqli("localhost", "root", "", "pixelcraft", 3306);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
$conexion->set_charset("utf8");
?>