<?php
session_start(); // Iniciar sesión al comienzo del script

include("php/conexionbd.php"); // Asegúrate de que este path sea correcto para tu archivo de conexión a la base de datos.

// Comprobar si el usuario ha iniciado sesión y si el ID del usuario está disponible en la sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<p>Acceso denegado: No se ha iniciado sesión.</p>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$query = "SELECT Reserva.id_reserva, Reserva.fecha_hora, Reserva.estado, 
                 Servicio.nombre_servicio, Servicio.descripcion, Servicio.precio
          FROM Reserva
          JOIN Servicio ON Reserva.id_servicio = Servicio.id_servicio
          WHERE Reserva.id_usuario = ?";

$stmt = $conexion->prepare($query);
if (!$stmt) {
    echo "<p>Error al preparar la consulta: " . $conexion->error . "</p>";
    exit;
}

$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

// Comienzo del HTML
echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas del Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Reservas del Usuario</h2>
<table>
    <tr>
        <th>ID Reserva</th>
        <th>Fecha y Hora</th>
        <th>Estado</th>
        <th>Servicio</th>
        <th>Descripción</th>
        <th>Precio</th>
    </tr>';

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id_reserva']}</td>
            <td>{$row['fecha_hora']}</td>
            <td>{$row['estado']}</td>
            <td>{$row['nombre_servicio']}</td>
            <td>{$row['descripcion']}</td>
            <td>{$row['precio']} €</td>
          </tr>";
}

echo '</table>
<a class="nav-link" href="index.php">Volver a Inicio</a>

</body>
</html>';

$stmt->close();
$conexion->close();
?>
