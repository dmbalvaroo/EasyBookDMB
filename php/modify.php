    <?php
    session_start();

    // Verificar si el usuario ha iniciado sesión, si no, redirigir a la página de login.
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit;
    }

    // Incluir conexión a la base de datos
    include("conexionbd.php");

    $usuario_id = $_SESSION['id_usuario'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $apellido = $conexion->real_escape_string($_POST['apellido']);
        $correo_electronico = $conexion->real_escape_string($_POST['correo_electronico']);
        $telefono = $conexion->real_escape_string($_POST['telefono']);

        // Verificar si el correo electrónico ya está registrado por otro usuario
        $checkEmail = $conexion->prepare("SELECT ID_Usuario FROM Usuario WHERE Correo_Electronico = ? AND ID_Usuario != ?");
        $checkEmail->bind_param("si", $correo_electronico, $usuario_id);
        $checkEmail->execute();
        $checkEmail->store_result();
        if ($checkEmail->num_rows > 0) {
            $error = "El correo electrónico ya está registrado.";
        } else {
            // Actualizar datos del usuario
            $updateStmt = $conexion->prepare("UPDATE Usuario SET nombre = ?, apellido = ?, correo_electronico = ?, telefono = ? WHERE ID_Usuario = ?");
            $updateStmt->bind_param("ssssi", $nombre, $apellido, $correo_electronico, $telefono, $usuario_id);
            $updateStmt->execute();

            if ($updateStmt->affected_rows === 1) {
                header("Location: profile.php"); // Redirigir al perfil si se actualiza correctamente
                exit;
            } else {
                $error = "No se pudo actualizar la información.";
            }
            $updateStmt->close();
        }
        $checkEmail->close();
    }

    // Cargar información del usuario para mostrar en el formulario
    $stmt = $conexion->prepare("SELECT nombre, apellido, correo_electronico, telefono FROM Usuario WHERE ID_Usuario = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $stmt->close();
    $conexion->close();
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Modificar Perfil</title>
        <link href="../css/login/modify.css" rel="stylesheet" />
    </head>
    <body>
        <div class="modify-container">
            <h2>Modificar Perfil</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="modify.php" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>

                <label for="correo_electronico">Correo Electrónico:</label>
                <input type="email" id="correo_electronico" name="correo_electronico" value="<?php echo htmlspecialchars($usuario['correo_electronico']); ?>" required>

                <label for="telefono">Teléfono:</label
                ><input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>

                <input type="submit" value="Actualizar">
            </form>
        </div>
    </body>
    </html>
