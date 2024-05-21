<?php
session_start();

// Comprueba si el usuario no ha iniciado sesión o no es un usuario de tipo 'empresa' ni 'administrador'
if (!isset($_SESSION['id_usuario']) || ($_SESSION['tipo_usuario'] !== 'empresa' && $_SESSION['nivel_acceso'] !== 'empresa')) {
    echo "<p>Acceso denegado. Debes ser un usuario de tipo Empresa o Administrador para acceder a esta página.</p>";
    exit; // Detiene la ejecución adicional del script
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control para Empresas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">EasyBook Empresas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="crearNuevoServicio.php">Agregar Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modificarServicio.php">Modificar Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestionReservas.php">Ver Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h1>Bienvenido al Panel de Control de Empresas</h1>
                <p>Desde aquí puedes gestionar todos los aspectos de tu servicio ofrecido a través de EasyBook.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Agregar Nuevo Servicio</h5>
                        <p class="card-text">Añade nuevos servicios para que tus clientes puedan reservarlos.</p>
                        <a href="agregar_servicio.php" class="btn btn-primary">Agregar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Modificar Servicios</h5>
                        <p class="card-text">Edita los detalles de tus servicios existentes.</p>
                        <a href="modificar_servicios.php" class="btn btn-primary">Modificar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ver Reservas</h5>
                        <p class="card-text">Revisa todas las reservas hechas por los clientes.</p>
                        <a href="ver_reservas.php" class="btn btn-primary">Ver Reservas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4">
        <p>© 2024 EasyBook Empresas. Todos los derechos reservados.</p>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
