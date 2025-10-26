<?php
header('Content-Type: application/json');
include '../../db/conexion.php';

// Leemos el JSON enviado desde JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos
if (!$data || !isset($data['id_receta'])) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos o incompletos']);
    exit;
}

// Asignar variables
$id_receta    = intval($data['id_receta']);
$nombre       = $conn->real_escape_string($data['nombre'] ?? '');
$ingredientes = $conn->real_escape_string($data['ingredientes'] ?? '');
$preparacion  = $conn->real_escape_string($data['preparacion'] ?? '');
$id_categoria = intval($data['id_categoria'] ?? 4); // genérica por defecto

// Query de actualización
$sql = "
    UPDATE receta
    SET 
        nombre = '$nombre',
        ingredientes = '$ingredientes',
        preparacion = '$preparacion',
        id_categoria = $id_categoria
    WHERE id_receta = $id_receta
";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Receta actualizada correctamente']);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al actualizar: ' . $conn->error]);
}

$conn->close();
?>
