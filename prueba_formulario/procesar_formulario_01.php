<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';

    // Validar los datos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        echo "Todos los campos son obligatorios.";
    } else {
        // Control de XSS: Usar htmlspecialchars() para escapar los datos del usuario
        $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
        $correo = htmlspecialchars($correo, ENT_QUOTES, 'UTF-8');
        $mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');

        // Mostrar los datos recibidos (en un caso real podrías procesarlos o guardarlos en la base de datos)
        echo "<h3>Datos recibidos:</h3>";
        echo "<p><strong>Nombre:</strong> " . $nombre . "</p>";
        echo "<p><strong>Correo:</strong> " . $correo . "</p>";
        echo "<p><strong>Mensaje:</strong><br>" . nl2br($mensaje) . "</p>";
        
        // Aquí podrías guardar los datos en la base de datos o enviarlos por correo electrónico
    }
} else {
    echo "No se recibieron datos del formulario.";
}
?>