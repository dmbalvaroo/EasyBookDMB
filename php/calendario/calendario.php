<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Reservas</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px 10px;
            padding: 0;
            background-color: #f8f9fa;
            text-align: center;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div id='calendar'></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                selectable: true,
                select: function(info) {
                    var title = prompt("Ingrese el título del evento:");
                    if (title) {
                        var eventData = {
                            title: title,
                            start: info.startStr,
                            end: info.endStr
                        };
                        fetch('save_reservations.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(eventData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                calendar.addEvent({
                                    title: title,
                                    start: info.start,
                                    end: info.end
                                });
                                alert("Reserva guardada!");
                            } else {
                                alert("Error al guardar la reserva: " + data.error);
                            }
                        });
                    }
                    calendar.unselect();
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('load_events.php', {
                        method: 'GET',
                        headers: { 'Content-Type': 'application/json' }
                    })
                    .then(response => response.json())
                    .then(events => successCallback(events))
                    .catch(error => failureCallback(error));
                },
                eventClick: function(info) {
                    var eventId = info.event.id;
                    if (confirm("¿Desea eliminar esta reserva?")) {
                        fetch('delete_reservation.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: eventId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                info.event.remove();
                                alert("Reserva eliminada correctamente.");
                            } else {
                                alert("No se pudo eliminar la reserva: " + data.error);
                            }
                        });
                    }
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
