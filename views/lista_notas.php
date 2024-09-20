<?php
include "../conexion.php";
$idCurso = $_GET['id'];
//print_r($_GET);
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de curso <?php echo $nombreCurso ?></title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">

            <?php
            if ($_SESSION['idRol'] == '1') {
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="lista_cursos.php">Lista de cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mostrar_curso.php?id=<?php echo $idCurso ?>">Curso: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="">Notas: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            } elseif ($_SESSION['idRol'] == '2') {
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mostrar_curso.php?id=<?php echo $idCurso ?>">Curso: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="">Notas: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            }
            ?>

        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Listado de notas</h1>
            </div>
        </nav>

        <div class="card border">
            <form action="" method="post">
                <div class="card-body">
                    <div class="contenido-tabla mt-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-fixed table-striped">
                                <thead class="cabecera text-center">
                                    <tr>
                                        <th scope="col" data-toggle="tooltip" title="Nombre">Nombre del estudiante</th>
                                        <th scope="col" data-toggle="tooltip" title="Apellido">Apellido del estudiante</th>
                                        <th scope="col" data-toggle="tooltip" title="Nota 1">Nota 1</th>
                                        <th scope="col" data-toggle="tooltip" title="30% Nota 1">30%</th>
                                        <th scope="col" data-toggle="tooltip" title="Nota 2">Nota 2</th>
                                        <th scope="col" data-toggle="tooltip" title="30% Nota 2">30%</th>
                                        <th scope="col" data-toggle="tooltip" title="Nota 3">Nota 3</th>
                                        <th scope="col" data-toggle="tooltip" title="30% Nota 3">30%</th>
                                        <th scope="col" data-toggle="tooltip" title="Total asistencia">Total asistencia</th>
                                        <th scope="col" data-toggle="tooltip" title="10% Asistencia">10%</th>
                                        <th scope="col" data-toggle="tooltip" title="Definitiva">Nota Definitiva</th>
                                        <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                    </tr>
                                </thead>
                                <!-- <tbody class="text-center" id="detalle_tabla">
                            </tbody> -->

                                <tbody class="text-center">
                                    <?php


                                    $query = mysqli_query($conection, "SELECT notas.idNota, notas.idEstudiante, notas.idCurso, notas.notaUno, notas.notaDos, notas.notaTres, notas.notaDefinitiva, usuarios.nombre, usuarios.apellido, COUNT(CASE WHEN asistencias.estado = 1 AND asistencias.idCursoA = '$idCurso' THEN 1 END) AS totalAsistencias FROM notas INNER JOIN usuarios ON notas.idEstudiante = usuarios.idUsuario LEFT JOIN asistencias ON notas.idEstudiante = asistencias.idEstudianteA WHERE idCurso = '$idCurso' AND notas.estado = 1 GROUP BY(usuarios.nombre) ORDER BY `nombre` ASC;");

                                    $result = mysqli_num_rows($query);

                                    if ($result > 0) {
                                        while ($data = mysqli_fetch_array($query)) {

                                            $nota_uno_30 = $data['notaUno'] * 0.30;
                                            $nota_dos_30 = $data['notaDos'] * 0.30;
                                            $nota_tres_30 = $data['notaTres'] * 0.30;
                                            $asistencia_10 = $data['totalAsistencias'] * 0.10;
                                            
                                    ?>

                                            <tr>
                                                <td class="align-middle"><?php echo $data["nombre"] ?></td>
                                                <td class="align-middle"><?php echo $data["apellido"] ?></td>
                                                <td class="align-middle"><?php echo $data["notaUno"] ?></td>
                                                <td class="align-middle"><?php echo $nota_uno_30 ?></td>
                                                <td class="align-middle"><?php echo $data["notaDos"] ?></td>
                                                <td class="align-middle"><?php echo $nota_dos_30 ?></td>
                                                <td class="align-middle"><?php echo $data["notaTres"] ?></td>
                                                <td class="align-middle"><?php echo $nota_tres_30 ?></td>
                                                <td class="align-middle"><?php echo $data["totalAsistencias"] ?></td>
                                                <td class="align-middle"><?php echo $asistencia_10 ?></td>
                                                <td class="align-middle"><?php echo $data["notaDefinitiva"] ?></td>
                                                <td class="align-middle">
                                                    <div class="d-grid gap-2 d-md-block">

                                                        <a href="editar_notas.php?idE=<?php echo $data["idEstudiante"] ?>&idC=<?php echo $idCurso ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>

                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="20">No hay estudiantes matriculados</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>