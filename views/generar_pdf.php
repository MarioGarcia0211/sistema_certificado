<?php
ob_start();
include "../conexion.php";
$idCurso = $_GET['idCurso'];
$busqueda = $_GET['busqueda'];
$nombreCurso = '';
$nombreProfesor = '';
$apellidoProfesor = '';
$emailProfesor = '';

$query = mysqli_query($conection, "SELECT cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido, usuarios.email FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso = $idCurso");

$result = mysqli_num_rows($query);

if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $nombreCurso = $data['curso'];
        $nombreProfesor = $data['nombre'];
        $apellidoProfesor = $data['apellido'];
        $emailProfesor = $data['email'];
    }
}


?>

<html>

<head>
    <title>Reporte pdf</title>

    <style>
        body {
            text-align: center;
        }

        h3 {
            padding: 20px;
            text-transform: uppercase;
            font-family: "Arial", sans-serif;
        }

        table,
        th,
        td {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            /* Centro el texto */
            font-family: "Arial", sans-serif;
        }
    </style>
</head>

<body>

    <h3>Lista de asistencia del curso <?php echo $nombreCurso . " de la fecha " . $busqueda ?> </h3>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre completo</th>
                <th>Correo electronico</th>
                <th>Documento</th>
                <th>N° del documento</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php


            $query = mysqli_query($conection, "SELECT asistencias.idAsistencia, asistencias.idEstudianteA, asistencias.idCursoA, asistencias.estado, asistencias.fecha, usuarios.nombre, usuarios.apellido, usuarios.idTipoDocumento, usuarios.numeroDocumento, usuarios.email, tipodocumento.tipoDocumento FROM asistencias INNER JOIN usuarios ON asistencias.idEstudianteA = usuarios.idUsuario JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE idCursoA = '$idCurso' AND asistencias.fecha = '$busqueda' ORDER BY `nombre` ASC");

            $result = mysqli_num_rows($query);

            if ($result > 0) {
                while ($data = mysqli_fetch_array($query)) {
            ?>

                    <tr>
                        <td class="align-middle"><?php echo $data["nombre"] . " " . $data["apellido"] ?></td>
                        <td class="align-middle"><?php echo $data["email"] ?></td>
                        <td class="align-middle"><?php echo $data["tipoDocumento"] ?></td>
                        <td class="align-middle"><?php echo $data["numeroDocumento"] ?></td>
                        <?php if ($data['estado'] == 1) {
                            $estado = 'Asistio';
                            $clase = 'text-bg-success';
                        } else {
                            $estado = 'Ausente';
                            $clase = 'text-bg-danger';
                        } ?>

                        <td class="align-middle <?php echo $clase ?>"><?php echo $estado ?></td>
                    </tr>

                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7">No hay registro de asistencia en esta fecha: <?php echo $busqueda ?></td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>

</body>

</html>

<?php
$html = ob_get_clean();

require_once '../libraries/pdf/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();

$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait'); // Puedes probar 'landscape' si es necesario
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf->render();
$dompdf->stream("Asistencia_" . $nombreCurso . "_" . $busqueda . ".pdf", array("Attachment" => false));
?>