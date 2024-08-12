<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pixelcraft";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if(isset($_POST["btningresar"])){
    if (empty($_POST["Usuario"]) and empty($_POST["Password"])) {
        $error = "Los campos estan vacios";
    } else {
        $email = $_POST["Usuario"];
        $password = $_POST["Password"];
        $sql = $conn ->query("select * from usuarios where email = '$email' and password = '$password'");
        
        if ($datos=$sql->fetch_object()){
            header("location: administrador.php");
            exit; 
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/Inicio-sesion.css">
</head>
<body>
    <div class="container">
        <video autoplay loop muted id="video-background">
            <source src="/img/home/videomarketing.mp4" type="video/mp4">
            Tu navegador no soporta formato de video,<br>
            Te recomendamos tener un navegador mas actual para disfrutar la experiencia completa.
        </video>
        <div class="content">
            <h1>PixelCraft</h1>
        </div>

        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="Usuario" placeholder="Ingrese su usuario">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="Password" placeholder="Ingrese su contraseña">
                <button type="submit" name="btningresar">Iniciar sesión</button>
            </form>
            <?php if(isset($error)){ echo "<p style='color: red;'>$error</p>"; } ?>
        </div>
    </div>
</body>
</html>