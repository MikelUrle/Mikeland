<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "db_mikeland";

// Crear conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    // echo "Conexión exitosa";
}
?>