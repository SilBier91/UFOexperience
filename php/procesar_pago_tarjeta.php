<?php
session_start();
include 'datosTarjetas.php';

$experience = $_SESSION['experience'];
$fecha = $_SESSION['datepicker'];
$name = $_SESSION['name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_tarjeta = $_POST['nombre_tarjeta'];
    $email_tarjeta = $_POST['email_tarjeta'];
    $numero_tarjeta = $_POST['numero_tarjeta'];
    $fecha_expiracion = $_POST['fecha_expiracion'];
    $codigo_seguridad = $_POST['codigo_seguridad'];

    $hasError = false;
    $_SESSION['errors'] = [];

    // Validar el número de tarjeta (suponiendo que debe tener 16 dígitos)
    if (strlen($numero_tarjeta) != 16 || !ctype_digit($numero_tarjeta)) {
        $_SESSION['errors']['numero_tarjeta'] = '<span style="color:red;">Error en los dígitos introducidos.</span>';
        $hasError = true;
    }

    // Validar la fecha de expiración (formato MM/YY)
    if (!preg_match("/^(0[1-9]|1[0-2])\/\d{2}$/", $fecha_expiracion)) {
        $_SESSION['errors']['fecha_expiracion'] = '<span style="color:red;">Fecha mal introducida.</span>';
        $hasError = true;
    }

    if ($hasError) {
        header("Location: datos_tarjeta.php");
        exit();
    }

    // Comparar los datos con las tarjetas almacenadas
    foreach ($tarjetas as $tarjeta) {
        if ($tarjeta['card'] == $numero_tarjeta &&
            $tarjeta['name'] == $nombre_tarjeta &&
            $tarjeta['expiration_date'] == $fecha_expiracion &&
            $tarjeta['cvc'] == $codigo_seguridad) {
            
            // Si todo va bien, enviar el correo de confirmación
            $to = "silvia.lm91@gmail.com";
            $subject = "Confirmación de Reserva";
            $mensajeCorreo = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        background-color: black;
                        padding: 20px;
                        margin: 10px auto;
                        border: 1px solid #ddd;
                        max-width: 600px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        font-size: 24px;
                        color: white;
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .message {
                        font-size: 16px;
                        color: white;
                        line-height: 1.5;
                        text-align: center;
                    }
                    .logo {
                        text-align: center;
                        color: white;
                        font-size: 25px;
                    }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="header">¡Gracias ' . $name . ' por realizar tu reserva!</div>
                    <div class="message">
                        Disfruta de tu experiencia en ' .$experience. ' para el día y hora ' .$fecha. '
                    </div>
                    <div class="logo">
                        <pre>𓆩ɄӺꝊ ɆӾꝐɆꞦĪɆꞤȻɆ𓆪</pre>
                        <p><pre>ᴱˣᵖᵉʳⁱᵉⁿᶜⁱᵃˢ ᵖᵃʳᵃⁿᵒʳᵐᵃˡᵉˢ</pre></p>
                    </div>
                </div>
            </body>
            </html>';

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: ufoexperience@gmail.com  \r\n" . "Reply-to: no-reply@tu-dominio.com";

            if (mail($to, $subject, $mensajeCorreo, $headers)) {
                // Redirigir si todo va bien
                header("Location: ../src/confirmacion_pago.html");
                exit();
            } else {
                $_SESSION['errors']['general'] = 'Error al enviar el correo de confirmación';
                header("Location: datos_tarjeta.php");
                exit();
            }
        }
    }

    $_SESSION['errors']['general'] = 'Error: Los datos de la tarjeta no son válidos. Por favor, verifica la información e intenta nuevamente.';
    header("Location: datos_tarjeta.php");
    exit();
} else {
    $_SESSION['errors']['general'] = 'Error: No se recibieron datos del formulario.';
    header("Location: datos_tarjeta.php");
    exit();
}
?>
