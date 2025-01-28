<?php
if (!isset($_COOKIE['gestorDeTareas'])) {
    // Si no existe, redirigir al usuario al formulario de inicio de sesión
    header("Location: index.html");
    exit();
}
include "config.php";
$usuario =$_COOKIE['gestorDeTareas'];

// conecta a mariaDB
$conn = new mysqli($serverDB, $userDB, $passwordDB, $nombreDB);

// obtener listado de usuarios
$sql = "SELECT id_user, email, user_lastlogin FROM users WHERE id_user!='$usuario' ORDER BY id_user ASC";
$query_usuarios = $conn->query($sql);

$usuarios = array();
$i=0;
foreach($query_usuarios as $keyUsr){
    $usuarios[$i] = $keyUsr;
    $i++;
}
/*
echo "<pre>";
foreach($usuarios as $usuario){
    print_r($usuario);
}
echo "</pre>";
*/

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <!-- Vincular Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <!-- Encabezado -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo y nombre de la aplicación -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://i.ibb.co/34J6CLv/1028163.png" alt="Logo" width="30" height="30" class="d-inline-block align-top me-2">
                <span>Aplicación de Tareas</span>
            </a>

            <!-- Botón para colapsar el menú en pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_panel.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_nuevo.php">Crear Usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Listado de Usuarios</h2>
        <p class="text-muted">Selecciona un usuario para modificar sus datos.</p>
        
        <!-- Tabla de usuarios -->
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Último inicio sesión</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplo de usuarios -->
                <?php
                foreach($usuarios as $usuario){
                    //print_r($usuario);
                    echo '<tr>';
                    echo '<td>'.$usuario['id_user'].'</td>';
                    echo '<td>'.$usuario['id_user'].'</td>';
                    echo '<td>'.$usuario['email'].'</td>';
                    echo '<td>'.$usuario['user_lastlogin'].'</td>';
                    echo '<td>';
                    echo '    <a href="admin_perfil.php?admin=yes&id_user='.$usuario['id_user'].'" class="btn btn-warning btn-sm">Editar</a>';
                    echo '</td>';
                echo '</tr>';
                }
                ?>
<!--
                <tr>
                    <td>1</td>
                    <td>Juan Pérez</td>
                    <td>juan.perez@example.com</td>
                    <td>Administrador</td>
                    <td>
                        <a href="editar_usuario.php?id=1" class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
-->
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-1">
                &copy; <span id="currentYear"></span> | 
                <a href="https://www.gnu.org/licenses/gpl-3.0.html" class="text-info text-decoration-none" target="_blank">
                    Licencia GPLv3
                </a>
            </p>
            <p class="mb-0">
                Diseñado por <span class="fw-bold">FARM</span> | 
                <span class="text-warning">Módulo: IAW - AE2</span>
            </p>
        </div>
    </footer>

    <!-- Vincular scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    
    <!-- Script para mostrar el año actual -->
    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>
</html>
<?php
//cierre de conexión mysql
$conn->close();
?>
