<?php
session_start();

$conn = new mysqli("localhost", "root", "", "experiencia");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Validar y limpiar los datos de entrada
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
$mensaje = mysqli_real_escape_string($conn, $_POST['mensaje']);

$sql = "INSERT INTO correos (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verificar si la preparación de la consulta tuvo éxito
if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("ssss", $nombre, $email, $telefono, $mensaje);

if ($stmt->execute()) {
    $from= "UFO EXPERIENCE";
    $to = "silvia.lm91@gmail.com";
    $subject = "Consulta recibida";
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
                text-align:center;
            }
            .logo{
                text-align:center;
                color:white;
                font-size:25px;
            }
        </style>
    </head>
    <body>
        <div class="email-container">
            <div class="header">¡Gracias '. $nombre .' por enviarnos tu consulta!</div>
            <div class="message">
                Te contestaremos con la mayor brevedad posible :)
            </div>
            <div class="logo">
            <pre>𓆩ɄӺꝊ ɆӾꝐɆꞦĪɆꞤȻɆ𓆪</pre>
            <p><pre>ᴱˣᵖᵉʳⁱᵉⁿᶜⁱᵃˢ ᵖᵃʳᵃⁿᵒʳᵐᵃˡᵉˢ</pre></p>
            </div>
        </div>
    </body>
    </html>';

    $header = "MIME-Version: 1.0" . "\r\n";
    $header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $header .= "From: hola@gmail.com" . "\r\n" . "Reply-to: silvia.lm91@gmail.com";

    if (mail($to, $subject, $mensajeCorreo, $header)) {
        // Redirigir si todo va bien
        header("Location: ../src/formulario_enviado.html");
        exit();
    } else {
        echo "Error al enviar correo";
    }
} else {
    echo "Error al ejecutar la consulta: " . $stmt->error;
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>
