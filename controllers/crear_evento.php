<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    include '../db/conexion.php';

    $nombre = $conn->real_escape_string($input['nombre']);
    $fecha = $conn->real_escape_string($input['fecha']);
    $color = $conn->real_escape_string($input['color']);

    $sql = "INSERT INTO calendario (nombre, fecha, color) VALUES ('$nombre', '$fecha', '$color')";

    if ($conn->query($sql)) {
        echo json_encode(['status' => 'ok']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al insertar']);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}