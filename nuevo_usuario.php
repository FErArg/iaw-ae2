<?php
if (!isset($_COOKIE['gestorDeTareas'])) {
    // Si no existe, redirigir al usuario al formulario de inicio de sesión
    header("Location: index.html");
    exit();
}
include "config.php";
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/
if (isset($_GET['nuevo']) AND $_GET['nuevo']="yes") {
    $usuario=strtolower(isset($_POST['usuario']) ? $_POST['usuario'] : '');
    $email = strtolower(isset($_POST['email']) ? $_POST['email'] : '');
    $token = isset($_POST['token']) ? $_POST['token'] : '';
    $password = isset($_POST['clave']) ? $_POST['clave'] : '';

    // Control de XSS: Escapar caracteres especiales
    $usuario = htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $token = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');

    // hash de la clave de usuario
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Crear conexión
    $conn = new mysqli($serverDB, $userDB, $passwordDB, $nombreDB);

    $sql = "INSERT INTO users (id_user,password,email,calendar_token,user_created) VALUES ('$usuario','$hashedPassword','$email','$token',now());";
    $result = $conn->query($sql);

}

//cierre de conexión mysql
$conn->close();
header( "Refresh:0; url=admin_panel.php", true, 303);
?>