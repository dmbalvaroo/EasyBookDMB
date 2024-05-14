<?php
// reservas.php

include('conexionbd.php');
include('reservaManager.php');

// Crear una instancia de ReservaManager con la conexión correcta
$reservaManager = new ReservaManager($conexion);

// Determinar la acción solicitada
$action = $_POST['action'] ?? '';
$response = [];

if ($action == 'crear') {
    $fecha_hora = $_POST['fecha_hora'] ?? '';
    $estado = $_POST['estado'] ?? 'pendiente';
    $id_usuario = $_POST['id_usuario'] ?? 0;
    $id_servicio = $_POST['id_servicio'] ?? 0;

    $response = $reservaManager->crearReserva($fecha_hora, $estado, $id_usuario, $id_servicio);
} elseif ($action == 'actualizar') {
    $id_reserva = $_POST['id_reserva'] ?? 0;
    $estado = $_POST['estado'] ?? '';

    $response = $reservaManager->actualizarEstadoReserva($id_reserva, $estado);
} elseif ($action == 'obtener') {
    $response = $reservaManager->obtenerReservas();
} else {
    $response = ['success' => false, 'message' => 'Accion no reconocida'];
}

// Responder con JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
