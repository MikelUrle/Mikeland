<?php
header('Content-Type: application/json');

include '../db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
        exit;
    }

    $id = $conn->real_escape_string($_GET['id']);

    // Marcamos como borrado
    $sql = "UPDATE movimientos SET isDeleted = 1 WHERE id = '$id'";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Error al actualizar']);
    }

    $conn->close();

} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
