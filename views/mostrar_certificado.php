<?php
include "../conexion.php";
require_once '../libraries/qr/phpqrcode/qrlib.php';

$img = 'image/Univalle.svg';
$img2 = 'image/descarga.jfif';
$type = pathinfo($img, PATHINFO_EXTENSION);
$type2 = pathinfo($img2, PATHINFO_EXTENSION);
$datos = file_get_contents($img);
$datos2 = file_get_contents($img2);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($datos);
$base642 = 'data:image/' . $type2 . ';base64,' . base64_encode($datos2);

$idMatricula = $_GET['id'];
$nombreEstudiante = '';
$apellidoEstudiante = '';
$documento = '';
$numeroDocumento = '';
$curso = '';
$precio = '';
$fechaM = '';
$estado = '';

date_default_timezone_set('America/Bogota');
$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fechaActual = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

$query = mysqli_query($conection, "SELECT matricula.idMatricula, matricula.idCursoM, matricula.idEstudianteM, matricula.estado, usuarios.nombre, usuarios.apellido, usuarios.idTipoDocumento, usuarios.numeroDocumento, tipodocumento.tipoDocumento, cursos.curso, cursos.precio FROM matricula INNER JOIN usuarios ON matricula.idEstudianteM = usuarios.idUsuario JOIN cursos ON matricula.idCursoM = cursos.idCurso JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE idMatricula = $idMatricula");

$result = mysqli_num_rows($query);

if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $nombreEstudiante = $data['nombre'];
        $apellidoEstudiante = $data['apellido'];
        $documento = $data['tipoDocumento'];
        $numeroDocumento = $data['numeroDocumento'];
        $curso = $data['curso'];
        $precio = number_format($data['precio'], 2);
        $estado = $data['estado'];
    }
}

$text = 'Hace constar que '. $nombreEstudiante. ' ' . $apellidoEstudiante.' con ' .$documento. ' ' .$numeroDocumento. ' Cursó y aprobó la acción de formación ' .$curso ;

ob_start();
QRcode::png($text, NULL, QR_ECLEVEL_L, 3, 2);
$qrCodeImage = 'data:image/png;base64,' . base64_encode(ob_get_clean());

$rector = file_get_contents('image/rector.png');
$baseRector = 'data:image/png;base64,' . base64_encode($rector);

$decano = file_get_contents('image/decano.png');
$baseDecano = 'data:image/png;base64,' . base64_encode($decano);

ob_start();
?>


<html lang="es">

<head>
    <title>Certificado academica <?php echo $nombreEstudiante . ' ' . $apellidoEstudiante . ' ' . 'Curso ' . $curso ?></title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/sistema_certificado/libraries/bootstrap/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            text-transform: uppercase;
        }

        #content {
            position: flex;
            align-items: center;
            padding-bottom: -100px;

        }

        #logocentro {
            width: 30%;
            height: auto;
            opacity: 0.1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        #logo {
            width: 60px;
            height: auto;
            /* border: 1px solid #ddd; */
        }

        .tabla1 {
            width: 100%;
            /* border: 1px solid #ddd; */
        }

        .tabla2 {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            text-align: center;
            font-size: 20px;
            /* border: 1px solid #ccc; */

        }

        #texto-nombre {
            display: flex;
            text-transform: none;
            text-align: center;
            /* border: 1px solid #ccc; */
            font-size: 22px;
        }

        #curso,
        #nombrecompleto {
            font-size: 25px;
            font-weight: bold;
        }

        .firmaqr{
            text-align: center;
            vertical-align: bottom;
        }

        #firma{
            width: 200px;
            height: auto;
        }

        #fechaAbajo {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding-top: 10px;
            text-align: center;
        }
        
    </style>
</head>

<body>

    <img id="logocentro" src="<?php echo $base642 ?>" alt="">
    <div id="content">
        <table class="tabla1">
            <thead>
                <tr>
                    <th id="th-tabla1">
                        <img id="logo" src="<?php echo $base64; ?>" alt="">
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <table class="tabla2">
        <thead class="encabezado-tabla">
            <tr>
                <th id="th-tabla2">
                    <h1>Universidad del valle</h1>
                </th>
            </tr>
        </thead>
    </table>

    <div id="texto-nombre">
        <p>Hace constar que</p>
        <p id="nombrecompleto"><?php echo $nombreEstudiante . ' ' . $apellidoEstudiante ?></p>
        <p>Con <?php echo $documento . ' No. ' . $numeroDocumento ?></p>
        <p>Cursó y aprobó la acción de formación</p>
        <p id="curso"><?php echo $curso ?></p>
    </div>

    <!-- <div id="qr">
        
    </div> -->

    <table class="tabla2">
        <thead class="encabezado-tabla">
            <tr class="firmaqr">
                <th><img id="firma" src="<?php echo $baseRector; ?>" alt=""></th>
                <th><img src="<?php echo $qrCodeImage; ?>" alt=""></th>
                <th><img id="firma" src="<?php echo $baseDecano; ?>" alt=""></th>
            </tr>
            <tr class="firmaqr">
                <th>Firma del Rector</th>
                <th></th>
                <th>Firma del Decano</th>
            </tr>
        </thead>
    </table>

    <div id="fechaAbajo">
        <p><?php echo $fechaActual ?></p>
    </div>


</body>

</html>

<?php
$html = ob_get_clean();

require_once '../libraries/pdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$watermark = 'image/PAGADO.svg';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
// Establecer el tamaño del papel a 'letter' (carta) y la orientación a 'portrait' (vertical) o 'landscape' (horizontal)
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();


$dompdf->stream("Certificado", array("Attachment" => false));
?>