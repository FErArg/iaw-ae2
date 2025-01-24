<?php
// Configuración de la base de datos
$host = 'localhost'; // Host de la base de datos
$dbname = 'tareas_app'; // Nombre de la base de datos
$username = 'root'; // Usuario de la base de datos (ajusta según tu configuración)
$password = ''; // Contraseña de la base de datos (ajusta según tu configuración)

try {
    // Establecer la conexión usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error para manejar excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si los datos fueron enviados por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir los datos del formulario
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
        $mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';

        // Validar que los campos no estén vacíos
        if (empty($nombre) || empty($correo) || empty($mensaje)) {
            echo "Todos los campos son obligatorios.";
        } else {
            // Control de XSS: Escapar caracteres especiales
            $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            $correo = htmlspecialchars($correo, ENT_QUOTES, 'UTF-8');
            $mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');

            // Validar el formato del correo
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                echo "El correo electrónico no es válido.";
            } else {
                // Consulta preparada para insertar los datos en la base de datos
                $sql = "INSERT INTO usuarios (nombre, correo, mensaje) VALUES (:nombre, :correo, :mensaje)";

                // Preparar la consulta
                $stmt = $pdo->prepare($sql);

                // Vincular los parámetros a los valores
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':mensaje', $mensaje);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "Datos enviados y almacenados correctamente.";
                } else {
                    echo "Hubo un error al guardar los datos.";
                }
            }
        }
    }
} catch (PDOException $e) {
    // Si hay un error en la conexión a la base de datos, mostrarlo
    echo "Error de conexión a la base de datos: " . $e->getMessage();
}
?>
