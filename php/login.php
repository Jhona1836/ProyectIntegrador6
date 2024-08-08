<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/Inicio-sesion.css">
    <?php
    include("conexionBD.php");
    include("controlador.php");
    ?>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <?php if (isset($error)) { echo "<p class='alerta'>$error</p>"; } ?>
            <form action="" method="post">
                <input type="text" placeholder="Correo electrónico" id="email" name="Usuario" required>
                <input type="password" placeholder="Contraseña" id="password" name="Password" required>
                <button>Iniciar sesión</button>
                <p>¿No tienes cuenta? <a href="#">Regístrate</a></p>
            </form>
        </div>
    </div>
</body>
</html>