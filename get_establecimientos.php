<?php
require_once("php/conexionbd.php");

if (isset($_GET['id_servicio'])) {
    $id_servicio = intval($_GET['id_servicio']);
    $establecimientos = "";

    $consulta = $conexion->prepare("SELECT e.id_establecimiento AS id, e.nombre FROM Establecimiento e JOIN ServicioEstablecimiento se ON e.id_establecimiento = se.id_establecimiento WHERE se.id_servicio = ?");
    $consulta->bind_param("i", $id_servicio);
    $consulta->execute();
    $resultado = $consulta->get_result();
    
    while ($fila = $resultado->fetch_assoc()) {
        $establecimientos .= "<option value='{$fila['id']}'>{$fila['nombre']}</option>";
    }
    
    echo json_encode(['establecimientos' => $establecimientos]);
}
?>
