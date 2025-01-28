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
echo "u ".$user."<br>";
echo "u ".$usuario."<br>";
echo "</pre>";
*/

// conecta a mariaDB
$conn = new mysqli($serverDB, $userDB, $passwordDB, $nombreDB);

// elimina task
if (isset($_GET['eliminar']) AND $_GET['eliminar']="yes") {
    $id_task=$_GET['id'];
    $sql = "DELETE FROM tasks WHERE id_task='$id_task'";
    $query_elimina_tarea = $conn->query($sql);    
}

// compartir task
// editar=yes&id=
if (isset($_GET['compartir']) AND $_GET['compartir']="yes") {
    $id_task=$_GET['id'];
    $sql = "SELECT * FROM tasks WHERE id_task='$id_task'";
    $query_compartir_tarea = $conn->query($sql);
    $tareaComp = array();
    $i=0;
    foreach( $query_compartir_tarea as $keyTC){
        $tareaComp = $keyTC;
    }
    /*
    echo "<pre>";
    print_r($tareaComp);
    echo "</pre>";
    */
    // buscar token ZOHO
    $sql = "SELECT calendar_token FROM users WHERE id_user='$usuario'";
    $query_usuario_token = $conn->query($sql);
    $usuarioToken = array();
    $i=0;
    foreach( $query_usuario_token as $keyUT){
        $usuarioToken = $keyUT;
    }
    echo '<div class="alert alert-info mt-3">Tarea <span class="font-weight-bold text-md-left">" '. $tareaComp['title'] .' "</span> Compartida.</div>';
    
    /* Código ZOHO para publicar tareas mediante API
    // Replace these with your actual values
    $clientId = 'YOUR_CLIENT_ID';
    $clientSecret = 'YOUR_CLIENT_SECRET';
    $refreshToken = 'YOUR_REFRESH_TOKEN';
    $accessToken = 'YOUR_ACCESS_TOKEN';

    // Function to refresh the access token
    function refreshAccessToken($clientId, $clientSecret, $refreshToken) {
        $url = "https://accounts.zoho.com/oauth/v2/token";
        $data = [
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'refresh_token'
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            die('Error refreshing access token');
        }

        $response = json_decode($result, true);
        return $response['access_token'];
    }

    // Refresh the access token if needed
    $accessToken = refreshAccessToken($clientId, $clientSecret, $refreshToken);

    // API endpoint to create a task
    $url = "https://calendar.zoho.com/api/v1/tasks";

    // Task data
    $taskData = [
        'title' => 'New Task',
        'description' => 'This is a new task created via API',
        'startDate' => '2023-10-01',
        'endDate' => '2023-10-02',
        'priority' => 'high',
        'status' => 'notstarted'
    ];

    // Headers
    $headers = [
        'Authorization: Zoho-oauthtoken ' . $accessToken,
        'Content-Type: application/json'
    ];

    // cURL request to create the task
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($taskData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    // Handle the response
    if ($response === FALSE) {
        die('Error creating task');
    }

    $responseData = json_decode($response, true);
    print_r($responseData);
    */

}

// Obtener todos los usuarios para el "usuario asignado"
$sql = "SELECT id_user FROM users";
$query_usuarios = $conn->query($sql);
$usuarios = array();
$i=0;
foreach( $query_usuarios as $key => $value){
    $usuarios[$i] = $value['id_user'];
    $i++;
}

//print_r($usuarios);

// obtener listado de tareas del usuario
$sql = "SELECT id_task, id_owner, title, description, date_created, date_modified, date_finished, status FROM tasks WHERE id_creator='$usuario' OR id_owner='$usuario' ORDER BY date_created DESC LIMIT 3";
$query_tareas = $conn->query($sql);

