<?php
require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    $pdo = new PDO("mysql:host=datos;dbname=cesta", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //  nombre del formulario
    $nombre = $_POST['nombre'];

    //  nombre está presente
    if (!empty($nombre)) {
        //  nombre está en la base de datos
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM regalo WHERE nombre = :nombre");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // El nombre está en la base de datos
            // Continuar con el resto del código

            // Usar Guzzle para hacer una solicitud interna a 'envioPdf'
            $client = new Client();
            $response = $client->request('GET', 'http://envioPdf');


            $contenido = $response->getBody();

        // Crear el objeto PHPMailer y enviar el correo con el PDF adjunto
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587;
        $mail->Username   = "darmace2311@g.educaand.es";
        $mail->Password   = "qyqg hzoo fbxs wexp";
        $mail->SetFrom('darmace2311@g.educaand.es', 'Test');
        $mail->Subject    = "SIIII";
        $mail->MsgHTML('Prueba');
        $mail->addStringAttachment($contenido, 'HeavenTicket.pdf', 'base64', 'application/pdf');
        $address = "daniarmenteros18@gmail.com";
        $mail->AddAddress($address, "Test");

        // Enviar el correo y manejar errores
        try {
            $resul = $mail->Send();
            if (!$resul) {
                echo "Error: " . $mail->ErrorInfo;
            } else {
                echo "Enviado";
            }
        } catch (Exception $e) {
            echo "Excepción al enviar el correo: " . $e->getMessage();
        }
            
            

        } else {
            echo "El nombre no existe en la base de datos.";
        }
    } else {
        echo "Por favor, ingresa un nombre válido.";
    }
} else {
    echo "Acceso no permitido.";
}
?>
?>
