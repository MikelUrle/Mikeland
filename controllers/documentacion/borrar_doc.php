<?php
header('Content-Type: application/json');
include '../../db/conexion.php';

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'error' => 'Falta el id']);
    exit;
}

$id = intval($_POST['id']);

$sql = "UPDATE documentacion SET isDeleted = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt && $stmt->bind_param("i", $id) && $stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$stmt->close();
$conn->close();
?>
