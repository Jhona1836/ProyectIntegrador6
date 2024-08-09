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

$sql = "SELECT id, usuario, correo, telefono, direccion, comentario FROM tabla_registro";
if ($search) {
    $sql .= " WHERE usuario LIKE '%$search%' OR correo LIKE '%$search%' OR telefono LIKE '%$search%' OR direccion LIKE '%$search%' OR comentario LIKE '%$search%'";
}
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $action = $_POST["action"];
    $id = $_POST["id"] ?? null;
    $usuario = $_POST["usuario"] ?? null;
    $correo = $_POST["correo"] ?? null;
    $telefono = $_POST["telefono"] ?? null;
    $direccion = $_POST["direccion"] ?? null;
    $comentario = $_POST["comentario"] ?? null;

    if ($action == "create") {
        $sql = "INSERT INTO tabla_registro (usuario, correo, telefono, direccion, comentario) VALUES ('$usuario', '$correo', '$telefono', '$direccion', '$comentario')";
        $conn->query($sql);
    } elseif ($action == "update" && $id) {
        $sql = "UPDATE tabla_registro SET usuario='$usuario', correo='$correo', telefono='$telefono', direccion='$direccion', comentario='$comentario' WHERE id='$id'";
        $conn->query($sql);
    } elseif ($action == "delete" && $id) {
        $sql = "DELETE FROM tabla_registro WHERE id='$id'";
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
    <title>Panel de Administrador - PixelCraft</title>
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
        <a href="#usuarios">Citas registradas</a>
        <a href="../php/detallesservicio.php">Clientes registrados</a>
        <a href="./empleados.php">usuarios</a>       
    </div>
    <div class="content">
        <h2 id="usuarios">Citas registradas</h2>
        <form class="search-form" method="post" action="">
            <input type="text" name="search" placeholder="Buscar usuarios..." value="<?php echo $search; ?>">
            <input type="submit" value="Buscar">
        </form>
        <button onclick="showCreateForm()">Añadir Usuario</button>
        <table>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Comentario</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>". $row["id"]. "</td>
                            <td>". $row["usuario"]. "</td>
                            <td>". $row["correo"]. "</td>
                            <td>". $row["telefono"]. "</td>
                            <td>". $row["direccion"]. "</td>
                            <td>". $row["comentario"]. "</td>
                            <td>
                                <button onclick=\"showUpdateForm('".$row["id"]."', '".$row["usuario"]."', '".$row["correo"]."', '".$row["telefono"]."', '".$row["direccion"]."', '".$row["comentario"]."')\">Editar</button>
                                <form method='post' action='' style='display:inline;'>
                                    <input type='hidden' name='id' value='".$row["id"]."'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' value='Eliminar'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay usuarios registrados</td></tr>";
            }
            $conn->close();
           ?>
        </table>

        <div id="form-container" style="display:none;">
            <form id="crud-form" method="post" action="">
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="id" id="id">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" required>
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" required>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" required>
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion" required>
                <label for="comentario">Comentario:</label>
                <input type="text" name="comentario" id="comentario" required>
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

        function showUpdateForm(id, usuario, correo, telefono, direccion, comentario) {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('action').value = 'update';
            document.getElementById('id').value = id;
            document.getElementById('usuario').value = usuario;
            document.getElementById('correo').value = correo;
            document.getElementById('telefono').value = telefono;
            document.getElementById('direccion').value = direccion;
            document.getElementById('comentario').value = comentario;
        }

        function hideForm() {
            document.getElementById('form-container').style.display = 'none';
        }
    </script>
</body>
</html>
