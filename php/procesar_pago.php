<?php
session_start();

// Verificar que los datos existen en la sesión
if (!isset($_SESSION['experience'], $_SESSION['datepicker'], $_SESSION['name'], $_SESSION['email'], $_SESSION['personas'], $_SESSION['total'])) {
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

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $metodo_pago = $_POST['payment'];

    // Guardar el método de pago en la sesión
    $_SESSION['payment'] = $metodo_pago;

    if ($metodo_pago == 'tarjeta') {
        // Redirigir a la ventana de datos de la tarjeta
        header('Location: datos_tarjeta.php');
        exit();
    } elseif ($metodo_pago == 'bizum') {
        // Redirigir a la ventana de pago de Bizum
        header('Location: pago_bizum.php');
        exit();
    } else {
        echo "Error: Método de pago no válido.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto my-12">
        <div class="text-center">
            <a class="text-black text-3xl font-bold" href="#">
                <pre>𓆩ɄӺꝊ ɆӾꝐɆꞦĪɆꞤȻɆ𓆪</pre>
                <p class="text-white text-sm px-4 py-2"><pre>ᴱˣᵖᵉʳⁱᵉⁿᶜⁱᵃˢ ᵖᵃʳᵃⁿᵒʳᵐᵃˡᵉˢ</pre></p>
            </a>
            <div class="bg-white p-8 shadow-md">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="flex flex-col items-center">
                        <!-- Método de Pago -->
                        <div class="mx-auto mb-4 w-full text-center">
                            <label for="payment" class="text-sm font-bold mb-2">Selecciona tu método de pago:</label>
                            <div class="flex justify-center items-center">
                                <input type="radio" id="bizum" name="payment" value="bizum" class="mr-2">
                                <label for="bizum" class="mr-4">Bizum</label>
                                <input type="radio" id="tarjeta" name="payment" value="tarjeta" class="mr-2">
                                <label for="tarjeta">Pago con tarjeta</label>
                            </div>
                        </div>
                        <!-- Botón de Pago -->
                        <div class="mb-4 w-full">
                            <button type="submit" class="w-full bg-black text-white font-semibold py-2 rounded-md hover:bg-gray-500 transition-colors">Continuar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
