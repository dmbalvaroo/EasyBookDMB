<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Ajusta la ruta al directorio correcto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $userEmail = htmlspecialchars($_POST['email']);
    $userMessage = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true); // Habilitar excepciones

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ademihuel@gmail.com';
        $mail->Password = 'pube itwa wbwk corn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom($userEmail, "$fname $lname");
        $mail->addAddress('ademihuel@gmail.com', 'Alvaro');
        $mail->addReplyTo($userEmail, "$fname $lname");

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "<strong>Has recibido un nuevo mensaje de contacto:</strong><br><br>" .
                         "<strong>Nombre:</strong> $fname $lname<br>" .
                         "<strong>Email:</strong> $userEmail<br>" .
                         "<strong>Mensaje:</strong> $userMessage";

        $mail->send();
        echo 'Tu mensaje ha sido enviado correctamente.';
    } catch (Exception $e) {
        echo "Lo siento, hubo un error al enviar tu mensaje. Error de Mailer: " . $mail->ErrorInfo;
    }
}
?>
