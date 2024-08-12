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

$sql = "SELECT id, nombre, apellido, profession, cargo, email, password FROM usuarios";
if ($search) {
    $sql .= " WHERE nombre LIKE '%$search%' OR apellido LIKE '%$search%' OR email LIKE '%$search%'";
}
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $action = $_POST["action"];
    $id = $_POST["id"] ?? null;
    $nombre = $_POST["nombre"] ?? null;
    $apellido = $_POST["apellido"] ?? null;
    $profession = $_POST["profession"] ?? null;
    $cargo = $_POST["cargo"] ?? null;
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;

    if ($action == "create") {
        $sql = "INSERT INTO usuarios (nombre, apellido, profession, cargo, email, password) VALUES ('$nombre', '$apellido', '$profession', '$cargo', '$email', '$password')";
        $conn->query($sql);
    } elseif ($action == "update" && $id) {
        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', profession='$profession', cargo='$cargo', email='$email', password='$password' WHERE id='$id'";
        $conn->query($sql);
    } elseif ($action == "delete" && $id) {
        $sql = "DELETE FROM usuarios WHERE id='$id'";
        $conn->query($sql);
    }
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
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
<div class="header">
        <div class="logo">PixelCraft</div>
        <div class="admin-info">
            <div class="admin-name">Administrador: Oscar Zavaleta</div>
            <div class="admin-icon">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </div>
<body>
    <div class="sidebar">
        <a href="./administrador.php">Citas registradas</a>
        <a href="../php/detallesservicio.php">Clientes registrados</a>
        <a href="./empleados.php">Usuarios</a> 
        <li><button id="cerrar-sesion">Cerrar sesión</button></li>      
    </div>
    <div class="content">
        <h2 id="usuarios">Empleados</h2>
        <form class="search-form" method="post" action="">
            <input type="text" name="search" placeholder="Buscar empleados..." value="<?php echo $search; ?>">
            <input type="submit" value="Buscar">
        </form>
        <button onclick="showCreateForm()">Añadir Empleado</button>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Profesión</th>
                <th>Cargo</th>
                <th>Email</th>
                <th>Password</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>". $row["id"]. "</td>
                            <td>". $row["nombre"]. "</td>
                            <td>". $row["apellido"]. "</td>
                            <td>". $row["profession"]. "</td>
                            <td>". $row["cargo"]. "</td>
                            <td>". $row["email"]. "</td>
                            <td>". $row["password"]. "</td>
                            <td>
                                <button onclick=\"showUpdateForm('".$row["id"]."', '".$row["nombre"]."', '".$row["apellido"]."', '".$row["profession"]."', '".$row["cargo"]."', '".$row["email"]."', '".$row["password"]."')\">Editar</button>
                                                               <form method='post' action='' style='display:inline;'>
                                    <input type='hidden' name='id' value='".$row["id"]."'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' value='Eliminar'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No hay empleados registrados</td></tr>";
            }
            $conn->close();
           ?>
        </table>

        <div id="form-container" style="display:none;">
            <form id="crud-form" method="post" action="">
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="id" id="id">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" required>
                <label for="profession">Profesión:</label>
                <input type="text" name="profession" id="profession" required>
                <label for="cargo">Cargo:</label>
                <input type="text" name="cargo" id="cargo" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Guardar">
                <button type="button" onclick="hideForm()">Cancelar</button>
            </form>
        </div>
    </div>
    <script>
        function showCreateForm() {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('crud-form').reset();
            document.getElementById('action').value = 'create';
        }

        function showUpdateForm(id, nombre, apellido, profession, cargo, email, password) {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('action').value = 'update';
            document.getElementById('id').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('apellido').value = apellido;
            document.getElementById('profession').value = profession;
            document.getElementById('cargo').value = cargo;
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        function hideForm() {
            document.getElementById('form-container').style.display = 'none';
        }
        document.getElementById("cerrar-sesion").addEventListener("click", function() {
    // Cerrar sesión y redirigir al usuario a la página index.html
    // Aquí puedes agregar la lógica para cerrar la sesión, por ejemplo:
    // localStorage.removeItem("token");
    // sessionStorage.removeItem("usuario");
    location = "../index.html";
  });
    </script>
</body>
</html>