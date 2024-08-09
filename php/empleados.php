<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pixelcraft";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

$search = '';
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
}

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $email = $conn->real_escape_string($_POST['email']);
    $sql = "DELETE FROM usuarios WHERE email = '$email'";
    if (!$conn->query($sql)) {
        $error = "Error al eliminar el usuario: " . $conn->error;
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Verificar si el correo ya existe
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $error = "El correo electrónico ya existe";
    } else {
        // Verificar si hay espacios en blanco
        if (trim($email) == "" || trim($password) == "") {
            $error = "No se permiten espacios en blanco";
        } else {
            $sql = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password')";
            if (!$conn->query($sql)) {
                $error = "Error al agregar el usuario: " . $conn->error;
            } else {
                $mensaje = "Usuario agregado con éxito";
            }
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $conn->real_escape_string($_POST['id']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $sql = "UPDATE usuarios SET email = '$email', password = '$password' WHERE id = '$id'";
    if (!$conn->query($sql)) {
        $error = "Error al actualizar el usuario: " . $conn->error;
    }
}

$sql = "SELECT id, email, password FROM usuarios";
if ($search) {
    $sql .= " WHERE email LIKE '%$search%' OR password LIKE '%$search%'";
}
$result = $conn->query($sql);

if (!$result) {
    die("Error al ejecutar la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - Empleados</title>
    <link rel="stylesheet" href="php.css">
</head>


<body>
<div class="header">
        <div class="logo">PixelCraft</div>
        <div class="admin-info">
            <div class="admin-name">Administrador: Oscar Zavaleta</div>
            <div class="admin-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </div>
<div class="sidebar">
        <a href="#usuarios">Citas registradas</a>
        <a href="../php/detallesservicio.php">Clientes registrados</a>
        <a href="./empleados.php">usuarios</a>       
    </div>
    <div class="content">
        <h2>Empleados</h2>
        <form class="search-form" method="post" action="">
            <input type="text" name="search" placeholder="Buscar empleados..." value="<?php echo $search; ?>">
            <input type="submit" value="Buscar">
        </form>
        <?php if (isset($error)) { ?>
            <script>alert('<?php echo $error; ?>');</script>
        <?php } ?>
        <?php if (isset($mensaje)) { ?>
            <script>alert('<?php echo $mensaje; ?>');</script>
        <?php } ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</ht>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>". $row["id"]. "</td>
                        <td>". $row["email"]. "</td>
                        <td>
                            <span id='password-". $row["id"]. "'>". $row["password"]. "</span>
                            <button onclick='togglePassword(". $row["id"]. ")'>Ocultar</button>
                        </td>
                        <td>
                            <form method='post' action='' style='display:inline;'>
                                <input type='hidden' name='email' value='".$row["email"]."'>
                                <input type='hidden' name='action' value='delete'>
                                <input type='submit' value='Eliminar'>
                            </form>
                            <form method='post' action='' style='display:inline;'>
                                <input type='hidden' name='id' value='".$row["id"]."'>
                                <input type='hidden' name='email' value='".$row["email"]."'>
                                <input type='hidden' name='password' value='".$row["password"]."'>
                                <input type='hidden' name='action' value='update'>
                                <input type='submit' value='Actualizar'>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay empleados registrados</td></tr>";
            }
            ?>
        </table>
        <form method="post" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br><br>
            <input type='hidden' name='action' value='add'>
            <input type="submit" value="Agregar">
        </form>
    </div>
</body>
</html>

<script>
    function togglePassword(id) {
        var password = document.getElementById('password-' + id);
        if (password.style.display === 'none') {
            password.style.display = 'block';
        } else {
            password.style.display = 'none';
        }
    }
</script>