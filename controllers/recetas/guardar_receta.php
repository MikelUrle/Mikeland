<?php
header('Content-Type: application/json');
include '../../db/conexion.php';

// Acepta datos tipo FormData (no JSON)
$id_receta    = intval($_POST['id_receta'] ?? 0);
$nombre       = $conn->real_escape_string($_POST['nombre'] ?? '');
$ingredientes = $conn->real_escape_string($_POST['ingredientes'] ?? '');
$preparacion  = $conn->real_escape_string($_POST['preparacion'] ?? '');
$id_categoria = intval($_POST['id_categoria'] ?? 4);

// Ruta donde guardar las imágenes
$uploadDir = __DIR__ . '/../../imagenes/';
$fotoNombre = null;

// 📸 Si se envía una nueva imagen
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['foto']['tmp_name'];
    $originalName = basename($_FILES['foto']['name']);

    // Generar un nombre único
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $fotoNombre = uniqid('receta_') . '.' . strtolower($ext);

    $destino = $uploadDir . $fotoNombre;

    if (!move_uploaded_file($tmpName, $destino)) {
        echo json_encode(['success' => false, 'error' => 'No se pudo guardar la imagen']);
        exit;
    }

    // Actualizar la columna foto con el nuevo nombre
    $sql = "UPDATE receta 
            SET nombre='$nombre', ingredientes='$ingredientes', preparacion='$preparacion',
                id_categoria=$id_categoria, foto='$fotoNombre'
            WHERE id_receta=$id_receta";
} else {
    // Si no hay nueva foto, solo actualiza los demás campos
    $sql = "UPDATE receta 
            SET nombre='$nombre', ingredientes='$ingredientes', preparacion='$preparacion',
                id_categoria=$id_categoria
            WHERE id_receta=$id_receta";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'foto' => $fotoNombre]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
