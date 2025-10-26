<?php
header('Content-Type: application/json');
include '../../db/conexion.php';

// Leemos el JSON enviado desde JS
$data = json_decode(file_get_contents('php://input'), true);

$nombre = $conn->real_escape_string($data['nombre'] ?? 'Nueva receta');
$ingredientes = $conn->real_escape_string($data['ingredientes'] ?? '');
$preparacion = $conn->real_escape_string($data['preparacion'] ?? '');
$id_categoria = intval($data['id_categoria'] ?? 4); // 4 = genérica

$sql = "INSERT INTO receta (nombre, ingredientes, preparacion, id_categoria, isDeleted)
        VALUES ('$nombre', '$ingredientes', '$preparacion', $id_categoria, 0)";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        'success' => true,
        'id_receta' => $conn->insert_id,
        'message' => 'Receta creada correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Error al crear receta: ' . $conn->error
    ]);
}

$conn->close();
?>
