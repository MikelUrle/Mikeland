<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Falta id de tarea']);
        exit;
    }

    $id = (int)$_GET['id'];

    include '../../db/conexion.php';

    // Obtenemos el estado actual de la tarea
    $sqlSelect = "SELECT estado FROM tareas WHERE id_tarea = $id AND isDeleted = 0";
    $result = $conn->query($sqlSelect);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nuevoEstado = $row['estado'] == 1 ? 0 : 1;

        // Actualizamos el estado
        $sqlUpdate = "UPDATE tareas SET estado = $nuevoEstado WHERE id_tarea = $id";
        if ($conn->query($sqlUpdate)) {
            echo json_encode(['success' => true, 'nuevoEstado' => $nuevoEstado]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo actualizar la tarea']);
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Tarea no encontrada']);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}

?>