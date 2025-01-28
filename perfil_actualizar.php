<?php
if (!isset($_COOKIE['gestorDeTareas'])) {
    // Si no existe, redirigir al usuario al formulario de inicio de sesión
    header("Location: index.html");
    exit();
}
include "config.php";
$usuario =$_COOKIE['gestorDeTareas'];
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/

if (isset($_GET['admin']) AND $_GET['admin']="yes") {
    $usuario = isset($_GET['id_user']) ? $_GET['id_user'] : '';
} else {
    $usuario = $_COOKIE['gestorDeTareas'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $email = strtolower(isset($_POST['email']) ? $_POST['email'] : '');
    $token = isset($_POST['token']) ? $_POST['token'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // conecta a mariaDB
    $conn = new mysqli($serverDB, $userDB, $passwordDB, $nombreDB);
    
    // echo "oo ".$password ." ".$email." ".$token."<br>";
    // usuario asignado nulo
    if (!empty($password)){
        //echo "P ".$password."<br>";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password='$hashedPassword' WHERE id_user='$usuario';";
        $query_actualiza_tarea = $conn->query($sql);    
    }
    if (!empty($email)){
        //echo "E ".$email."<br>";
        $sql = "UPDATE users SET email='$email' WHERE id_user='$usuario';";
        $query_actualiza_tarea = $conn->query($sql); 
    } 
    if (!empty($token)){
        //echo "T ".$token."<br>";
        $sql = "UPDATE users SET calendar_token='$token' WHERE id_user='$usuario';";
        $query_actualiza_tarea = $conn->query($sql); 
    }

    //cierre de conexión mysql
    $conn->close();
        
}

if (isset($_GET['admin']) AND $_GET['admin']="yes") {
    header( "Refresh:0; url=admin_panel.php", true, 303);
} else {
    header( "Refresh:0; url=tareas.php", true, 303);
}

?>