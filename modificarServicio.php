<?php
session_start();
require_once("php/conexionbd.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    echo "<p>Acceso denegado. Solo para empresas.</p>";
    exit;
}

// Asegurarse de que el id de empresa está disponible
if (!isset($_SESSION['id_empresa'])) {
    echo "<p>Error: No se encuentra el ID de la empresa en la sesión.</p>";
    exit;
}

$id_usuario_admin = $_SESSION['id_usuario'];
$id_empresa = $_SESSION['id_empresa']; // Ahora usamos el ID de la empresa guardado en sesión

// Procesar la solicitud POST para actualizar un servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar_servicio'])) {
    $id_servicio = $_POST['id_servicio'];
    $nombre_servicio = $_POST['nombre_servicio'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];
    $tipo_servicio = $_POST['tipo_servicio'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];
    $dias_operativos = $_POST['dias_operativos'];

    $query = "UPDATE Servicio SET nombre_servicio=?, descripcion=?, precio=?, duracion=?, tipo_servicio=?, horario_inicio=?, horario_fin=?, dias_operativos=? WHERE id_servicio=?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssdiisssi", $nombre_servicio, $descripcion, $precio, $duracion, $tipo_servicio, $horario_inicio, $horario_fin, $dias_operativos, $id_servicio);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<p>Servicio actualizado con éxito.</p>";
    } else {
        echo "<p>Error al actualizar el servicio: " . $conexion->error . "</p>";
    }
    $stmt->close();
}

// Obtener los servicios de la empresa
$id_empresa = $_SESSION['id_empresa']; // Asegúrate de que el ID de la empresa está almacenado en la sesión
$query = "SELECT * FROM Servicio WHERE id_servicio IN (SELECT id_servicio FROM ServicioEstablecimiento WHERE id_establecimiento IN (SELECT id_establecimiento FROM Establecimiento WHERE id_empresa = ?))";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$resultado = $stmt->get_result();

echo "<h1>Modificar Servicios</h1>";
echo "<table border='1'>";
echo "<tr><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Duración</th><th>Tipo</th><th>Horario Inicio</th><th>Horario Fin</th><th>Días Operativos</th><th>Acciones</th></tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <form action='' method='post'>
            <td><input type='text' name='nombre_servicio' value='{$fila['nombre_servicio']}'></td>
            <td><textarea name='descripcion'>{$fila['descripcion']}</textarea></td>
            <td><input type='number' name='precio' value='{$fila['precio']}'></td>
            <td><input type='number' name='duracion' value='{$fila['duracion']}'></td>
            <td><input type='text' name='tipo_servicio' value='{$fila['tipo_servicio']}'></td>
            <td><input type='time' name='horario_inicio' value='{$fila['horario_inicio']}'></td>
            <td><input type='time' name='horario_fin' value='{$fila['horario_fin']}'></td>
            <td><input type='text' name='dias_operativos' value='{$fila['dias_operativos']}'></td>
            <td>
                <input type='hidden' name='id_servicio' value='{$fila['id_servicio']}'>
                <input type='submit' name='actualizar_servicio' value='Actualizar'>
            </td>
            </form>
          </tr>";
}

echo "</table>";
$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Servicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Modificar Servicios</h1>
    <!-- Contenido del cuerpo, incluyendo el formulario y tabla de servicios -->
</body>
</html>
