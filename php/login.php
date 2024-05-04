<?php
session_start(); // Iniciar sesión al comienzo del script

include("conexionbd.php");

if (isset($_POST["btningresar"])) {
    if (empty($_POST["correo_electronico"]) || empty($_POST["contrasena"])) {
        $error = "Los campos están vacíos";
    } else {
        $correo_electronico = $conexion->real_escape_string($_POST["correo_electronico"]);
        $contrasena = $_POST["contrasena"];  // Capturar la contraseña sin escapar para verificar hash

        $consulta = $conexion->prepare("SELECT ID_Usuario, Correo_Electronico, Contrasena FROM Usuario WHERE Correo_Electronico = ?");
        $consulta->bind_param("s", $correo_electronico);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows == 1) {
            $fila = $resultado->fetch_assoc();
            $contrasenaAlmacenada = $fila['Contrasena'];

            // Verificar la contraseña
            if (password_verify($contrasena, $contrasenaAlmacenada)) {
                $_SESSION['usuario'] = $fila['Correo_Electronico']; // Usar el correo electrónico como identificador de usuario
                $_SESSION['id_usuario'] = $fila['ID_Usuario'];

                // Redirigir a la página deseada
                header("Location: ../index.html");
                exit;
            } else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "Usuario no encontrado";
        }
        $consulta->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="post">
            <label for="correo_electronico">Correo Electrónico:</label>
            <input type="text" id="correo_electronico" name="correo_electronico" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <input type="submit" name="btningresar" value="Ingresar">
        </form>
        <?php
        if (!empty($error)) {
            echo "<p class='error'>" . $error . "</p>";
        }
        ?>
    </div>
</body>
</html>
