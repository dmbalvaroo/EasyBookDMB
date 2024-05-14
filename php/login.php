<?php
session_start(); // Iniciar sesión al comienzo del script

include("conexionbd.php");

if (isset($_POST["btningresar"])) {
    // Verificar si alguno de los campos está vacío
    if (empty($_POST["correo_electronico"]) || empty($_POST["contrasena"])) {
        echo "LOS CAMPOS ESTÁN VACÍOS";
    } else {
        $correo_electronico = $conexion->real_escape_string($_POST["correo_electronico"]);
        $contrasena = $conexion->real_escape_string($_POST["contrasena"]);

        // Consultar la contraseña del usuario
        $consulta = $conexion->prepare("SELECT ID_Usuario, Correo_Electronico, Contrasena FROM Usuario WHERE Correo_Electronico = ?");
        $consulta->bind_param("s", $correo_electronico);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows == 1) {
            // Obtener la contraseña de la base de datos
            $fila = $resultado->fetch_assoc();
            $contrasenaAlmacenada = $fila['Contrasena'];

            // Verificar la contraseña utilizando password_verify
            if (password_verify($contrasena, $contrasenaAlmacenada)) {
                $_SESSION['usuario'] = $fila['Correo_Electronico']; // Usar el correo electrónico como identificador de usuario
                $_SESSION['id_usuario'] = $fila['ID_Usuario'];

                // Redirigir a la página de inicio después del login
                header("Location: ../index.php"); // Asegúrate de redirigir a un archivo .php si necesitas acceso a la sesión
                exit;
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "Usuario no encontrado";
        }
        $consulta->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="../css/login/login.css" rel="stylesheet" />
    <meta charset="UTF-8">
    <title>Login</title>
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
    </div>
</body>

</html>