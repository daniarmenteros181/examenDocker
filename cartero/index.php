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
    // Obtener el nombre del formulario
    $nombre = $_POST['nombre'];

    // Validar si el nombre está presente
    if (!empty($nombre)) {
        // Verificar si el nombre está en la base de datos
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM regalo WHERE nombre = :nombre");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $client = new Client();
            $response = $client->request('GET', 'http://envioPdf');

            $contenido = $response->getBody();

            // Crear el objeto PHPMailer
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

            // correo electrónico según el nombre
            $direccionCorreo = "";
            switch ($nombre) {
                case 'dani':
                    $direccionCorreo = "daniarmenteros18@gmail.com";
                    break;
                case 'manolo':
                    $direccionCorreo = "jve@ieslasfuentezuelas.com";
                    break;
            }

            // Agregar la dirección de correo al destinatario
            $mail->AddAddress($direccionCorreo, "Test");

            // Enviar el correo 
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

