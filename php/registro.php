<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de incluir tu hoja de estilos CSS aquí -->
</head>
<body>
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="email" id="correo_electronico" name="correo_electronico" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <input type="submit" name="btnregistrar" value="Registrar">
        </form>

        <?php
        include("conexionbd.php");

        // Verificar si se ha enviado el formulario de registro
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los datos del formulario
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $correo_electronico = $_POST["correo_electronico"];
            $contrasena = $_POST["contrasena"];
            $telefono = $_POST["telefono"];
            $nivel_acceso = 1; // Establecer nivel de acceso por defecto, puedes cambiarlo según tus necesidades

            // Insertar los datos en la base de datos
            $sql = "INSERT INTO Usuario (Nombre, Apellido, Correo_Electronico, Contrasena, Telefono, Nivel_Acceso) 
                    VALUES ('$nombre', '$apellido', '$correo_electronico', '$contrasena', '$telefono', $nivel_acceso)";

            if ($conexion->query($sql) === TRUE) {
                // Redirigir a login.php si el registro es exitoso
                header("Location: login.php");
                exit;
            } else {
                // Mostrar mensaje de error si falla el registro
                echo "<p>Error al registrar el usuario: " . $conexion->error . "</p>";
            }

            // Cerrar la conexión a la base de datos
            $conexion->close();
        }
        ?>
    </div>
</body>
</html>
