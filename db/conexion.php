<?php
$host = "127.0.0.1";
$usuario = "root";
$contrasena = "XxU3eOxX12?";
$base_de_datos = "db_mikeland";

$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>