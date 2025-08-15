<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../../db/conexion.php';

    if (!isset($_POST['nombreCategoria']) || empty(trim($_POST['nombreCategoria']))) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Nombre de categoría requerido']);
        exit;
    }

    $nombre = $conn->real_escape_string($_POST['nombreCategoria']);

    $sql = "INSERT INTO categorias_tarea (nombre) VALUES ('$nombre')";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Error al insertar']);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
