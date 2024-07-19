<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pixelcraft";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$description = $_POST['message'];

$sql = "INSERT INTO tabla_registro (usuario, correo, telefono, direccion, comentario) VALUES ('$name', '$email', '$phone', '$address', '$description')";

if ($conn->query($sql) === TRUE) {
    include('registroexitoso.html');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
