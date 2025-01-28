<?php
// Suponiendo que $password es la contraseña ingresada por el usuario
$password = 'contraseña_secreta';

// Encriptar la contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Conectar a la base de datos
$servername = "localhost";
$username = "usuario";
$passwordDB = "contraseña_base_datos";
$dbname = "mi_base_de_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $passwordDB, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Insertar la contraseña encriptada en la base de datos
$sql = "INSERT INTO usuarios (usuario, password) VALUES ('nombre_usuario', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
