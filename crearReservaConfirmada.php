<?php
session_start();
require_once("php/conexionbd.php");
require_once("sendMailConfirmation.php"); // Ajusta la ruta según la ubicación de tu archivo sendMailConfirmation.php

if (!isset($_SESSION['id_usuario'])) {
    echo "<p>Acceso denegado: No se ha iniciado sesión.</p>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Función para cargar opciones de la base de datos
function getOptions($conexion, $query)
{
    $options = "";
    if ($result = $conexion->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='{$row['id']}'>{$row['nombre']}</option>";
        }
    }
    return $options;
}

$serviciosOptions = getOptions($conexion, "SELECT id_servicio AS id, nombre_servicio AS nombre FROM Servicio");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservar'])) {
    $id_servicio = $_POST['id_servicio'];
    $id_establecimiento = $_POST['id_establecimiento'];
    $fecha_hora = $_POST['fecha'] . ' ' . $_POST['hora'];

    // Verificar si la hora seleccionada está dentro del rango de operación del servicio
    $horario_servicio = $conexion->prepare("SELECT horario_inicio, horario_fin FROM Servicio WHERE id_servicio = ?");
    $horario_servicio->bind_param("i", $id_servicio);
    $horario_servicio->execute();
    $horario_servicio->store_result();
    $horario_servicio->bind_result($horario_inicio, $horario_fin);
    $horario_servicio->fetch();
    $horario_servicio->close();

    $fecha_hora_seleccionada = new DateTime($fecha_hora);
    $fecha_hora_inicio = new DateTime($fecha_hora_seleccionada->format('Y-m-d') . ' ' . $horario_inicio);
    $fecha_hora_fin = new DateTime($fecha_hora_seleccionada->format('Y-m-d') . ' ' . $horario_fin);

    if ($fecha_hora_seleccionada >= $fecha_hora_inicio && $fecha_hora_seleccionada <= $fecha_hora_fin) {
        $consulta = $conexion->prepare("SELECT * FROM Reserva WHERE id_servicio = ? AND id_establecimiento = ? AND fecha_hora = ?");
        $consulta->bind_param("iis", $id_servicio, $id_establecimiento, $fecha_hora);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows == 0) {
            $insertar = $conexion->prepare("INSERT INTO Reserva (fecha_hora, estado, id_usuario, id_servicio, id_establecimiento) VALUES (?, 'pendiente', ?, ?, ?)");
            $insertar->bind_param("siii", $fecha_hora, $id_usuario, $id_servicio, $id_establecimiento);
            if ($insertar->execute()) {
                // Instanciar la clase SendMailConfirmation
                $sendMailConfirmation = new SendMailConfirmation();

                // Enviar el correo electrónico de confirmación
                if ($sendMailConfirmation->enviarCorreoConfirmacion($id_servicio, $id_usuario, $fecha_hora)) {
                    echo "<p>Reserva realizada con éxito. Se ha enviado un correo electrónico de confirmación.</p>";
                } else {
                    echo "<p>Reserva realizada con éxito. Error al enviar el correo electrónico de confirmación.</p>";
                }
            } else {
                echo "<p>Error al realizar la reserva: " . $conexion->error . "</p>";
            }
        } else {
            echo "<p>El servicio no está disponible en la fecha y hora seleccionadas en el establecimiento seleccionado.</p>";
        }
    } else {
        echo "<p>La fecha u hora seleccionada no está dentro del horario permitido para este servicio.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Realizar Reserva</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            $("#fecha").datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0,
                beforeShowDay: $.datepicker.noWeekends,
                onSelect: function(dateText) {
                    cargarHorarios($('#id_servicio').val(), dateText);
                }
            });

            $('#id_servicio').change(function() {
                cargarEstablecimientos();
            });

            function cargarEstablecimientos() {
                var id_servicio = $('#id_servicio').val();
                fetch('get_establecimientos.php?id_servicio=' + id_servicio)
                    .then(response => response.json())
                    .then(data => {
                        $('#id_establecimiento').html(data.establecimientos);
                        cargarHorarios(id_servicio, $("#fecha").val());
                    })
                    .catch(error => console.error('Error al cargar los establecimientos:', error));
            }

            function cargarHorarios(id_servicio, fechaSeleccionada) {
                fetch('get_horarios_servicio.php?id_servicio=' + id_servicio)
                    .then(response => response.json())
                    .then(data => {
                        const horaInput = $('#hora');
                        let horarioInicio = parseInt(data.horario_inicio.split(':')[0], 10);
                        let horarioFin = parseInt(data.horario_fin.split(':')[0], 10);

                        let optionsHtml = '';
                        for (let i = horarioInicio; i <= horarioFin; i++) {
                            optionsHtml += `<option value="${i < 10 ? '0' + i : i}:00">${i < 10 ? '0' + i : i}:00</option>`;
                            optionsHtml += `<option value="${i < 10 ? '0' + i : i}:30">${i < 10 ? '0' + i : i}:30</option>`;
                        }
                        horaInput.html(optionsHtml);
                    })
                    .catch(error => console.error('Error al cargar horarios:', error));
            }
        });
    </script>
</head>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    form {
        background-color: #fff;
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        color: #666;
    }

    select,
    input[type="text"],
    input[type="time"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        /* Incluye padding y border en el ancho y alto */
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 4px;
        background-color: #5cb85c;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #4cae4c;
    }

    /* Estilos adicionales para mejorar la accesibilidad y la respuesta visual */
    input[type="submit"]:focus,
    select:focus,
    input[type="text"]:focus,
    input[type="time"]:focus {
        border-color: #80bdff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(130, 138, 255, 0.25);
    }
</style>

<body>
    <h2>Reservar un Servicio</h2>
    <form action="" method="post">
        <label for="id_servicio">Seleccione el servicio:</label>
        <select name="id_servicio" id="id_servicio">
            <?php echo $serviciosOptions; ?>
        </select>

        <label for="id_establecimiento">Seleccione el establecimiento:</label>
        <select name="id_establecimiento" id="id_establecimiento"></select>

        <label for="fecha">Seleccione fecha:</label>
        <input type="text" id="fecha" name="fecha" required readonly>

        <label for="hora">Seleccione hora:</label>
        <select id="hora" name="hora" required></select>

        <input type="submit" name="reservar" value="Reservar">
    </form>
</body>

</html>
