<?php
include 'conexionbd.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos.
include 'Servicio.php';

$db = $conexion; // Asumiendo que $conexion es tu objeto de conexión mysqli.
$servicio = new Servicio($db);

$tipo_servicio = 'tipo1'; // Aquí podrías ajustar según el tipo que quieras mostrar o usar una variable de solicitud, e.g., $_GET['tipo']
$servicios = $servicio->getServicesByType($tipo_servicio);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Servicios Disponibles</title>
</head>
<body>
    <h1>Servicios de Tipo: <?php echo htmlspecialchars($tipo_servicio); ?></h1>
    <?php foreach ($servicios as $servicio): ?>
        <div>
            <h2><?php echo htmlspecialchars($servicio['nombre_servicio']); ?></h2>
            <p><?php echo htmlspecialchars($servicio['descripcion']); ?></p>
            <p>Precio: <?php echo htmlspecialchars($servicio['precio']); ?>€</p>
            <p>Duración: <?php echo htmlspecialchars($servicio['duracion']); ?> minutos</p>
        </div>
    <?php endforeach; ?>
</body>
</html>
