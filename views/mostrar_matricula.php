<?php

include "../conexion.php";
include "../c2.php";

$img = 'image/Univalle.svg';
$type = pathinfo($img, PATHINFO_EXTENSION);
$datos = file_get_contents($img);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($datos);


$idMatricula = $_GET['id'];
$nombreEstudiante = '';
$apellidoEstudiante = '';
$documento = '';
$numeroDocumento = '';
$curso = '';
$precio = '';
$fechaM = '';
$estado = '';
$descuento = 0;
$total = 0;


date_default_timezone_set('America/Bogota');
$fechaActual = date('m/d/Y');
$numDias = 1;

$query = mysqli_query($conection, "SELECT matricula.idMatricula, matricula.idCursoM, matricula.idEstudianteM, matricula.estado, matricula.fecha, usuarios.nombre, usuarios.apellido, usuarios.idTipoDocumento, usuarios.numeroDocumento, tipodocumento.tipoDocumento, cursos.curso, cursos.precio FROM matricula INNER JOIN usuarios ON matricula.idEstudianteM = usuarios.idUsuario JOIN cursos ON matricula.idCursoM = cursos.idCurso JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE idMatricula = $idMatricula");

$result = mysqli_num_rows($query);

if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $nombreEstudiante = $data['nombre'];
        $apellidoEstudiante = $data['apellido'];
        $documento = $data['tipoDocumento'];
        $numeroDocumento = $data['numeroDocumento'];
        $curso = $data['curso'];
        $precio = $data['precio'];
        $estado = $data['estado'];
        $fechaM = $data['fecha'];
    }

    $query_descuento = mysqli_query($c2, "SELECT numeroDescuento AS descuento FROM descuentos WHERE estado = 'No canjeado' AND numeroDocumento LIKE '$numeroDocumento'");
	$result_descuento = mysqli_num_rows($query_descuento);
    if ($result_descuento > 0) {
        $info_descuento = mysqli_fetch_assoc($query_descuento);
        $numero_descuento = $info_descuento['descuento'];

        
    } else {
        $numero_descuento = 0;
    }

}

if($estado == 1){
    $fechaActual = $fechaM;
}
$fechaDespues = date('d/m/Y', strtotime($fechaActual . ' + ' . $numDias . ' days'));
ob_start();
?>


<html lang="es">

<head>
    <title>Matricula academica <?php echo $nombreEstudiante . ' ' . $apellidoEstudiante . ' ' . 'Curso ' . $curso ?></title>
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
            border: 1px solid #ccc;
            padding-bottom: -100px;
        }

        #logo {
            width: 45px;
            height: auto;
            margin-left: 10px;
            margin-right: 10px;
        }

        #textoDerechaLogo {
            margin-left: 10px;
            text-align: left;
            font-size: 12px;
            font-weight: normal;
        }

        #th-tabla1 {
            padding: 8px;
            text-align: center;
            font-size: 12px;
            font-weight: normal;
        }

        th[colspan="4"] {
            width: 300px;
        }

        th[colspan="3"] {
            width: 100px;
        }

        .numero {
            border: 1px solid #ddd;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 15px;
        }

        .tabla2 {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;

        }

        #th-tabla2 {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th[colspan="2"] {
            width: 250px;
        }

        #texto-nombre {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 12px;
        }

        #tabla3 {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        #th-tabla3 {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        tbody tr td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        td[colspan="1"] {
            width: 50px;
        }

        #texto-soporte {
            text-transform: none;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div id="content">
        <table class="tabla1">
            <thead>
                <tr>
                    <th id="th-tabla1">
                        <img id="logo" src="<?php echo $base64; ?>" alt="">
                    </th>
                    <th id="textoDerechaLogo" colspan="4">
                        <p><strong>Universidad del Valle</strong></p>
                        <p><strong>NIT 890-399-010-6</strong></p>
                        <p>División Financiera</p>
                    </th>
                    <th id="th-tabla1">
                        Desprendible para pago N.°
                    </th>
                    <th id="th-tabla1" colspan="3">
                        <p class="numero"><?php echo $idMatricula ?></p>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <table class="tabla2">
        <thead class="encabezado-tabla">
            <tr>
                <th id="th-tabla2" colspan="2">Banco: BOGOTÁ</th>
                <th id="th-tabla2">Fecha límite de pago: <?php echo $fechaDespues ?></th>
            </tr>
        </thead>
    </table>

    <div id="texto-nombre">
        <p><strong>Nombre completo: </strong><?php echo $nombreEstudiante . ' ' . $apellidoEstudiante ?></p>
        <p><strong>Tipo de documento: </strong> <?php echo $documento ?></p>
        <p><strong>Número del documento: </strong><?php echo $numeroDocumento ?></p>
    </div>

    <table id="tabla3">
        <thead>
            <tr>
                <th colspan="2" id="th-tabla3">Concepto</th>
                <th id="th-tabla3">Valor</th>
            </tr>
        </thead>
        <tbody id="td-table3">
            <tr id="td-table3">
                <td id="td-table3" colspan="2">Matricula academica del curso <?php echo $curso ?></td>
                <td id="td-table3"><?php echo  number_format($precio, 2); ?></td>
            </tr>
            <tr id="td-table3">
                <td id="td-table3" colspan="2">Descuento</td>
                <td id="td-table3"><?php echo $numero_descuento .'%'; ?></td>
            </tr>
            <tr>
                <td>
                    <p id="texto-soporte">Soporte de pago valido exclusivamente para pagos en efectivo, con cheques de gerencia en las sucursales bancarias autorizadas</p>
                </td>
                <td colspan="1">total</td>
                <?php  
                $descuento = $precio * ($numero_descuento / 100);
                $total = $precio - $descuento;
                ?>
                <td><?php echo  number_format($total, 2) ?></td>
            </tr>
        </tbody>
    </table>


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
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();

if ($estado == 1) {
    $canvas = $dompdf->getCanvas();

    $pageWidth = $canvas->get_width();
    $pageHeight = $canvas->get_height();

    // Ajusta el tamaño de la marca de agua
    $watermarkWidth = 200; // ajusta el ancho según tus necesidades
    $watermarkHeight = 100; // ajusta la altura según tus necesidades

    $left = ($pageWidth - $watermarkWidth) / 2;
    $top = ($pageHeight - $watermarkHeight) / 2;

    $canvas->image($watermark, $left, $top, $watermarkWidth, $watermarkHeight);
}
$dompdf->stream("MatriculaAcademica_" . $nombreEstudiante . $apellidoEstudiante . "_Curso_" . $curso, array("Attachment" => false));
?>