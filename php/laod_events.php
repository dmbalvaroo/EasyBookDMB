<?php
include("conexionbd.php");

$id_servicio = $_GET['id_servicio'];  // Obtener el id_servicio desde el parámetro URL

$stmt = $conexion->prepare("SELECT id_reserva AS id, fecha_hora AS start, ADDTIME(fecha_hora, '01:00:00') AS end, 'Reservado' AS title FROM Reserva WHERE id_servicio = ?");
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
