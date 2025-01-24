<?php
// Obtener la contraseña ingresada por el usuario
$inputPassword = 'contraseña_ingresada';

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $passwordDB, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar el hash de la contraseña almacenada en la base de datos
$sql = "SELECT password FROM usuarios WHERE usuario = 'nombre_usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Obtener el hash de la base de datos
    $row = $result->fetch_assoc();
    $storedHash = $row['password'];

    // Verificar si la contraseña ingresada es correcta
    if (password_verify($inputPassword, $storedHash)) {
        echo "Inicio de sesión exitoso";
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado";
}

$conn->close();
?>
