<?php
header('Content-Type: application/json');
include '../db/conexion.php';

$sql = "SELECT id, nombre FROM sub_categorias WHERE isDeleted = 0";
$result = $conn->query($sql);

$datos = [];

if ($result && $result->num_rows > 0) {
    while ($fila = $result->fetch_assoc()) {
        $datos[] = $fila;
    }
}

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . $conn->error]);
} else {
    echo json_encode($datos);
}

$conn->close();
?>