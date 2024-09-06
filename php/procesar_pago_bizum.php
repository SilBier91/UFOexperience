<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $phone = $_POST['phone'];

    // Validar el número de teléfono (debe tener al menos 9 dígitos)
    if (strlen($phone) < 9 || !ctype_digit($phone)) {
        $errors['phone'] = "<span style='color:red;'El número de teléfono debe tener al menos 9 dígitos.</span>";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: pago_bizum.php"); 
        exit();
    }

    header("Location: ../src/confirmacion_pago.html");
    exit();
} else {
    echo "Error: No se recibieron datos del formulario.";
    exit();
}
?>
