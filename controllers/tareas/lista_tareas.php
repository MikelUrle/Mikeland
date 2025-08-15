<?php
header('Content-Type: application/json');
include '../../db/conexion.php';

$sql = "SELECT t.id_tarea, t.texto, t.id_categoria, t.estado, t.isDeleted, c.nombre AS nombre_categoria
        FROM tareas t
        INNER JOIN categorias_tarea c ON t.id_categoria = c.id_categoria
        WHERE t.isDeleted = 0
        ORDER BY c.nombre, t.id_tarea DESC";

$result = $conn->query($sql);
$tareas = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tareas[] = $row;
    }
}

echo json_encode($tareas);
$conn->close();

?>