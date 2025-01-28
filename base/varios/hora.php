<?php
// Fecha y hora en UTC
$utc_date = '2025-01-25 09:00:00';

// Crear un objeto DateTime a partir de la fecha UTC
$date = new DateTime($utc_date, new DateTimeZone('UTC'));

// Convertir a la zona horaria local (si es necesario, de lo contrario se puede omitir)
$date->setTimezone(new DateTimeZone('America/New_York')); // Cambia la zona horaria si es necesario

// Formatear la fecha al formato deseado
$formatted_date = $date->format('Y-m-d\TH:i:s');

// Mostrar la fecha en el formato YYYY-MM-DDTHH:MM:SS
echo $formatted_date;
?>