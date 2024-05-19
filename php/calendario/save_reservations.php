<?php
header('Content-Type: application/json');  // Establece que la respuesta será de tipo JSON.

include("conexionbd.php");  // Incluye el script de conexión a la base de datos.

// Verificar si la conexión a la base de datos fue exitosa.
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Fallo al conectar a la base de datos: ' . $conexion->connect_error]);
    exit;  // Finaliza la ejecución si hay un error de conexión.
}

// Decodificar los datos recibidos en formato JSON.
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que todos los campos necesarios están presentes.
if (isset($data['title'], $data['start'], $data['end'])) {
    // Sanitizar y validar los datos recibidos.
    $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
    $start = filter_var($data['start'], FILTER_SANITIZE_STRING);
    $end = filter_var($data['end'], FILTER_SANITIZE_STRING);

    // Preparar la consulta SQL para insertar la nueva reserva.
    $stmt = $conexion->prepare("INSERT INTO Reserva (titulo, fecha_hora_inicio, fecha_hora_fin) VALUES (?, ?, ?)");
    if ($stmt) {
        // Asignar los parámetros a la declaración preparada y ejecutar.
        $stmt->bind_param("sss", $title, $start, $end);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            // En caso de error en la ejecución, devolver el mensaje de error.
            echo json_encode(['success' => false, 'error' => $conexion->error]);
        }
        $stmt->close();  // Cerrar la declaración preparada.
    } else {
        // Error al preparar la consulta.
        echo json_encode(['success' => false, 'error' => "Error al preparar la consulta: " . $conexion->error]);
    }
} else {
    // No todos los campos necesarios están presentes.
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
}

$conexion->close();  // Cerrar la conexión a la base de datos.
?>
