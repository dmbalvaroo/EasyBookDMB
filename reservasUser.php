<?php
session_start(); // Iniciar sesión al comienzo del script

include("php/conexionbd.php"); // Asegúrate de que este path sea correcto para tu archivo de conexión a la base de datos.

// Comprobar si el usuario ha iniciado sesión y si el ID del usuario está disponible en la sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<p>Acceso denegado: No se ha iniciado sesión.</p>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Procesar la cancelación de la reserva
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancelar_reserva'])) {
    $id_reserva = $_POST['id_reserva'];
    $stmt_cancel = $conexion->prepare("UPDATE Reserva SET estado='cancelada' WHERE id_reserva=?");
    $stmt_cancel->bind_param("i", $id_reserva);
    $stmt_cancel->execute();
    $stmt_cancel->close();
    echo "<p>Reserva cancelada con éxito.</p>";
}

$query = "SELECT Reserva.id_reserva, Reserva.fecha_hora, Reserva.estado, 
                 Servicio.nombre_servicio, Servicio.descripcion, Servicio.precio
          FROM Reserva
          JOIN Servicio ON Reserva.id_servicio = Servicio.id_servicio
          WHERE Reserva.id_usuario = ? AND Reserva.estado != 'cancelada'";

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
    <link rel="stylesheet" href="style.css">
</head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #ddd;
}

form {
    display: inline;
}

</style>
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
        <th>Acciones</th>
    </tr>';

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id_reserva']}</td>
            <td>{$row['fecha_hora']}</td>
            <td>{$row['estado']}</td>
            <td>{$row['nombre_servicio']}</td>
            <td>{$row['descripcion']}</td>
            <td>{$row['precio']} €</td>
            <td>";
    if ($row['estado'] !== 'cancelada') {
        echo "<form action='' method='post'>
                <input type='hidden' name='id_reserva' value='{$row['id_reserva']}'>
                <input type='submit' name='cancelar_reserva' value='Cancelar Reserva'>
              </form>";
    }
    echo "</td>
          </tr>";
}

echo '</table>
<a href="index.php">Volver a Inicio</a>
</body>
</html>';

$stmt->close();
$conexion->close();
