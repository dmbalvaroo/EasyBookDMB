<?php
session_start();

// Verificar si el usuario ha iniciado sesión, si no, redirigir a la página de login.
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Incluir conexión a la base de datos
include("conexionbd.php");

// Recuperar información del usuario desde la base de datos
$usuario_id = $_SESSION['id_usuario'];
$stmt = $conexion->prepare("SELECT nombre, apellido, correo_electronico, telefono FROM Usuario WHERE ID_Usuario = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    echo "No se pudo cargar la información del usuario.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Usuario</title>
    <link href="../css/login/profile.css" rel="stylesheet" />

</head>
<body>
    <div class="profile-container">
        <h2>Perfil del Usuario</h2>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($usuario['apellido']); ?></p>
        <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['correo_electronico']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($usuario['telefono']); ?></p>
        <a href="logout.php">Cerrar Sesión</a>
        <a href="../index.php">Volver al inicio</a>
        <a href="../php/modify.php">Modificar mi perfil</a>
        <a href="../destroy.php">Eliminar mi cuenta</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
