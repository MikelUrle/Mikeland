<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    include '../db/conexion.php';

    $nombre = $conn->real_escape_string($input['nombreSubcategoria']);

    $sql = "INSERT INTO sub_categorias (nombre, isDeleted) VALUES ('$nombre',0)";

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
