<?php
// Simulando una base de datos de usuarios
$usuarios = [
    'admin' => 'password123',
    'user1' => 'passuser1'
];

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

    // Verificar si las credenciales coinciden con las de la base de datos simulada
    if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $contrasena) {
        // Iniciar la sesión y guardar la cookie
        session_start();

        // Establecer la cookie para mantener la sesión
        setcookie('usuario', $usuario, time() + 3600, "/", "", false, true); // Cookie válida por 1 hora

        // Redirigir al usuario a la página de inicio
        header("Location: dashboard.php");
        exit();
    } else {
        // Si las credenciales son incorrectas, mostrar un mensaje de error
        echo "<div class='alert alert-danger mt-3'>Usuario o contraseña incorrectos.</div>";
    }
}
?>
