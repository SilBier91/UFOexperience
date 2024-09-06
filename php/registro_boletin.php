<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "experiencia");

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $privacy = isset($_POST['privacy']) ? $_POST['privacy'] : null;

    if (!empty($name) && !empty($email) && $privacy) {
        $sql = "INSERT INTO boletin (nombre, email) VALUES ('$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            // Enviar correo electrónico
            $from = "UFO EXPERIENCE";
            $to = "silvia.lm91@gmail.com";
            $subject = "Gracias por suscribirte a nuestra newsletter";
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
                    <div class="header">¡Gracias '. $name .' por suscribirte a nuestra newsletter!</div>
                    <div class="message">
                        ¡Bienvenido a la comunidad!
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
                // HTML de agradecimiento por suscribirse
                echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias por suscribirte</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../img/bosque.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-3xl font-bold mb-4">¡Gracias por suscribirte a nuestra newsletter!</h1>
        <img src="../img/alien_2.png" alt="Alien" class="mx-auto mb-4">
        <p class="text-gray-600">¡Bienvenido a la comunidad!</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "../src/index.html";
        }, 5000);
    </script>
</body>
</html>
HTML;
            } else {
                echo "Error al enviar el correo electrónico";
            }
        } else {
            echo "Error al insertar en la base de datos: " . $conn->error;
        }
    } else {
        echo "Por favor, completa todos los campos y acepta la política de privacidad.";
    }

    $conn->close();
}
?>
