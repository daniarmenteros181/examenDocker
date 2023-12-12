<?php 
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

// Crear el objeto Dompdf y generar el PDF
$html = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pedazo de PDF</title>

<style>
    img {
        width: 200px;  
        height: auto;  
        border: 1px solid #000; 
    }
</style>

</head>
<body>
<h2>Ingredientes para aprobar DWES</h2>
<dl>
<h1>Pasion y riqueza</h1>
<dd>Jamón Pata Negra:</dd>
<img src="jamon.jpg"></img>

</dl>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isPhpEnabled', true);
$dompdf->set_option('chroot', __DIR__);  
$dompdf->set_paper("A4", "portrait");
$dompdf->load_html($html);
$dompdf->getOptions()->setChroot('jamon.jpg');
$dompdf->render();
$pdf_content = $dompdf->output();

// Devolver el contenido del PDF
echo $pdf_content;
?>
