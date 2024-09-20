<?php
include "../conexion.php";
$busqueda = $_GET['id'];
$nombreCurso = '';
$nombreProfesor = '';
$apellidoProfesor = '';
$emailProfesor = '';
$descripcion = '';
$horaInicio = '';
$horaFinal = '';
$precio = '';

date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a Nueva York
$fechaActual = date("Y-m-d");

$query = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, cursos.descripcion, cursos.horaInicio, cursos.horaFin, cursos.precio, usuarios.nombre, usuarios.apellido, usuarios.email FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso = $busqueda");

$result = mysqli_num_rows($query);

if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $nombreCurso = $data['curso'];
        $nombreProfesor = $data['nombre'];
        $apellidoProfesor = $data['apellido'];
        $emailProfesor = $data['email'];
        $descripcion = $data['descripcion'];
        $horaInicio = $data['horaInicio'];
        $horaFinal = $data['horaFin'];
        $precio = number_format($data['precio'], 2);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de <?php echo $nombreCurso ?></title>
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
                    <a class="nav-link active" href="">Curso: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            } elseif ($_SESSION['idRol'] == '2' || $_SESSION['idRol'] == '3') {
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="">Curso: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            }
            ?>

        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1><?php echo $nombreCurso ?></h1>

                <div>
                    <?php if ($_SESSION['idRol'] == '1') { ?>
                        <a type="button" class="btn btn-primary btn-sm" href="registrar_matricula.php?id=<?php echo $busqueda ?>">Matricular estudiante</a>

                    <?php } ?>
                    
                    <?php if ($_SESSION['idRol'] == '1' || $_SESSION['idRol'] == '2') { ?>
                        <a type="button" class="btn btn-warning btn-sm" href="lista_notas.php?id=<?php echo $busqueda ?>">Notas</a>    
                    <a type="button" class="btn btn-success btn-sm" href="registrar_asistencia.php?id=<?php echo $busqueda ?>">Tomar asistencia</a>
                    <a type="button" class="btn btn-secondary btn-sm" href="buscar_asistencia.php?idCurso=<?php echo $busqueda ?>&busqueda=<?php echo $fechaActual ?>">Informe de asistencia</a>
                    <?php } ?>
                </div>
            </div>
        </nav>


        <!-- Datos curso -->
        <div class="card">
            <div class="card-header">
                Datos de la clase
            </div>
            <div class="card-body">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="miTextarea" id="miTextarea" rows="3" oninput="autoajustarTextarea(this)" disabled><?php echo $descripcion ?></textarea>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="form-group col-md-4">
                        <label class="form-label">Hora de inicio</label>
                        <input class="form-control" type="time" disabled name="inicio" id="inicio" value="<?php echo $horaInicio ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Hora final</label>
                        <input class="form-control" type="time" disabled name="final" id="final" value="<?php echo $horaFinal ?>">
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label">Precio</label>
                        <input class="form-control" type="text" disabled name="precio" id="precio" value="$<?php echo $precio ?>">
                    </div>
                </div>
            </div>
        </div>
        <!-- Final datos curso -->

        <!-- Datos profesor -->
        <div class="card">
            <div class="card-header">
                Datos del profesor
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- Nombre -->
                    <div class="form-group col-md-4">
                        <label class="form-label">Nombre del profesor</label>
                        <input class="form-control" type="text" disabled name="nombre" id="nombre" value="<?php echo $nombreProfesor ?>">
                    </div>
                    <!-- Final nombre -->

                    <!-- Apellido -->
                    <div class="form-group col-md-4">
                        <label class="form-label">Apellido del profesor</label>
                        <input class="form-control" type="text" disabled name="apellido" id="apellido" value="<?php echo $apellidoProfesor ?>">
                    </div>
                    <!-- Final apellido -->

                    <!-- Email -->
                    <div class="form-group col-md-4">
                        <label class="form-label">Correo electronico</label>
                        <input class="form-control" type="text" disabled name="email" id="email" value="<?php echo $emailProfesor ?>">
                    </div>
                    <!-- Final email -->
                </div>
            </div>
        </div>
        <!-- Final datos profesor -->

        <!-- Estudiantes matriculados-->
        <div class="card">
            <div class="card-header">
                Estudiantes matriculados
            </div>

            <div class="card-body">
                <div class="contenido-tabla">
                    <div class="table-responsive">
                        <table class="table table-bordered table-fixed table-striped">
                            <thead class="cabecera text-center">
                                <tr>
                                    <th scope="col" data-toggle="tooltip" title="Nombre">Nombre del estudiante</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido">Apellido del estudiante</th>
                                    <th scope="col" data-toggle="tooltip" title="Email">Correo electronico</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">Documento</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">N° del documento</th>
                                </tr>
                            </thead>
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
        </div>
        <!-- Final Estudiantes matriculados -->
    </div>

    <?php include "includes/footer.php"; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var textarea = document.getElementById("miTextarea");
            autoajustarTextarea(textarea);
        });

        function autoajustarTextarea(elemento) {
            elemento.style.height = "auto";
            elemento.style.height = (elemento.scrollHeight + 10) + "px";
        }
    </script>
</body>

</html>