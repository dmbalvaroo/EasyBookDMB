<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ConfirmacionMail {
    private $conexion;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Método para enviar el correo electrónico de confirmación
    public function enviarCorreoConfirmacion($id_servicio, $id_usuario, $fecha, $hora) {
        require '../../vendor/autoload.php';

        // Consulta para obtener los detalles del servicio reservado
        $stmt = $this->conexion->prepare("SELECT nombre_servicio FROM Servicio WHERE id_servicio = ?");
        $stmt->bind_param("i", $id_servicio);
        $stmt->execute();
        $stmt->bind_result($nombre_servicio);
        $stmt->fetch();
        $stmt->close();

        // Consulta para obtener el correo electrónico del usuario
        $stmt = $this->conexion->prepare("SELECT correo_electronico FROM Usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($correo_usuario);
        $stmt->fetch();
        $stmt->close();

        // Configuración del correo electrónico
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            // Configura los detalles del servidor SMTP
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tu_correo@gmail.com'; // Reemplaza con tu dirección de correo electrónico
            $mail->Password = 'tu_contraseña'; // Reemplaza con tu contraseña de correo electrónico
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Contenido del correo electrónico
            $mail->setFrom('tu_correo@gmail.com', 'Tu Nombre');
            $mail->addAddress($correo_usuario);
            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de Reserva';
            $mail->Body    = "¡Tu reserva del servicio $nombre_servicio para el $fecha a las $hora ha sido confirmada!";
            $mail->send();
            return true; // Correo enviado con éxito
        } catch (Exception $e) {
            return false; // Error al enviar el correo electrónico
        }
    }
}
?>
