<?php
header('Content-Type: application/json');
include '../../db/conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';

// Leer JSON
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['id_receta']) || !isset($data['email_destino'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

$id = intval($data['id_receta']);
$emailDestino = $data['email_destino'];

// Obtener receta
$sql = "SELECT nombre, ingredientes, preparacion FROM receta WHERE id_receta = $id AND isDeleted = 0";
$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'Receta no encontrada']);
    exit;
}

$receta = $result->fetch_assoc();

$mail = new PHPMailer(true);

try {
    // Configuración SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'UrlezagaMikel@gmail.com'; // tu Gmail
    $mail->Password   = 'keig qlvd ahde jkwk';    // contraseña de aplicación de Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('UrlezagaMikel@gmail.com', 'Recetario Mikel');
    $mail->addAddress($emailDestino);

    $mail->isHTML(true);
    $mail->Subject = "Receta: " . $receta['nombre'];
    $mail->Body    = "
        <h2>{$receta['nombre']}</h2>
        <p><strong>Ingredientes:</strong></p>
        <p>{$receta['ingredientes']}</p>
        <p><strong>Preparación:</strong></p>
        <p>{$receta['preparacion']}</p>
        <p>Enviado desde el recetario de Mikel 🍳</p>
    ";

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => "No se pudo enviar el correo: {$mail->ErrorInfo}"]);
}

$conn->close();
?>
