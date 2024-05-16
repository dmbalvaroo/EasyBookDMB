<?php
header('Content-Type: application/json');

require '../conexionbd.php';

$data = json_decode(file_get_contents('php://input'), true);

$fecha_hora = $data['start'];
$id_usuario = 1; // Puedes obtener este valor dinámicamente según el usuario logueado
$id_servicio = $data['id_servicio'];
$estado = 'confirmada';

// Verificar si la hora de la reserva está dentro del horario del servicio
$sql = "SELECT horario_inicio, horario_fin FROM Servicio WHERE id_servicio = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_servicio);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
$stmt->close();

$hora_inicio = date('H:i:s', strtotime($fecha_hora));
if ($hora_inicio < $service['horario_inicio'] || $hora_inicio > $service['horario_fin']) {
    echo json_encode(['error' => 'La hora de la reserva está fuera del horario permitido para el servicio.']);
    exit;
}

$sql = "INSERT INTO Reserva (fecha_hora, estado, id_usuario, id_servicio) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $fecha_hora, $estado, $id_usuario, $id_servicio);

$response = array();
if ($stmt->execute()) {
    $response['id'] = $stmt->insert_id;
} else {
    $response['error'] = $stmt->error;
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
