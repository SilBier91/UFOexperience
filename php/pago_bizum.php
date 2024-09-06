<?php
session_start();

// Verificar que el método de pago sea Bizum
if (!isset($_SESSION['payment']) || $_SESSION['payment'] != 'bizum') {
    echo "Error: Método de pago incorrecto.";
    exit();
}

// Verificar que los datos existen en la sesión
if (!isset($_SESSION['total'], $_SESSION['experience'], $_SESSION['personas'])) {
    echo "Error: Datos no disponibles.";
    exit();
}

// Recuperar los datos de la sesión
$total = $_SESSION['total'];
$experience = $_SESSION['experience'];
$personas = $_SESSION['personas'];
$nombre_tarjeta=$_SESSION['name'];
$fecha=$_SESSION['datepicker'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];

    // Validar el teléfono
    if (empty($phone)) {
        $_SESSION['errors']['phone'] = 'El teléfono es obligatorio';
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {

        // Suponiendo que el pago fue exitoso, enviamos el correo de confirmación
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
                <div class="header">¡Gracias ' . $nombre_tarjeta . ' por realizar tu reserva!</div>
                <div class="message">
                    Disfruta de tu experiencia en ' . $experience . ' para el día y hora ' . $fecha . '
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
        $headers .= "From: ufoexperience@gmail.com\r\n";
        $headers .= "Reply-to: no-reply@tu-dominio.com";

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Bizum Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css" /> 
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-image: url('../img/bosque.jpg');
            background-size: cover;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-6">
            <a class="text-gray-500 text-sm" href="../src/index_prueba.html">
                <i class="fas fa-chevron-left"></i>
                Cancelar compra
            </a>
        </div>
        <div class="text-center mb-6">
            <img alt="Bizum logo" class="mx-auto mb-2" height="50" src="../img/logo_bizum.jpg" width="100"/>
            <h1 class="text-xl font-bold text-gray-700">
                ALTUDOG BIZUM
            </h1>
            <p class="text-gray-600">
                Introduce tu teléfono para
                <br/>
                realizar el pago
            </p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <form action="" method="post">
                <label class="block text-gray-700 font-medium mb-2" for="phone">
                    Teléfono registrado en Bizum
                    <i class="fas fa-question-circle text-gray-400"></i>
                </label>
                <div class="relative mb-4">
                    <input class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-black" id="phone" name="phone" placeholder="Introduce tu teléfono" type="text" required/>
                    <i class="fas fa-mobile-alt absolute right-3 top-3 text-gray-400"></i>
                    <?php
                    if (isset($_SESSION['errors']['phone'])) {
                        echo "<span style='color:red;'>" . $_SESSION['errors']['phone'] . "</span>";
                    }
                    ?>
                </div>
                <p class="text-gray-500 text-sm mb-4">
                    No olvides tener tu móvil a mano
                </p>
                <button type="submit" class="w-full bg-gray-600 text-white py-3 rounded-lg font-medium hover:bg-gray-700">
                    Pagar
                </button>
            </form>
        </div>
        <div class="text-center mt-6">
            <p class="text-gray-700 font-bold mb-3">
                Detalle del pago: <?php echo $total . "€"; ?>
            </p>
            <p class="text-gray-500 text-sm">
                Pago 100% seguro
            </p>
        </div>
    </div>
    <?php
    unset($_SESSION['errors']); 
    ?>
</body>
</html>
