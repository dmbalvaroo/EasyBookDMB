<?php
header('Content-Type: application/json');
include("conexionbd.php");

$id_servicio = isset($_GET['id_servicio']) ? $_GET['id_servicio'] : die(json_encode(['error' => 'ID del servicio no especificado']));

// Consulta para obtener los horarios reservados y disponibilidad
$query = "SELECT fecha_hora_inicio AS start, ADDTIME(fecha_hora_inicio, SEC_TO_TIME(duracion * 60)) AS end, 'Reservado' AS title 
          FROM Reserva
          WHERE id_servicio = ? AND estado = 'confirmada'";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_servicio);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);

$stmt->close();
$conexion->close();
?>
