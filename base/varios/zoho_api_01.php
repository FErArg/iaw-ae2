<?php

// URL de la API de Zoho Calendar
$url = "https://calendar.zoho.com/api/restapi/";

// El token de acceso OAuth (asegúrate de tenerlo válido)
$access_token = "YOUR_ACCESS_TOKEN";

// Los datos del evento
$event_data = [
    "data" => [
        "event" => [
            "subject" => "Nueva tarea",
            "start_time" => "2025-01-25T09:00:00",
            "end_time" => "2025-01-25T10:00:00",
            "description" => "Descripción de la tarea",
            "location" => "Oficina",
            "event_type" => "EVENT",
            "visibility" => "PUBLIC"
        ]
    ]
];

// Convertir los datos a formato JSON
$json_data = json_encode($event_data);

// Crear un recurso cURL para enviar la solicitud POST
$ch = curl_init($url);

// Establecer las opciones cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Zoho-oauthtoken $access_token",
    "Content-Type: application/json"
]);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Verificar si hay errores
if(curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Si la solicitud fue exitosa, mostrar la respuesta
    echo "Respuesta de Zoho: " . $response;
}

// Cerrar la sesión cURL
curl_close($ch);

?>
