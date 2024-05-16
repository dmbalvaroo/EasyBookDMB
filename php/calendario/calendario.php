<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Reservas</title>
    <!-- <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css' rel='stylesheet' /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
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
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                expandRows: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                selectable: true,
                selectMirror: true,
                nowIndicator: true,
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '09:00',
                    endTime: '18:00'
                },
                events: 'load_events.php',
                select: function(arg) {
                    var title = prompt('Enter Event Title:');
                    var id_servicio = prompt('Enter Service ID:');
                    if (title && id_servicio) {
                        fetch('save_event.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                title: title,
                                start: arg.start.toISOString(),
                                end: arg.end.toISOString(),
                                allDay: arg.allDay,
                                id_servicio: id_servicio
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.id) {
                                calendar.addEvent({
                                    id: data.id,
                                    title: title,
                                    start: arg.start,
                                    end: arg.end,
                                    allDay: arg.allDay
                                });
                            } else {
                                console.error('Error:', data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error adding event:', error);
                        });
                    }
                    calendar.unselect();
                },
                eventClick: function(arg) {
                    if (confirm('Are you sure you want to delete this event?')) {
                        fetch(`delete_event.php?id=${arg.event.id}`, {
                            method: 'DELETE'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.deleted) {
                                arg.event.remove();
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting event:', error);
                        });
                    }
                }
            });
            calendar.render();
        });
        console.log('FullCalendar is', FullCalendar);

    </script>
</body>
</html>
