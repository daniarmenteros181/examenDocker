<?php
use GuzzleHttp\Client;

require_once "vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el nombre del formulario
    $nombre = $_POST['nombre'];

    // Validar si el nombre está presente
    if (!empty($nombre)) {
        // Usar Guzzle para hacer una solicitud a 'cartero' con el nombre
        $client = new Client();
        $data = ['form_params' => ['nombre' => $nombre]];

        try {
            $response = $client->request('POST', 'http://cartero', $data);

            // Verificar si la solicitud fue exitosa 
            if ($response->getStatusCode() === 200) {
                $contenido = $response->getBody();
                echo "Operación en cartero completada. Respuesta: " . $contenido;
            } else {
                echo "Error en la solicitud Guzzle a cartero. Código de estado: " . $response->getStatusCode();
            }
        } catch (Exception $e) {
            echo "Excepción al hacer la solicitud Guzzle a cartero: " . $e->getMessage();
        }
    } else {
        echo "Por favor, ingresa un nombre válido.";
    }
} else {
    echo "Acceso no permitido.";
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <h1>Formulario</h1>
    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
