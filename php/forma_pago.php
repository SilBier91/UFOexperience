<?php
session_start();

// Verificar que los datos existen en la sesión
if (!isset($_SESSION['experience'], $_SESSION['datepicker'], $_SESSION['name'], $_SESSION['email'], $_SESSION['personas'])) {
    echo "Error: Datos no disponibles.";
    exit();
}

// Recuperar los datos de la sesión
$experience = $_SESSION['experience'];
$datepicker = $_SESSION['datepicker'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$personas = $_SESSION['personas'];
$total = $_SESSION['total'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css" /> 
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-image: url('../img/bosque.jpg');
            background-size: cover;
        }
       
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto my-12">
        <div class="text-center">
            <a class="text-black text-3xl font-bold" href="#">
                <pre>𓆩ɄӺꝊ ɆӾꝐɆꞦĪɆꞤȻɆ𓆪</pre>
                <p class="text-white text-sm px-4 py-2"><pre>ᴱˣᵖᵉʳⁱᵉⁿᶜⁱᵃˢ ᵖᵃʳᵃⁿᵒʳᵐᵃˡᵉˢ</pre></p>
            </a>
            <div class="bg-white p-8 shadow-md">
                <!-- Formulario de Pago -->
                <form action="../php/procesar_pago.php" method="post">
                    <div class="flex flex-col items-center">
                        <!-- Método de Pago -->
                        <div class="mx-auto mb-4 w-full text-center">
                            <label for="payment" class="text-sm font-bold mb-2">Selecciona tu método de pago:</label>
                            <div class="flex justify-center items-center">
                                <input type="radio" id="bizum" name="payment" value="bizum" class="mr-2" >
                                <label for="bizum" class="mr-4">Bizum</label>
                                <input type="radio" id="tarjeta" name="payment" value="tarjeta" class="mr-2">
                                <label for="tarjeta">Pago con tarjeta</label>
                            </div>
                        </div>
                        <!-- Total de Reserva -->
                        <div class="mb-4 w-full">
                            <label for="total" class="block text-sm font-bold mb-2">Total de la reserva:</label>
                            
                                <?php echo $total . "€"; ?>
                            
                            <!-- Enviar los datos ocultos al procesar el pago -->
                            <input type="hidden" name="total" value="<?php $total; ?>">
                            <input type="hidden" name="experience" value="<?php echo$experiencia; ?>">
                            <input type="hidden" name="personas" value="<?php echo $personas; ?>">
                        </div>
                        <!-- Botón de Pago -->
                        <div class="mb-4 w-full">
                            <button id="pagarBtn" class="w-full bg-black text-white font-semibold py-2 rounded-md hover:bg-gray-500 transition-colors">Realizar Pago</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Enlace a la Página Principal -->
    <div class="text-center my-8">
        <a href="../src/index_prueba.html" class="bg-black text-white px-8 py-2 rounded uppercase font-bold">Página principal</a>
    </div>

</body>
</html>
