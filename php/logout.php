<?php
session_start();  // Asegurarse de que la sesión está iniciada
session_destroy();  // Destruir todos los datos de la sesión
header("Location: ../index.php");  // Redirigir al usuario a la página de inicio
exit();
?>
