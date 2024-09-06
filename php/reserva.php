<?php
session_start(); 

$db = mysqli_connect("localhost", "root", "", "experiencia");

$experience = $_POST['experience'];
$datepicker = $_POST['datepicker'];
$name = $_POST['name']; 
$email = $_POST['email'];
$personas = (int)$_POST['personas'];

// Calcular el total basado en la experiencia y el número de personas
$precios = array(
    "Montserrat" => 80,
    "Sanatorio" => 50,
    "7Chimeneas" => 35
);


if (isset($precios[$experience]) && $personas > 0) {
    $total = $precios[$experience] * $personas;

    $q = "INSERT INTO reservas (experiencia, fecha, personas, nombre, email) VALUES ('$experience', '$datepicker', '$personas', '$name', '$email')";
    
    $tabla1 = mysqli_query($db, $q) or die("Problema con query");

    if ($tabla1) {
        
        // Guardar los datos en la sesión
        $_SESSION['experience'] = $experience;
        $_SESSION['datepicker'] = $datepicker;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['personas'] = $personas;
        $_SESSION['total'] = $total;

        header('Location:../php/forma_pago.php');
        exit; 
    } else {
        echo "FALLO AL REALIZAR LA RESERVA";
    }
} else {
    echo "Error: Experiencia no válida o número de personas no válido.";
}
?>
