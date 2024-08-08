<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pixelcraft";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Insertar, actualizar o eliminar registros
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? null;
    $id = $_POST["id"] ?? null;
    $nombre_completo = $_POST["nombre_completo"] ?? null; // Corrección aquí
    $paquete_servicio = $_POST["paquete_servicio"] ?? null;
    $descripcion_necesidades = $_POST["descripcion_necesidades"] ?? null;
    $fecha_inicio = $_POST["fecha_inicio"] ?? null;
    $fecha_fin = $_POST["fecha_fin"] ?? null;
    $estado = $_POST["estado"] ?? 'Pendiente';

    if ($action == "create" && $nombre_completo && $paquete_servicio && $descripcion_necesidades && $fecha_inicio && $fecha_fin) {
        $sqlInsert = "INSERT INTO servicios (nombre_completo, paquete_servicio, descripcion_necesidades, fecha_inicio, fecha_fin, estado) 
                      VALUES ('$nombre_completo', '$paquete_servicio', '$descripcion_necesidades', '$fecha_inicio', '$fecha_fin', '$estado')";
        $conn->query($sqlInsert);
    } elseif ($action == "update" && $id) {
        $sqlUpdate = "UPDATE servicios 
                      SET nombre_completo='$nombre_completo', paquete_servicio='$paquete_servicio', descripcion_necesidades='$descripcion_necesidades',
                          fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', estado='$estado'
                      WHERE id='$id'";
        $conn->query($sqlUpdate);
    } elseif ($action == "delete" && $id) {
        $sqlDelete = "DELETE FROM servicios WHERE id='$id'";
        $conn->query($sqlDelete);
    }

    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

$sql = "SELECT * FROM servicios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - PixelCraft</title>
    <link rel="stylesheet" href="php2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <a href="../php/administrador.php">Citas registradas</a>
        <a href="#servicios">Clientes registrados</a>
        <a href="#configuracion">Historial</a>       
    </div>
    <div class="content">
        <h2 id="clientes">Registro de Clientes</h2>
        <button onclick="showCreateForm()">Añadir Cliente</button>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Detalles del Servicio</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $estadoClass = '';
                    switch ($row["estado"]) {
                        case 'Pendiente':
                            $estadoClass = 'estado-pendiente';
                            break;
                        case 'En Progreso':
                            $estadoClass = 'estado-en-progreso';
                            break;
                        case 'Completado':
                            $estadoClass = 'estado-completado';
                            break;
                    }
                    echo "<tr class='$estadoClass'>
                            <td>". $row["id"]. "</td>
                            <td>". $row["nombre_completo"]. "</td>
                            <td><strong>Paquete:</strong> ". $row["paquete_servicio"] . "<br>
                                <strong>Descripción:</strong> ". $row["descripcion_necesidades"] . "</td>
                            <td>". $row["fecha_inicio"]. "</td>
                            <td>". $row["fecha_fin"]. "</td>
                            <td>". $row["estado"]. "</td>
                            <td>
                                <button onclick=\"showUpdateForm('".$row["id"]."', '".$row["nombre_completo"]."', '".$row["paquete_servicio"]."', '".$row["descripcion_necesidades"]."', '".$row["fecha_inicio"]."', '".$row["fecha_fin"]."', '".$row["estado"]."')\">Editar</button>
                                <form method='post' action='' style='display:inline;'>
                                    <input type='hidden' name='id' value='".$row["id"]."'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='submit' value='Eliminar'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay clientes registrados</td></tr>";
            }
            ?>
        </table>

        <div id="form-container" style="display:none;">
            <form id="crud-form" method="post" action="">
                <input type="hidden" name="action" id="action">
                <input type="hidden" name="id" id="id">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" name="nombre_completo" id="nombre_completo" required>
                <label for="paquete_servicio">Paquete de Servicio:</label>
                <select name="paquete_servicio" id="paquete_servicio" required>
                    <option value="Paquete Básico">Paquete Básico</option>
                    <option value="Paquete Intermedio">Paquete Intermedio</option>
                    <option value="Paquete Avanzado">Paquete Avanzado</option>
                    <option value="Paquete Personalizado">Paquete Personalizado</option>
                </select>
                <label for="descripcion_necesidades">Descripción de Necesidades:</label>
                <textarea name="descripcion_necesidades" id="descripcion_necesidades" required></textarea>
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" required>
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" required>
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="En Progreso">En Progreso</option>
                    <option value="Completado">Completado</option>
                </select>
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

        function showUpdateForm(id, nombre_completo, paquete_servicio, descripcion_necesidades, fecha_inicio, fecha_fin, estado) {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('action').value = 'update';
            document.getElementById('id').value = id;
            document.getElementById('nombre_completo').value = nombre_completo;
            document.getElementById('paquete_servicio').value = paquete_servicio;
            document.getElementById('descripcion_necesidades').value = descripcion_necesidades;
            document.getElementById('fecha_inicio').value = fecha_inicio;
            document.getElementById('fecha_fin').value = fecha_fin;
            document.getElementById('estado').value = estado;
        }

        function hideForm() {
            document.getElementById('form-container').style.display = 'none';
        }
    </script>
</body>
</html>
