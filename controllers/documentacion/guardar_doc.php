<?php
header('Content-Type: application/json');

include '../../db/conexion.php';

if (!isset($_POST['id'], $_POST['texto'])) {
    echo json_encode(['success' => false, 'error' => 'Faltan datos']);
    exit;
}

$id = intval($_POST['id']);
$texto = $_POST['texto'];

$sql = "UPDATE documentacion SET text = ? WHERE id = ? AND isDeleted = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $texto, $id);

$success = $stmt->execute();

echo json_encode(['success' => $success]);

$stmt->close();
$conn->close();

?>