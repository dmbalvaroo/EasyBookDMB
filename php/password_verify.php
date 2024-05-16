<?php
session_start(); // Iniciar sesión al comienzo del script

include("conexionbd.php");

if (isset($_POST["btningresar"])) {
    if (empty($_POST["correo_electronico"]) || empty($_POST["contrasena"])) {
        echo "Los campos están vacíos";
    } else {
        $correo_electronico = $conexion->real_escape_string($_POST["correo_electronico"]);
        $contrasena = $conexion->real_escape_string($_POST["contrasena"]);

        // Consultar la información del usuario basada en el correo electrónico
        $consulta = $conexion->prepare("SELECT ID_Usuario, Correo_Electronico, Contrasena, tipo_usuario, nivel_acceso FROM Usuario WHERE Correo_Electronico = ?");
        $consulta->bind_param("s", $correo_electronico);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows == 1) {
            $fila = $resultado->fetch_assoc();
            if (password_verify($contrasena, $fila['Contrasena'])) {
                $_SESSION['usuario'] = $fila['Correo_Electronico']; 
                $_SESSION['id_usuario'] = $fila['ID_Usuario'];
                $_SESSION['tipo_usuario'] = $fila['tipo_usuario'];
                $_SESSION['nivel_acceso'] = $fila['nivel_acceso'];

                // Redirigir según el tipo de usuario
                if ($fila['tipo_usuario'] === 'empresa' || $fila['nivel_acceso'] === 'administrador') {
                    header("Location: ../indexEmpresa.php");
                } else {
                    header("Location: ../index.php");
                }
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
