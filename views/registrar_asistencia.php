<?php
include "../conexion.php";
$alert = "";
$busqueda = $_GET['id'];
$idCurso = '';
$nombreCurso = '';
$nombreProfesor = '';
$apellidoProfesor = '';
$emailProfesor = '';

date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a Nueva York
$fechaActual = date("Y-m-d");

$query = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido, usuarios.email FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso = $busqueda");

$result = mysqli_num_rows($query);

if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $idCurso = $data['idCurso'];
        $nombreCurso = $data['curso'];
        $nombreProfesor = $data['nombre'];
        $apellidoProfesor = $data['apellido'];
        $emailProfesor = $data['email'];
    }
}

// Procesar el formulario

if (isset($_POST['asistencia']) && is_array($_POST['asistencia'])) {
    $fecha = date('Y-m-d');

    foreach ($_POST['asistencia'] as $idEstudiante => $estadoAsistencia) {
        // Determinar si el estudiante asiste o está ausente
        $asistencia = (!empty($estadoAsistencia) && $estadoAsistencia == 'asiste') ? 1 : 0;

        // Insertar el registro de asistencia en la tabla correspondiente
        //$sql = "INSERT INTO asistencia (estudiante_id, fecha_asistencia, presente) VALUES ($idEstudiante, '$fechaActual', $asistencia)";
        
        $insert = mysqli_query($conection, "INSERT INTO asistencias (idEstudianteA, idCursoA, fecha, estado) VALUES ('$idEstudiante', '$idCurso', '$fechaActual', '$asistencia')");

        //$conexion->query($sql);
    }

    $alert = '<div class="alert alert-success" role="alert">
        <i class="bi bi-check-circle-fill"></i> Asistencias registradas correctamente.
      </div>';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de cursos</title>
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
                    <a class="nav-link active" href="">Lista de asistencia: <?php echo $nombreCurso ?></a>
                </li>
            <?php
            } else {
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mostrar_curso.php?id=<?php echo $busqueda ?>">Curso: <?php echo $nombreCurso ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">Lista de asistencia: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            }
            ?>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Estudiantes del curso</h1>

                <div class="d-plex">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text" id="basic-addon1">Fecha actual</span>
                        <input type="date" class="form-control" aria-describedby="basic-addon1" value="<?php echo $fechaActual ?>" readonly>
                    </div>
                </div>
            </div>
        </nav>

        <div>
            <?php echo isset($alert) ? $alert : ''; ?>
        </div>

        <!-- Estudiantes matriculados-->
        <div class="card border">
            <form action="" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-sm">Registrar asistencia</button>
                        </div>
                        <div class="col-md-8 text-md-end">
                            <p class="card-text fw-medium text-danger">Nota: ¡Haga clic en las casillas de verificación al lado de cada estudiante para tomar asistencia!</p>
                        </div>
                    </div>
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
                                        <th scope="col" data-toggle="tooltip" title="asistió">Verificación</th>
                                    </tr>
                                </thead>
                                <!-- <tbody class="text-center" id="detalle_tabla">
                            </tbody> -->

                                <tbody class="text-center">
                                    <?php

                                    $query = mysqli_query($conection, "SELECT matricula.idMatricula, matricula.idCursoM, matricula.idEstudianteM, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idTipoDocumento, usuarios.numeroDocumento, tipodocumento.tipoDocumento FROM matricula INNER JOIN usuarios ON matricula.idEstudianteM = usuarios.idUsuario JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE (matricula.estado = 1 AND idCursoM = '$busqueda' AND usuarios.estado = 1) ORDER BY `nombre` ASC");

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

                                                <td class="align-middle">
                                                    <input type="hidden" name="asistencia[<?php echo $data['idEstudianteM'] ?>]" value="0">
                                                    <input class="form-check-input" type="checkbox" value="asiste" name="asistencia[<?php echo $data['idEstudianteM'] ?>]">
                                                </td>
                                            </tr>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7">No hay estudiantes matriculados</td>
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
    <!-- Final Estudiantes matriculados -->

    <?php include "includes/footer.php"; ?>
    <script src="js/main.js"></script>
</body>

</html>