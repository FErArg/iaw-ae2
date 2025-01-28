<?php
if (!isset($_COOKIE['gestorDeTareas'])) {
    // Si no existe, redirigir al usuario al formulario de inicio de sesión
    header("Location: index.html");
    exit();
}
include "config.php";
$usuario =$_COOKIE['gestorDeTareas'];

//ntfy
$mensaje=$usuario.' - Creación de nuevo usuario';
ntfy($mensaje);

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
        <h2 class="mb-4">Nuevo de Usuario</h2>
        <form action="nuevo_usuario.php?nuevo=yes" method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="token" class="form-label">Token</label>
                <input type="text" class="form-control" id="token" name="token" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" class="form-control" id="password" name="clave" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
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
