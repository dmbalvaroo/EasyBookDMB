<?php
session_start();
require_once("php/conexionbd.php");

// Verificar si el usuario ha iniciado sesión y si es una empresa
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'empresa') {
    echo "<p>Acceso denegado. Solo para usuarios de tipo empresa.</p>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener el id de la empresa del usuario
$id_empresa = null;
$query_empresa = "SELECT id_empresa FROM Empresa WHERE id_usuario_admin = ?";
$stmt_empresa = $conexion->prepare($query_empresa);
$stmt_empresa->bind_param("i", $id_usuario);
$stmt_empresa->execute();
$stmt_empresa->bind_result($id_empresa);
$stmt_empresa->fetch();
$stmt_empresa->close();

// Cargar establecimientos de la empresa
$establecimientosOptions = '';
$query = "SELECT id_establecimiento, nombre FROM Establecimiento WHERE id_empresa = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $establecimientosOptions .= "<option value='{$row['id_establecimiento']}'>{$row['nombre']}</option>";
}
$stmt->close();

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_servicio'])) {
    $nombre_servicio = $_POST['nombre_servicio'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $duracion = $_POST['duracion'];
    $tipo_servicio = $_POST['tipo_servicio'];
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];
    $dias_operativos = $_POST['dias_operativos'];
    $id_establecimiento = $_POST['id_establecimiento'];

    // Insertar el nuevo servicio en la base de datos
    $query = "INSERT INTO Servicio (nombre_servicio, descripcion, precio, duracion, tipo_servicio, horario_inicio, horario_fin, dias_operativos) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssdiisss", $nombre_servicio, $descripcion, $precio, $duracion, $tipo_servicio, $horario_inicio, $horario_fin, $dias_operativos);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $id_servicio = $stmt->insert_id;
        // Asociar el servicio con el establecimiento
        $query_estab = "INSERT INTO ServicioEstablecimiento (id_servicio, id_establecimiento) VALUES (?, ?)";
        $stmt_estab = $conexion->prepare($query_estab);
        $stmt_estab->bind_param("ii", $id_servicio, $id_establecimiento);
        $stmt_estab->execute();
        echo "<p>Servicio creado con éxito.</p>";
    } else {
        echo "<p>Error al crear servicio: " . $conexion->error . "</p>";
    }
    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Añadir Servicio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    form {
        background-color: #ffffff;
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="number"],
    input[type="time"],
    textarea,
    select,
    input[type="submit"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        cursor: pointer;
        border: none;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    /* Estilos específicos para el formulario */
    textarea {
        height: 100px;
        /* Altura del área de texto */
    }

    label[for="nombre_servicio"],
    label[for="descripcion"],
    label[for="precio"],
    label[for="duracion"],
    label[for="tipo_servicio"],
    label[for="horario_inicio"],
    label[for="horario_fin"],
    label[for="dias_operativos"],
    label[for="id_establecimiento"] {
        font-weight: bold;
        /* Texto en negrita */
    }

    #horario_inicio,
    #horario_fin {
        width: 120px;
        /* Ancho de los campos de hora */
    }
</style>

<body>
    <h2>Añadir Nuevo Servicio</h2>
    <form action="" method="post">
        <label for="nombre_servicio">Nombre del Servicio:</label>
        <input type="text" id="nombre_servicio" name="nombre_servicio" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required>

        <label for="duracion">Duración (minutos):</label>
        <input type="number" id="duracion" name="duracion" required>

        <label for="tipo_servicio">Tipo de Servicio:</label>
        <input type="text" id="tipo_servicio" name="tipo_servicio" required>

        <label for="horario_inicio">Horario de Inicio (HH:MM):</label>
        <input type="time" id="horario_inicio" name="horario_inicio" required>

        <label for="horario_fin">Horario de Fin (HH:MM):</label>
        <input type="time" id="horario_fin" name="horario_fin" required>

        <label for="dias_operativos">Días Operativos (ej. 1,2,3,4,5):</label>
        <input type="text" id="dias_operativos" name="dias_operativos" required>

        <label for="id_establecimiento">Establecimiento:</label>
        <select id="id_establecimiento" name="id_establecimiento">
            <?php echo $establecimientosOptions; ?>
        </select>

        <input type="submit" name="crear_servicio" value="Crear Servicio">
    </form>
</body>

</html>