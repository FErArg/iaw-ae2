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

// obtener datos del usuario
$sql = "SELECT id_user, email, calendar_token, user_created, user_lastlogin FROM users WHERE id_user='$usuario'";
$query_usuario = $conn->query($sql);
$usuario = array();
foreach($query_usuario as $keyUsr){
    $usuario = $keyUsr;
}
/*
echo "<pre>";
print_r($usuario);
echo "</pre>";
*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
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
            <?php
            if($usuario['id_user'] == 'administrador'){
                ?>
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
                <?php
            } else{
                ?>
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
                <?php
            }
            ?>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Perfil de Usuario</h2>
        <p class="text-muted">Actualiza tus datos personales aquí.</p>
        <p class="text-muted">Usuario creado <?php echo $usuario['user_created']; ?></p>
        <p class="text-muted">Último inicio de sesión <?php echo $usuario['user_lastlogin']; ?></p>
        
        <!-- Formulario de perfil de usuario -->
        <form action="perfil_actualizar.php" method="POST">
            <!-- Campo para el Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" maxlength="80">
                <div class="invalid-feedback">
                    Please enter a valid email address.
                </div>
            </div>
            
            <!-- Campo para el Token -->
            <div class="mb-3">
                <label for="token" class="form-label">Token de Seguridad</label>
                <input type="text" class="form-control" id="token" name="token" value="<?php echo $usuario['calendar_token']; ?>" maxlength="80">
            </div>
            
            <!-- Campo para la Clave -->
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Deja este campo vacío si no deseas cambiarla">
            </div>
            
            <!-- Botón para guardar los cambios -->
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
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
