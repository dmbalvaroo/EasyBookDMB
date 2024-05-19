<?php
session_start();
require_once("php/conexionbd.php");

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
    $fecha_hora = $_POST['fecha_hora'];

    // Obtener horario de inicio y fin del servicio
    $horario_servicio = $conexion->prepare("SELECT horario_inicio, horario_fin FROM Servicio WHERE id_servicio = ?");
    $horario_servicio->bind_param("i", $id_servicio);
    $horario_servicio->execute();
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
                echo "<p>Reserva realizada con éxito.</p>";
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('id_servicio').addEventListener('change', cargarEstablecimientos);

            document.querySelector('form').addEventListener('submit', function(event) {
                if (!validarFechaHora()) {
                    event.preventDefault();
                    alert('La fecha u hora seleccionada no está dentro del horario permitido para este servicio.');
                }
            });
        });

        function cargarEstablecimientos() {
            var id_servicio = document.getElementById('id_servicio').value;
            fetch('get_establecimientos.php?id_servicio=' + id_servicio)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('id_establecimiento').innerHTML = data.establecimientos;
                    ajustarHorarios(id_servicio);
                })
                .catch(error => console.error('Error al cargar los establecimientos:', error));
        }

        function ajustarHorarios(id_servicio) {
            fetch('get_horarios_servicio.php?id_servicio=' + id_servicio)
                .then(response => response.json())
                .then(data => {
                    const fechaHoraInput = document.getElementById('fecha_hora');
                    let minDate = new Date();
                    let maxDate = new Date(minDate);
                    maxDate.setFullYear(maxDate.getFullYear() + 1); // Establece un año hacia adelante para el máximo

                    // Establece las horas de inicio y fin según los horarios de servicio
                    minDate.setHours(data.horario_inicio.split(':')[0], data.horario_inicio.split(':')[1]);
                    maxDate.setHours(data.horario_fin.split(':')[0], data.horario_fin.split(':')[1]);

                    fechaHoraInput.min = minDate.toISOString().slice(0, 16);
                    fechaHoraInput.max = maxDate.toISOString().slice(0, 16);

                    // Obtener horarios disponibles
                    obtenerHorariosDisponibles(id_servicio, minDate, maxDate);
                })
                .catch(error => console.error('Error al ajustar horarios:', error));
        }

        function obtenerHorariosDisponibles(id_servicio, minDate, maxDate) {
    const fechaHoraInput = document.getElementById('fecha_hora');
    const selectedDate = new Date(fechaHoraInput.value);
    const fechaSeleccionada = selectedDate.toISOString().slice(0, 10);

    fetch('get_reservas.php?id_servicio=' + id_servicio + '&fecha=' + fechaSeleccionada)
        .then(response => response.json())
        .then(data => {
            const reservas = data.reservas;
            const horariosDisponibles = [];
            let horaActual = new Date(minDate);

            // Crear un objeto de reservas por hora para facilitar la verificación
            const reservasPorHora = {};
            for (const reserva of reservas) {
                const reservaInicio = new Date(reserva.fecha_hora);
                const reservaHora = reservaInicio.getHours() + ':' + (reservaInicio.getMinutes() < 10 ? '0' : '') + reservaInicio.getMinutes();
                reservasPorHora[reservaHora] = true;
            }

            // Iterar sobre los horarios en intervalos de 30 minutos
            while (horaActual <= maxDate) {
                const horaActualString = horaActual.getHours() + ':' + (horaActual.getMinutes() < 10 ? '0' : '') + horaActual.getMinutes();
                if (!reservasPorHora[horaActualString]) {
                    horariosDisponibles.push(horaActualString);
                }
                horaActual.setMinutes(horaActual.getMinutes() + 30);
            }

            // Mostrar los horarios disponibles en el select
            const horariosSelect = document.getElementById('horarios_disponibles');
            horariosSelect.innerHTML = '';
            for (const horario of horariosDisponibles) {
                const option = document.createElement('option');
                option.text = horario;
                horariosSelect.add(option);
            }
        })
        .catch(error => console.error('Error al obtener horarios disponibles:', error));
}


        function validarFechaHora() {
            const fechaHoraInput = document.getElementById('fecha_hora');
            const selectedDate = new Date(fechaHoraInput.value);
            const minDate = new Date(fechaHoraInput.min);
            const maxDate = new Date(fechaHoraInput.max);
            return selectedDate >= minDate && selectedDate <= maxDate;
        }
    </script>





</head>
<style>
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
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    select,
    input[type="datetime-local"],
    input[type="submit"] {
        width: 100%;
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

    p {
        text-align: center;
    }
</style>

<body>
    <h2>Reservar un Servicio</h2>
    <form action="" method="post">
        <label for="id_servicio">Seleccione el servicio:</label>
        <select name="id_servicio" id="id_servicio" onchange="cargarEstablecimientos()">
            <?php echo $serviciosOptions; ?>
        </select>

        <label for="id_establecimiento">Seleccione el establecimiento:</label>
        <select name="id_establecimiento" id="id_establecimiento">
            <!-- Los establecimientos se cargarán dinámicamente -->
        </select>

        <label for="fecha_hora">Seleccione fecha y hora:</label>
        <input type="text" id="fecha_hora" name="fecha_hora" required readonly>
        <input type="submit" name="reservar" value="Reservar">
    </form>

    <script>
        $(document).ready(function() {
            $("#fecha_hora").datetimepicker({
                dateFormat: 'yy-mm-dd',
                timeFormat: 'HH:mm',
                minDate: 0, // Solo fechas a partir de hoy
                maxDate: '+1Y', // Máximo un año desde hoy
                hourMin: 9, // Hora mínima: 09:00
                hourMax: 17, // Hora máxima: 17:00
                stepMinute: 30 // Intervalo de 30 minutos
            });
        });
    </script>
</body>
</html>