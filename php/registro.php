<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="../css/login/registro.css" rel="stylesheet" />

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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $conexion->real_escape_string($_POST["nombre"]);
            $apellido = $conexion->real_escape_string($_POST["apellido"]);
            $correo_electronico = $conexion->real_escape_string($_POST["correo_electronico"]);
            $contrasena = $conexion->real_escape_string($_POST["contrasena"]);
            $telefono = $conexion->real_escape_string($_POST["telefono"]);
            $nivel_acceso = 'base'; // Ajusta según tus necesidades

            // Verificar si el correo electrónico ya está registrado
            $query = $conexion->prepare("SELECT Correo_Electronico FROM Usuario WHERE Correo_Electronico = ?");
            $query->bind_param("s", $correo_electronico);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                echo "<p>Este correo electrónico ya está registrado.</p>";
            } else {
                // Encriptar la contraseña antes de guardarla en la base de datos
                $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

                // Insertar los datos en la base de datos
                $stmt = $conexion->prepare("INSERT INTO Usuario (Nombre, Apellido, Correo_Electronico, Contrasena, Telefono, Nivel_Acceso) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $nombre, $apellido, $correo_electronico, $contrasena_hash, $telefono, $nivel_acceso);

                if ($stmt->execute()) {
                    header("Location: login.php");
                    exit;
                } else {
                    echo "<p>Error al registrar el usuario: " . $conexion->error . "</p>";
                }

                $stmt->close();
            }
            $query->close();
            $conexion->close();
        }
        ?>
    </div>
</body>
</html>
