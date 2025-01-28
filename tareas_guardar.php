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

// actualizar tareas
if (isset($_GET['actualizar']) AND $_GET['actualizar']="yes") {
    $id_task=isset($_POST['id_task']) ? $_POST['id_task'] : '';
    $titulo = strtolower(isset($_POST['titulo']) ? $_POST['titulo'] : '');
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $estado = strtolower(isset($_POST['estado']) ? $_POST['estado'] : '');
    $fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : '';
    $creador = strtolower(isset($_POST['creador']) ? $_POST['creador'] : '');
    $usuario_asignado = strtolower(isset($_POST['usuario_asignado']) ? $_POST['usuario_asignado'] : '');

    // Control de XSS: Escapar caracteres especiales
    $titulo = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
    $fecha_vencimiento = htmlspecialchars($fecha_vencimiento, ENT_QUOTES, 'UTF-8');

    // conecta a mariaDB
    $conn = new mysqli($serverDB, $userDB, $passwordDB, $nombreDB);

    $sql = "UPDATE tasks SET id_owner='$usuario_asignado', title='$titulo', description='$descripcion', date_modified=now(), status='$estado', date_finished='$fecha_vencimiento' WHERE id_task='$id_task';";
    $query_actualiza_tarea = $conn->query($sql);    

    //cierre de conexión mysql
    $conn->close();
    header( "Refresh:0; url=tareas.php", true, 303);
} else {
    // nuevas tareas
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recibir los datos del formulario
        $titulo = strtolower(isset($_POST['titulo']) ? $_POST['titulo'] : '');
        $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
        $estado = strtolower(isset($_POST['estado']) ? $_POST['estado'] : '');
        $fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : '';
        $creador = strtolower(isset($_POST['creador']) ? $_POST['creador'] : '');
        $usuario_asignado = strtolower(isset($_POST['usuario_asignado']) ? $_POST['usuario_asignado'] : '');

        if (empty($titulo) || empty($descripcion) || empty($fecha_vencimiento)) {
            echo "Todos campos son obligatorios.";
        } else {
            // Control de XSS: Escapar caracteres especiales
            $titulo = htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
            $fecha_vencimiento = htmlspecialchars($fecha_vencimiento, ENT_QUOTES, 'UTF-8');

            // conecta a mariaDB
            $conn = new mysqli($serverDB, $userDB, $passwordDB, $nombreDB);

            // usuario asignado nulo
            if( $usuario_asignado == 'sin_usuario_asignado'){
                $nueva_tarea = "INSERT INTO tasks (id_creator, id_owner, title, description, status, date_finished) VALUES ('$creador', NULL, '$titulo', '$descripcion', '$estado', '$fecha_vencimiento')";
            } else{
                $nueva_tarea = "INSERT INTO tasks (id_creator, id_owner, title, description, status, date_finished) VALUES ('$creador', '$usuario_asignado', '$titulo', '$descripcion', '$estado', '$fecha_vencimiento')";
            }
            // Inseta tarea en DB
            $result = $conn->query($nueva_tarea);
        }
        //cierre de conexión mysql
        $conn->close();
        header( "Refresh:0; url=tareas.php", true, 303);
    }

}




?>