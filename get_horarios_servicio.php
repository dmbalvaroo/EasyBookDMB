<?php
require_once("php/conexionbd.php");

if (isset($_GET['id_servicio'])) {
    $id_servicio = intval($_GET['id_servicio']);
    $consulta = $conexion->prepare("SELECT horario_inicio, horario_fin, dias_operativos FROM Servicio WHERE id_servicio = ?");
    $consulta->bind_param("i", $id_servicio);
    $consulta->execute();
    $resultado = $consulta->get_result();
    $horarios = $resultado->fetch_assoc();

    echo json_encode([
        'horario_inicio' => $horarios['horario_inicio'],
        'horario_fin' => $horarios['horario_fin'],
        'dias_operativos' => $horarios['dias_operativos']
    ]);
}
?>
