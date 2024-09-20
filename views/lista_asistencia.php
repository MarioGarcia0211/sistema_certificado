<?php
include "../conexion.php";
$busqueda = $_GET['id'];
//print_r($_GET);
$nombreCurso = '';
$nombreProfesor = '';
$apellidoProfesor = '';
$emailProfesor = '';

date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a Nueva York
$fechaActual = date("Y-m-d");

$query = mysqli_query($conection, "SELECT cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido, usuarios.email FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso = $busqueda");

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
    <title>Informe de asistencias</title>
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
                    <a class="nav-link" href="mostrar_curso.php?id=<?php echo $busqueda ?>">Curso: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="">Informe asistencia: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            } elseif ($_SESSION['idRol'] == '2') {
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mostrar_curso.php?id=<?php echo $busqueda ?>">Curso: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="">Informe asistencia: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            }
            ?>

        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Listado de asistencia</h1>
                <form class="d-flex" role="search" action="buscar_asistencia.php" method="get">
                    <input id="idCurso" type="hidden" name="idCurso" value="<?php echo $busqueda ?>">
                    <input class="form-control me-2" type="date" value="<?php echo $fechaActual ?>" name="busqueda" id="busqueda" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>

                </form>
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
                                        <th scope="col" data-toggle="tooltip" title="Email">Correo electronico</th>
                                        <th scope="col" data-toggle="tooltip" title="Documento">Documento</th>
                                        <th scope="col" data-toggle="tooltip" title="Número del documento">N° del documento</th>
                                    </tr>
                                </thead>
                                <!-- <tbody class="text-center" id="detalle_tabla">
                            </tbody> -->

                                <tbody class="text-center">
                                    <?php


                                    $query = mysqli_query($conection, "SELECT asistencias.idAsistencia, asistencias.idEstudianteA, asistencias.idCursoA, asistencias.fecha, usuarios.nombre, usuarios.apellido, usuarios.idTipoDocumento, usuarios.numeroDocumento, usuarios.email, tipodocumento.tipoDocumento FROM asistencias INNER JOIN usuarios ON asistencias.idEstudianteA = usuarios.idUsuario JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE idCursoA = '$busqueda' AND asistencias.fecha = '$fechaActual' ORDER BY `nombre` ASC");

                                    $result = mysqli_num_rows($query);

                                    if ($result > 0) {
                                        while ($data = mysqli_fetch_array($query)) {
                                    ?>

                                            <tr>
                                                <td class="align-middle"><?php echo $data["nombre"] ?></td>
                                                <td class="align-middle"><?php echo $data["apellido"] ?></td>
                                                <td class="align-middle"><?php echo $data["email"] ?></td>
                                                <td class="align-middle"><?php echo $data["tipoDocumento"] ?></td>
                                                <td class="align-middle"><?php echo $data["numeroDocumento"] ?></td>
                                            </tr>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7">No hay registro de asistencia en esta fecha: <?php echo $fechaActual ?></td>
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