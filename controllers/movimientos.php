<?php
header('Content-Type: application/json');
include '../db/conexion.php';

$sql = "SELECT 
    movimientos.*, 
    sub_categorias.nombre AS nombre_sub_categoria
FROM 
    movimientos
INNER JOIN 
    sub_categorias ON movimientos.sub_categoria = sub_categorias.id
WHERE 
    movimientos.isDeleted = 0
ORDER BY fecha DESC";
    
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