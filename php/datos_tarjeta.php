<?php
session_start();
if (!isset($_SESSION['payment']) || $_SESSION['payment'] != 'tarjeta') {
    echo "Error: Método de pago incorrecto.";
    exit();
}

if (!isset($_SESSION['total'], $_SESSION['experience'], $_SESSION['personas'])) {
    echo "Error: Datos no disponibles.";
    exit();
}

$total = $_SESSION['total'];
$experience = $_SESSION['experience'];
$personas = $_SESSION['personas'];


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Tarjeta</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css" /> 

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-image: url('../img/bosque.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 5px;
            overflow-y: hidden;
        }
        
    </style>
</head>
<body class="bg-cover flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <div class="mb-6 text-left">
            <a href="../src/index.html" class="text-gray-600 text-sm flex items-center">
                <i class="fas fa-chevron-left mr-2"></i>
                Cancelar compra
            </a>
        </div>
        <div class="text-center mb-6">
            <h2 class="text-xl font-bold">Introduce los datos de tu tarjeta</h2>
        </div>
        <div class="flex justify-center gap-4 mb-6">
            <img src="../img/visa.png" alt="Visa" class="w-16 h-12">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="MasterCard" class="w-16 h-12">
            <img src="../img/american.jpg" alt="American Express" class="w-16 h-16">
        </div>
        <form action="procesar_pago_tarjeta.php" method="post">
            <div class="mb-4 relative">
                <label for="nombre_tarjeta" class="block font-bold mb-2">Nombre del titular:</label>
                <input type="text" id="nombre_tarjeta" name="nombre_tarjeta" class="w-full p-2 border border-gray-300 rounded" required>
                <?php
                if (isset($_SESSION['errors']['nombre_tarjeta'])) {
                    echo "<span class='error-message'>" . $_SESSION['errors']['nombre_tarjeta'] . "</span>";
                }
                ?>
            </div>
            <div class="mb-4 relative">
                <label for="numero_tarjeta" class="block font-bold mb-2">Número de tarjeta:</label>
                <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="w-full p-2 border border-gray-300 rounded" required>
                <?php
                if (isset($_SESSION['errors']['numero_tarjeta'])) {
                    echo "<span class='error-message'>" . $_SESSION['errors']['numero_tarjeta'] . "</span>";
                }
                ?>
            </div>
            <div class="mb-4 relative">
                <label for="fecha_expiracion" class="block font-bold mb-2">Fecha de expiración:</label>
                <input type="text" id="fecha_expiracion" name="fecha_expiracion" class="w-full p-2 border border-gray-300 rounded" placeholder="MM/AA" required>
                <?php
                if (isset($_SESSION['errors']['fecha_expiracion'])) {
                    echo "<span class='error-message'>" . $_SESSION['errors']['fecha_expiracion'] . "</span>";
                }
                ?>
            </div>
            <div class="mb-4 relative">
                <label for="codigo_seguridad" class="block font-bold mb-2">Código de seguridad:</label>
                <input type="password" id="codigo_seguridad" name="codigo_seguridad" class="w-full p-2 border border-gray-300 rounded" required>
                <?php
                if (isset($_SESSION['errors']['codigo_seguridad'])) {
                    echo "<span class='error-message'>" . $_SESSION['errors']['codigo_seguridad'] . "</span>";
                }
                ?>
            </div>
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <input type="hidden" name="experience" value="<?php echo $experience; ?>">
            <input type="hidden" name="personas" value="<?php echo $personas; ?>">
            <div>
                <button type="submit" class="w-full py-3 bg-black text-white rounded hover:bg-gray-800 transition duration-300">Pagar</button>
            </div>
        </form>
    </div>
    <?php
    if (isset($_SESSION['errors']['general'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                alert('" . $_SESSION['errors']['general'] . "');
            });
        </script>";
    }
    unset($_SESSION['errors']); // Clear errors after displaying them
    ?>
</body>
</html>
