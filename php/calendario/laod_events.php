<?php
header('Content-Type: application/json');

require 'conexionbd.php';

$sql = "SELECT R.id_reserva AS id, S.nombre_servicio AS title, R.fecha_hora AS start, DATE_ADD(R.fecha_hora, INTERVAL S.duracion MINUTE) AS end, 0 AS allDay
        FROM Reserva R
        JOIN Servicio S ON R.id_servicio = S.id_servicio
        WHERE R.estado = 'confirmada'";
$result = $conn->query($sql);

$events = array();

while($row = $result->fetch_assoc()) {
    $events[] = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start'],
        'end' => $row['end'],
        'allDay' => $row['allDay'] == 1 ? true : false
    );
}

echo json_encode($events);

$conn->close();
?>