?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Tareas</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo y nombre de la aplicación -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://i.ibb.co/34J6CLv/1028163.png" alt="Logo" width="30" height="30" class="d-inline-block align-top me-2">
                <span>Aplicación de Tareas</span>
            </a>

            <!-- Botón para colapsar el menú en pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="tareas.php">Crear Tarea</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_tareas.php">Mis Tareas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


        <div class="container mt-4">
            <div class="row">
                <!-- Columna de formulario -->
                <div class="col-md-6">
                <?php
                    if (isset($_GET['editar']) AND $_GET['editar']="yes") {
                        // echo "ELILALALALL<br>";
                        $id_task=$_GET['id'];
                        $sql = "SELECT * FROM tasks WHERE id_task='$id_task'";
                        $query_tarea = $conn->query($sql);
                        $tarea = array();
                        // echo "<pre>";
                        // print_r($query_tarea);
                        foreach($query_tarea as $keyTar){
                            //print_r($key);
                            $tarea = $keyTar;
                        }
                        /*
                        print_r($tarea);
                        echo "TTT".$tarea['title']."<br>";
                        */
                        ?>
                        <h3>Tarea a Editar</h3>
                        <form action="tareas_guardar.php?actualizar=yes" method="POST">
                        <input type="text" id="id_task" name="id_task" value="<?php echo $id_task;?>" style="display:none;">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"  maxlength="100" value="<?php echo $tarea['title']; ?>"required>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $tarea['description']; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <?php
                                    if($tarea['status'] == 'pendiente'){
                                        echo '"<option value="pendiente" selected>Pendiente</option>"';
                                        echo '"<option value="completada">Completada</option>"';
                                    } else{
                                        echo '"<option value="pendiente">Pendiente</option>"';
                                        echo '"<option value="completada" selected>Completada</option>"';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <?php
                                $datetime = $tarea['date_finished'];
                                $getOnlyDate = date('Y-m-d',strtotime($datetime));
                                ?>
                                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $getOnlyDate; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="creador" class="form-label">Creador</label>
                                <input type="text" class="form-control" id="creador" name="creador" value="<?php echo ucfirst($usuario); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="usuario_asignado" class="form-label">Usuario Asignado</label>
                                <select class="form-select" id="usuario_asignado" name="usuario_asignado" required>
                                    <option value="sin_usuario_asignado">----</option>
                                    <?php 
                                    foreach( $usuarios as $keyUs => $valueUs){
                                        if($tarea['id_owner'] == $valueUs){
                                            echo '<option value="'.$valueUs.'" selected>'.ucfirst($valueUs).'</option>';
                                        } else {
                                            echo '<option value="'.$valueUs.'">'.ucfirst($valueUs).'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                        </form>
                        <?php
                    } else{
                        ?>
                        <h3>Nueva de Tarea</h3>
                        <form action="tareas_guardar.php" method="POST">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"  maxlength="100" required>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="completada">Completada</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                            </div>

                            <div class="mb-3">
                                <label for="creador" class="form-label">Creador</label>
                                <input type="text" class="form-control" id="creador" name="creador" value="<?php echo ucfirst($usuario); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="usuario_asignado" class="form-label">Usuario Asignado</label>
                                <select class="form-select" id="usuario_asignado" name="usuario_asignado" required>
                                    <option value="sin_usuario_asignado">----</option>
                                    <?php 
                                    foreach( $usuarios as $key => $value){
                                        // echo '<option value="'.$key.'" id="'.$value.'">'.$value.'</option>';
                                        echo '<option value="'.$value.'">'.ucfirst($value).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                        </form>
                        <?php
                    }
                ?>
                </div>

                <!-- Columna de tareas -->
                <div class="col-md-6">
                    <h3>Listado de Tareas</h3>
                    <!-- Simulación de tareas dinámicas desde la base de datos -->
                    <?php
                    foreach( $query_tareas as $tarea){
                        // echo $tarea['id_owner'] ."<br>";
                        echo '<div class="card mb-3">';
                        echo '    <div class="card-body">';
                        echo '        <h5 class="card-title">'.ucfirst($tarea['title']).'</h5>';
                        echo '        <p class="card-text"><strong>Fecha de Creación:</strong> '.$tarea['date_created'].'</p>';
                        echo '        <p class="card-text"><strong>Fecha de Finalización:</strong> '.$tarea['date_finished'].'</p>';
                        echo '        <p class="card-text"><strong>Última Modificación:</strong> '.$tarea['date_modified'].'</p>';
                        if(empty($tarea['id_owner']) OR $tarea['id_owner'] == 'NULL'){
                            echo '        <p class="card-text"><strong>Usuario Asignado:</strong> Sin Usuario</p>';
                        } else {
                            echo '        <p class="card-text"><strong>Usuario Asignado:</strong> '.ucfirst($tarea['id_owner']).'</p>';
                        }
                        echo '        <p class="card-text"><strong>Resumen:</strong> '. mb_strimwidth($tarea['description'], 0, 120, " .....") .'</p>';
                        if ($tarea['status']=='pendiente'){
                            echo '        <span class="badge bg-warning">'.ucfirst($tarea['status']).'</span>';
                        }else {
                            echo '        <span class="badge bg-success">'.ucfirst($tarea['status']).'</span>';
                        }
                        echo '<p></p>';
                        echo '        <a href="tareas.php?editar=yes&id='.$tarea['id_task'].'" class="btn btn-warning btn-sm">Editar</a>';
                        echo '        <a href="tareas.php?eliminar=yes&id='.$tarea['id_task'].'" class="btn btn-danger btn-sm">Eliminar</a>';
                        echo '        <a href="tareas.php?compartir=yes&id='.$tarea['id_task'].'" class="btn btn-info">Compartir</a>';
                        echo '    </div>';
                        echo '</div>';
                    }
                    ?>
                    <!--              --------------------------              -->
                </div>
            </div>
        </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-1">
                &copy; <span id="currentYear"></span> | 
                <a href="https://www.gnu.org/licenses/gpl-3.0.html" class="text-info text-decoration-none" target="_blank">
                    Licencia GPLv3
                </a>
            </p>
            <p class="mb-0">
                Diseñado por <span class="fw-bold">FARM</span> | 
                <span class="text-warning">Módulo: IAW - AE2</span>
            </p>
        </div>
    </footer>

    <!-- Vincular scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    
    <!-- Script para mostrar el año actual -->
    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
    </body>
    </html>
<?php
//cierre de conexión mysql
$conn->close();
?>
