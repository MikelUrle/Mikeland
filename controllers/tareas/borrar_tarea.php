<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    include '../../db/conexion.php';

    $id_tarea = $conn->real_escape_string($input['id_tarea']);

    $sql = "UPDATE tareas SET isDeleted = 1 WHERE id_tarea = '$id_tarea'";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}