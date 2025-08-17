<?php
header('Content-Type: application/json');

include '../../db/conexion.php';

$sql = "SELECT id, nombre, text AS texto FROM documentacion WHERE isDeleted = 0";
$result = $conn->query($sql);

$docs = [];
while ($row = $result->fetch_assoc()) {
    $docs[] = $row;
}

echo json_encode($docs);
$conn->close();
?>