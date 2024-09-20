<?php
include "../conexion.php";
$idCurso = $_GET['id'];
$nombreCurso = '';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar matricula</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="lista_cursos.php">Lista de cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="mostrar_curso.php?id=<?php echo $idCurso?>">Curso: <?php echo $nombreCurso ?></a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="">Registrar matricula: <?php echo $nombreCurso ?></a>
            </li>

        </ul>
        <h1>Registrar matricula</h1>

        <div class="card">
            <div class="card-header">
                Datos del estudiante
            </div>
            <div class="card-body">
                <form action="" name="form_new_estudiante_matricula" id="form_new_estudiante_matricula">
                    <div class="row align-items-center">
                        <!-- Numero documento -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Número del documento</label>
                            <input class="form-control" type="number" name="nit_estudiante" id="nit_estudiante">
                        </div>
                        <!-- Final numero documento -->

                        <!-- Nombre -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Nombre completo</label>
                            <input class="form-control" type="text" disabled name="nombre" id="nombre">
                        </div>
                        <!-- Final nombre -->


                        <!-- Email -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Correo electronico</label>
                            <input class="form-control" type="text" disabled name="email" id="email">
                        </div>
                        <!-- Final email -->

                        <!-- Tipo documento -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Tipo documento</label>
                            <input class="form-control" type="text" disabled name="tipoDocumento" id="tipoDocumento">
                        </div>
                        <!-- Final Tipo documento -->

                        <!-- Botones -->
                        <div class="form-group col-12 d-flex">

                            <div class="d-grid gap-2 d-md-block mx-auto">

                                <a href="" id="btn_facturar_matricula" class="btn btn-primary " type="button" title="">Procesar</a>

                            </div>
                        </div>

                        <input type="hidden" name="idEstudiante" id="idEstudiante" disabled>

                        <input type="hidden" name="idCurso" id="idCurso" value="<?php echo $idCurso ?>" disabled>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Datos del curso
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- Nombre -->
                    <div class="form-group col-md-3">
                        <label class="form-label">Nombre del curso</label>
                        <input class="form-control" type="text" disabled name="nombreCurso" id="nombreCurso" value="<?php echo $nombreCurso ?>">
                    </div>
                    <!-- Final nombre -->

                    <!-- Nombre -->
                    <div class="form-group col-md-3">
                        <label class="form-label">Nombre del profesor</label>
                        <input class="form-control" type="text" disabled name="nombre" id="nombre" value="<?php echo $nombreProfesor ?>">
                    </div>
                    <!-- Final nombre -->

                    <!-- Apellido -->
                    <div class="form-group col-md-3">
                        <label class="form-label">Apellido del profesor</label>
                        <input class="form-control" type="text" disabled name="apellido" id="apellido" value="<?php echo $apellidoProfesor ?>">
                    </div>
                    <!-- Final apellido -->

                    <!-- Email -->
                    <div class="form-group col-md-3">
                        <label class="form-label">Correo electronico</label>
                        <input class="form-control" type="text" disabled name="email" id="email" value="<?php echo $emailProfesor ?>">
                    </div>
                    <!-- Final email -->

                </div>
            </div>
        </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <script src="js/main.js"></script>
</body>

</html>