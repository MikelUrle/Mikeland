<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    include '../../db/conexion.php';

    $texto = $conn->real_escape_string($input['texto']);
    $id_categoria = $conn->real_escape_string($input['id_categoria']);

    $sql = "INSERT INTO tareas (texto, id_categoria, estado, isDeleted) VALUES ('$texto', '$id_categoria', 0, 0)";

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
