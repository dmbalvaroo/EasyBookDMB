<?php
include("conexionbd.php");  // Asegúrate de que este path sea correcto

if (!empty($_POST['tipo'])) {
    $tipo = $_POST['tipo'];
    $stmt = $conexion->prepare("SELECT id_servicio, nombre_servicio, descripcion, precio FROM Servicio WHERE tipo_servicio = ?");
    $stmt->bind_param("s", $tipo);
} else {
    $stmt = $conexion->prepare("SELECT id_servicio, nombre_servicio, descripcion, precio FROM Servicio");
}

$stmt->execute();
$result = $stmt->get_result();

$servicios = [];
while ($row = $result->fetch_assoc()) {
    $servicios[] = $row;
}

echo json_encode($servicios);

$stmt->close();
$conexion->close();
?>
