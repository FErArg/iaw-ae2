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

// obtener listado de tareas del usuario
$sql = "SELECT id_task, id_owner, title, description, date_created, date_modified, date_finished, status FROM tasks WHERE id_creator='$usuario' OR id_owner='$usuario' ORDER BY date_created ASC";
$query_tareas = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tareas</title>
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
                        <a class="nav-link" href="tareas.php">Crear Tarea</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_tareas.php">Mis Tareas</a>
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
        <h2 class="mb-4">Listado de Tareas</h2>
        
        <!-- Tabla de tareas -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Título</th>
                    <!-- <th scope="col">Descripción</th> -->
                    <th scope="col">Fecha de Creación</th>
                    <th scope="col">Fecha de Modificación</th>
                    <th scope="col">Fecha de Finalización</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí va el listado de tareas generado desde PHP -->
                <?php
                foreach( $query_tareas as $tarea){
                    echo '<tr>';
                    echo '    <td>'.$tarea['id_task'].'</td>';
                    echo '    <td>'.$tarea['title'].'</td>';
                    // echo '    <td>'.mb_strimwidth($tarea['description'], 0, 120, " .....").'</td>';
                    echo '    <td>'.$tarea['date_created'].'</td>';
                    echo '    <td>'.$tarea['date_modified'].'</td>';
                    echo '    <td>'.$tarea['date_finished'].'</td>';
                    if ($tarea['status']=='pendiente'){
                        echo '        <td><span class="badge bg-warning">'.ucfirst($tarea['status']).'</span></td>';
                    }else {
                        echo '        <td><span class="badge bg-success">'.ucfirst($tarea['status']).'</span></td>';
                    }
                    echo '    <td>';
                    echo '        <a href="tareas.php?editar=yes&id='.$tarea['id_task'].'" class="btn btn-warning btn-sm">Editar</a>';
                    echo '        <a href="tareas.php?eliminar=yes&id='.$tarea['id_task'].'" class="btn btn-danger btn-sm">Eliminar</a>';
                    echo '    </td>';
                    echo '</tr>';
                }
                ?>
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
