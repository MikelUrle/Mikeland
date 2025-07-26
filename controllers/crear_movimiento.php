<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    include '../db/conexion.php';

    $fecha = $conn->real_escape_string($input['fecha']);
    $categoria = $conn->real_escape_string($input['categoria']);
    $concepto = $conn->real_escape_string($input['concepto']);
    $sub_categoria = $conn->real_escape_string($input['sub_categoria']);
    $cantidad = $conn->real_escape_string($input['cantidad']);

    $sql = "INSERT INTO movimientos (fecha, categoria, concepto, cantidad, sub_categoria) VALUES ('$fecha', '$categoria', '$concepto', '$cantidad', '$sub_categoria')";

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
