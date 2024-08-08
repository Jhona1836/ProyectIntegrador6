<?php

if(empty($_POST["btningresar"])){

    if (empty($_POST["Usuario"]) and empty($_POST["Password"])) {
        $error = "Los campos estan vacios";
    } else {
        $email = $_POST["Usuario"];
        $password = $_POST["Password"];
        $sql = $conexion->query("select * from usuarios where email = '$email' and password = '$password'");
        
        if($datos=$sql->fetch_object()){
            header("location:administrador.php");
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
}

?>