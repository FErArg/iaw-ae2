<?php
// datos conexión a la base de datos
$serverDB = "localhost";
$userDB = "iaw-ae2";
$passwordDB = "iaw-ae2";
$nombreDB = "iaw-ae2";

/*ntfy 
7Ggs718HdlJ6tHD5xxomH0
*/
function ntfy($mensaje){
    file_get_contents('https://ntfy.sh/iaw-ae2', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: text/plain',
            'content' => $mensaje
        ]
    ]));
}




?>
