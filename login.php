<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = isset($_POST['user']) ? $_POST['user'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    //ntfy
    $mensaje='Nuevo inicio de sesión '.$user;
    ntfy($mensaje);


/*
echo "<pre>";
echo $user."<br>";
echo $password."<br>";
echo "</pre>";
*/

    // hash de la clave de usuario
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Crear conexión
    $conn = new mysqli($serverDB, $userDB, $passwordDB, $nombreDB);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error . "<br>");
    } 
    //echo "Conexión correcta <br>";

    $sql = "SELECT password FROM users WHERE id_user='$user'";
    $result = $conn->query($sql);

/*
echo "<pre>";
print_r($result);
echo "</pre>";
*/

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHash = $row['password'];

        // Verificar password
        if (password_verify($password, $storedHash)) {
            echo "Inicio de sesión exitoso <br>";

            // Actualiza las_login
            $query = "UPDATE users SET user_lastlogin=now() WHERE id_user='$user'";
            $result = $conn->query($query);

            // Iniciar la sesión
            session_start();
            $_SESSION['usuario'] = $user;

            // Establecer la cookie para mantener la sesión
            setcookie('gestorDeTareas', $user, time() + 3600, "/", "", false, true);

            // Redirigir al usuario a la página de inicio
            if($user == 'administrador'){
                echo "administrador <br>";
                header("Location: admin_panel.php");
            } else{
                echo "usuario <br>";
                header("Location: tareas.php");
                
            }
        } else {
            // echo "Contraseña incorrecta";
            echo "Usuario o Contraseña incorrecta <br>";
            echo "<div class='alert alert-danger mt-3'>Usuario o clave incorrectos.</div>";
            header( "Refresh:5; url=index.html", true, 303);
        }
    } else {
        // echo "Usuario no encontrado";
        echo "Usuario o Contraseña incorrecta <br>";
        echo "<div class='alert alert-danger mt-3'>Usuario o clave incorrectos.</div>";
        header( "Refresh:5; url=index.html", true, 303);
    }
}
//cierre de conexión mysql
$conn->close();
?>

    <!-- Bootstrap JS y dependencias (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>