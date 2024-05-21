<?php
// Solo iniciar sesión si no hay una sesión ya activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("php/conexionbd.php");

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    echo "<p>Acceso denegado. Solo para empresas.</p>";
    exit;
}

$id_usuario_admin = $_SESSION['id_usuario'];

// Manejar la solicitud POST para actualizar el estado de la reserva
if (isset($_POST['actualizar_estado'])) {
    $id_reserva = $_POST['id_reserva'];
    $nuevo_estado = $_POST['estado'];

    $stmt_update = $conexion->prepare("UPDATE Reserva SET estado = ? WHERE id_reserva = ?");
    $stmt_update->bind_param("si", $nuevo_estado, $id_reserva);
    if ($stmt_update->execute()) {
        echo "<p>Reserva actualizada correctamente.</p>";
    } else {
        echo "<p>Error al actualizar reserva: " . $conexion->error . "</p>";
    }
    $stmt_update->close();
}

// Preparar la consulta para obtener las reservas
$query = "SELECT r.id_reserva, r.fecha_hora, r.estado, u.nombre AS usuario_nombre, s.nombre_servicio, e.nombre AS establecimiento_nombre
          FROM Reserva r
          JOIN Usuario u ON r.id_usuario = u.id_usuario
          JOIN Servicio s ON r.id_servicio = s.id_servicio
          JOIN Establecimiento e ON r.id_establecimiento = e.id_establecimiento
          JOIN Empresa emp ON e.id_empresa = emp.id_empresa
          WHERE emp.id_usuario_admin = ?";

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_usuario_admin);
$stmt->execute();
$resultado = $stmt->get_result();

echo "<h1>Gestión de Reservas</h1>";
if ($resultado->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID Reserva</th><th>Usuario</th><th>Servicio</th><th>Establecimiento</th><th>Fecha y Hora</th><th>Estado</th><th>Acciones</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['id_reserva']}</td>
                <td>{$fila['usuario_nombre']}</td>
                <td>{$fila['nombre_servicio']}</td>
                <td>{$fila['establecimiento_nombre']}</td>
                <td>{$fila['fecha_hora']}</td>
                <td>{$fila['estado']}</td>
                <td>
                    <form action='' method='post'>
                        <input type='hidden' name='id_reserva' value='{$fila['id_reserva']}'>
                        <select name='estado'>
                            <option value='pendiente' " . ($fila['estado'] == 'pendiente' ? 'selected' : '') . ">Pendiente</option>
                            <option value='confirmada' " . ($fila['estado'] == 'confirmada' ? 'selected' : '') . ">Confirmada</option>
                            <option value='cancelada' " . ($fila['estado'] == 'cancelada' ? 'selected' : '') . ">Cancelada</option>
                        </select>
                        <input type='submit' name='actualizar_estado' value='Actualizar Estado'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay reservas asociadas a su empresa.</p>";
}
$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Reservas</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            color: #666;
        }

        /* Estilos para la tabla de reservas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Estilos para el formulario dentro de la tabla */
        form {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        select,
        input[type="submit"] {
            margin: 0 5px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            cursor: pointer;
        }

        /* Estilos para los botones de estado */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }

        /* Estilos para el mensaje de éxito o error */
        .message {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Contenido de tu página -->
</body>

</html>