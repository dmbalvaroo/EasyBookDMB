<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Servicios</title>
    <style>
        .service-container {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .category-button {
            margin: 5px;
            padding: 10px 15px;
            background-color: #f0f0f0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Registro de Servicios</h1>
    <div>
        <button class="category-button" onclick="cargarServicios('tipo1')">Desarrollo Web</button>
        <button class="category-button" onclick="cargarServicios('tipo2')">Soporte Técnico</button>
        <button class="category-button" onclick="cargarServicios('tipo3')">Seguridad IT</button>
        <button class="category-button" onclick="cargarServicios('tipo4')">Pediatría</button>
        <button class="category-button" onclick="cargarServicios('tipo5')">Cardiología</button>
        <button class="category-button" onclick="cargarServicios('tipo6')">Medicina General</button>
        <button class="category-button" onclick="cargarServicios('otros')">Otros Servicios</button>
    </div>
    <div id="listaServicios"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarServicios(''); // Carga todos los servicios al inicio
        });

        function cargarServicios(tipo) {
            const data = tipo ? 'tipo=' + encodeURIComponent(tipo) : '';
            fetch('get_services.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: data
                })
                .then(response => response.json())
                .then(servicios => {
                    const contenedor = document.getElementById('listaServicios');
                    contenedor.innerHTML = '';
                    servicios.forEach(servicio => {
                        const div = document.createElement('div');
                        div.className = 'service-container';
                        div.innerHTML = `
                <strong>${servicio.nombre_servicio}</strong><br>
                Descripción: ${servicio.descripcion}<br>
                Precio: €${servicio.precio}<br>
                <button onclick="window.location.href='../php/calendario/calendario.php?id_servicio=${servicio.id_servicio}'">Ver Calendario</button>
            `;
                        contenedor.appendChild(div);
                    });
                })
                .catch(error => console.error('Error al cargar los servicios:', error));
        }
    </script>

</body>

</html>