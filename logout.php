<?php
// Iniciar sesión para asegurar que la cookie esté bien configurada
session_start();

// Eliminar la cookie que mantiene al usuario autenticado
setcookie('gestorDeTareas', '', time() - 3600, "/", "", false, true); // Expiramos la cookie

// Destruir la sesión actual
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirigir al usuario a la página de inicio de sesión
header("Location: index.html");
exit();
?>
