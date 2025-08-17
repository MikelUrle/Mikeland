<?php
header('Content-Type: application/json');
include '../../db/conexion.php';

if (!isset($_POST['nombre'])) {
    echo json_encode(['success' => false, 'error' => 'Falta el nombre']);
    exit;
}

$nombre = $_POST['nombre'];

// Crear documento vacío con isDeleted = 0
$sql = "INSERT INTO documentacion (nombre, text, isDeleted) VALUES (?, '', 0)";
$stmt = $conn->prepare($sql);

if ($stmt && $stmt->bind_param("s", $nombre) && $stmt->execute()) {
    echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>
